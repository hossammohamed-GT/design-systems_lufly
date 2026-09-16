<?php

declare(strict_types=1);

return [
    // Transports: log (writes to storage/logs/mail.log), smtp (requires PHP mail setup on XAMPP).
    'transport' => env('MAIL_TRANSPORT', 'log'),

    'from_address' => env('MAIL_FROM_ADDRESS', 'no-reply@lufly.test'),
    'from_name' => env('MAIL_FROM_NAME', 'Lufly Platform'),

    'smtp' => [
        'host' => env('MAIL_HOST', '127.0.0.1'),
        'port' => (int) env('MAIL_PORT', 1025),
        'username' => env('MAIL_USERNAME', ''),
        'password' => env('MAIL_PASSWORD', ''),
        'encryption' => env('MAIL_ENCRYPTION', ''),
    ],
];
