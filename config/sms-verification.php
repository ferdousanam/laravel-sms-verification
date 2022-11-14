<?php

use App\Notifications\SmsChannel;

return [
    'sms-channels' => [
        'sms' => [
            'driver' => SmsChannel::class,
        ],
    ],
];
