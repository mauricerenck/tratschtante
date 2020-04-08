<?php

namespace Plugin\Traschtante;

use Kirby;

@include_once __DIR__ . '/vendor/autoload.php';

load([
    'Plugin\Traschtante\WebmentionReceiver' => 'utils/receiver.php'
], __DIR__);

Kirby::plugin('mauricerenck/tratschtante', [
    'options' => require_once(__DIR__ . '/config/options.php'),
    'routes' => [
        [
            'pattern' => 'tratschtante/webhook/webmentionio',
            'method' => 'POST',
            'action' => function () {
                $response = json_decode(file_get_contents('php://input'));
                $receiver = new WebmentionReceiver();
                $webmention = [];

                if ($response->secret !== option('mauricerenck.tratschtante.secret')) {
                    return 'PAGE NOT FOUND';
                }

                $targetPage = $receiver->getPageFromUrl($response->post->{'wm-target'});
                if (is_null($targetPage)) {
                    return 'PAGE NOT FOUND';
                }

                $webmention['type'] = $receiver->getWebmentionType($response->post->{'wm-property'});
                $webmention['target'] = $response->post->{'wm-target'};
                $webmention['source'] = $response->post->{'wm-source'};
                $webmention['published'] = $response->post->published;
                $webmention['author'] = $receiver->getAuthor($response);
                $webmention['content'] = (isset($response->post->content) && isset($response->post->content->text)) ? $response->post->content->text : '';

                kirby()->trigger('tratschtante.webhook.received', $webmention, $targetPage);

                return 'THANKS';
            }
        ],
    ]
]);
