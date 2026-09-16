<?php

declare(strict_types=1);

namespace App\Services;

use Core\Logging\Log;

class MailService
{
    /** @param array<string, string> $headers */
    public function send(string $to, string $subject, string $body, array $headers = []): bool
    {
        $transport = (string) config('mail.transport', 'log');
        $fromAddress = (string) config('mail.from_address');
        $fromName = (string) config('mail.from_name');

        $allHeaders = array_merge([
            'From' => $fromName . ' <' . $fromAddress . '>',
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/html; charset=UTF-8',
        ], $headers);

        $headerString = implode("\r\n", array_map(
            static fn ($k, $v) => $k . ': ' . $v,
            array_keys($allHeaders),
            $allHeaders,
        ));

        $sent = false;
        if ($transport === 'smtp') {
            $sent = @mail($to, $subject, $body, $headerString);
        }

        Log::channel('mail')->info('mail.dispatch', [
            'transport' => $transport,
            'to' => $to,
            'subject' => $subject,
            'sent' => $sent,
        ]);

        return $transport === 'log' ? true : $sent;
    }

    /** @param string[] $recipients */
    public function sendToMany(array $recipients, string $subject, string $body): int
    {
        $count = 0;
        foreach ($recipients as $recipient) {
            if ($this->send($recipient, $subject, $body)) {
                $count++;
            }
        }

        return $count;
    }
}
