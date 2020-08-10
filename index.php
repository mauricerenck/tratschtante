<?php

namespace Plugin\Traschtante;

use Kirby;

@include_once __DIR__ . '/vendor/autoload.php';

load([
    'Plugin\Traschtante\WebmentionReceiver' => 'utils/receiver.php',
    'Plugin\Traschtante\HookHelper' => 'utils/hookHelper.php'
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
                $hookHelper = new HookHelper();
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
                $webmention['published'] = (!is_null($response->post->published)) ? $response->post->published : $response->post->{'wm-received'};
                $webmention['content'] = (isset($response->post->content) && isset($response->post->content->text)) ? $response->post->content->text : '';
                $webmention['author'] = $receiver->getAuthor($response);

                if ($webmention['type'] === 'MENTION') {
                    if (is_null($webmention['author']['name'])) {
                        $webmention['author']['name'] = $webmention['source'];
                    }
                    if (is_null($webmention['author']['url'])) {
                        $webmention['author']['url'] = $webmention['source'];
                    }
                }

                $hookHelper->triggerHook('tratschtante.webhook.received', $webmention, $targetPage);

                return $webmention;
            }
        ],
    ]
]);
