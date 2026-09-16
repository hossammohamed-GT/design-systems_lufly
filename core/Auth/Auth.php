<?php

declare(strict_types=1);

namespace Core\Auth;

use Core\Contracts\UserProviderInterface;
use Core\Http\Session;
use Core\Logging\Log;

class Auth
{
    private ?object $cachedUser = null;

    /** @var string[]|null */
    private ?array $cachedPermissions = null;

    public function __construct(
        private readonly Session $session,
        private readonly UserProviderInterface $users,
    ) {
    }

    public function attempt(string $email, string $password): bool
    {
        if ($this->isLocked($email)) {
            Log::channel('security')->warning('Login attempt while locked out', ['email' => $email]);
            return false;
        }

        $user = $this->users->findByEmail($email);

        if ($user === null || ($user->status ?? 'active') !== 'active' || !password_verify($password, (string) ($user->password ?? ''))) {
            $this->registerFailedAttempt($email);
            Log::channel('security')->warning('Failed login', ['email' => $email]);

            return false;
        }

        $this->session->regenerate();
        $this->session->set('_auth_id', $user->id);
        $this->clearAttempts($email);
        $this->cachedUser = $user;

        Log::channel('security')->info('Login successful', ['user_id' => $user->id, 'email' => $email]);

        return true;
    }

    public function check(): bool
    {
        return $this->id() !== null;
    }

    public function id(): int|string|null
    {
        return $this->session->get('_auth_id');
    }

    public function user(): ?object
    {
        if ($this->cachedUser !== null) {
            return $this->cachedUser;
        }

        $id = $this->id();
        if ($id === null) {
            return null;
        }

        return $this->cachedUser = $this->users->findById($id);
    }

    public function userCan(string $permission): bool
    {
        $user = $this->user();
        if ($user === null) {
            return false;
        }

        if ($this->cachedPermissions === null) {
            $this->cachedPermissions = $this->users->permissionsFor($user->id);
        }

        return in_array('*', $this->cachedPermissions, true)
            || in_array($permission, $this->cachedPermissions, true);
    }

    public function logout(): void
    {
        Log::channel('security')->info('Logout', ['user_id' => $this->id()]);

        $this->session->remove('_auth_id');
        $this->session->regenerate();
        $this->cachedUser = null;
        $this->cachedPermissions = null;
    }

    private function isLocked(string $email): bool
    {
        $attempts = (array) $this->session->get('_login_attempts', []);
        $entry = $attempts[$email] ?? null;

        return is_array($entry)
            && ($entry['count'] ?? 0) >= (int) config('security.login_max_attempts', 5)
            && ($entry['locked_until'] ?? 0) > time();
    }

    private function registerFailedAttempt(string $email): void
    {
        $attempts = (array) $this->session->get('_login_attempts', []);
        $count = (int) (($attempts[$email]['count'] ?? 0) + 1);

        $attempts[$email] = [
            'count' => $count,
            'locked_until' => $count >= (int) config('security.login_max_attempts', 5)
                ? time() + (int) config('security.login_lockout_seconds', 300)
                : 0,
        ];

        $this->session->set('_login_attempts', $attempts);
    }

    private function clearAttempts(string $email): void
    {
        $attempts = (array) $this->session->get('_login_attempts', []);
        unset($attempts[$email]);
        $this->session->set('_login_attempts', $attempts);
    }
}
