<?php

namespace mauricerenck\Traschtante;

use Kirby;

Kirby::plugin('mauricerenck/hooklogger', [
    'hooks' => [
        'tratschtante.webhook.received' => function ($webmention, $targetPage) {
            if (option('mauricerenck.tratschtante.debug', false) === true) {
                $time = time();
                file_put_contents('webmentionhook.' . $time . '.json', json_encode($webmention));
            }
        }
    ]
]);
