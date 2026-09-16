# Logging

## Channels

Configured in `config/logging.php`; files land in `storage/logs/`:

| Channel | File | Written by |
| --- | --- | --- |
| `app` | `app.log` | general application events, activity log mirror |
| `error` | `error.log` | global exception handler |
| `database` | `database.log` | every SQL statement + bindings |
| `api` | `api.log` | API middleware (endpoint, method, status, ms, ip) |
| `security` | `security.log` | failed logins, permission denials, login/logout |
| `mail` | `mail.log` | every mail dispatch (transport, recipient, subject) |

## API

```php
use Core\Logging\Log;

Log::info('order.placed', ['order_id' => 42]);
Log::warning(...); Log::error(...); Log::critical(...);
Log::channel('security')->warning('Permission denied', [...]);
logger('message', ['ctx' => 1], 'info', 'app');   // helper
```

Format: `[2026-09-16 12:00:00] app.INFO: message {"order_id":42}`.
Levels follow RFC 5424; `LOG_LEVEL` in `.env` sets the minimum.

## Activity logs (database)

`App\Services\ActivityLogger` persists to `activity_logs` and tracks:
create, update, delete, login, logout, settings changes.

```php
app(\App\Services\ActivityLogger::class)->created('product', $id, ['slug' => $slug]);
```

## Audit trail

`App\Services\AuditService` records before/after snapshots per entity mutation
(used automatically by repositories with `$auditing = true`).

## Security logs

`App\Services\SecurityLogger` + the auth layer write structured security events
(failed login, lockouts, permission denied, login/logout) to `security.log`.

## Aggregation

`App\Services\LogService` exposes `activity()`, `audit()`, `security()` and generic
`info()/error()` behind one injectable entry point.
