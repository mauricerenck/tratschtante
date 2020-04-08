<?php

namespace Plugin\Traschtante;

use Kirby\Http\Url;
use Kirby\Toolkit\V;
use Kirby\Toolkit\Str;
use json_decode;
use json_encode;
use is_null;
use preg_split;
use str_replace;
use date;

class WebmentionReceiver
{
    public function getPageFromUrl(string $url)
    {
        if (V::url($url)) {
            $path = Url::path($url);
            $languages = kirby()->languages();

            if ($languages->count() > 0) {
                foreach ($languages as $language) {
                    $path = str_replace($language . '/', '', $path);
                }
            }

            $targetPage = page($path);

            if (is_null($targetPage)) {
                return null;
            }

            return $targetPage;
        }

        return null;
    }

    public function getWebmentionType(string $wmProperty)
    {
        /*
            in-reply-to
            like-of
            repost-of
            bookmark-of
            mention-of
            rsvp
        */
        switch ($wmProperty) {
            case 'like-of': return 'LIKE';
            case 'in-reply-to': return 'REPLY';
            case 'repost-of': return 'REPOST'; // retweet z.b.
            default: return 'REPLY';
        }
    }

    public function getAuthor($webmention)
    {
        $authorInfo = $webmention->post->author;

        return [
            'type' => (isset($authorInfo->type)) ? $authorInfo->type : null,
            'name' => (isset($authorInfo->name)) ? $authorInfo->name : null,
            'avatar' => (isset($authorInfo->photo)) ? $authorInfo->photo : null,
            'url' => (isset($authorInfo->url)) ? $authorInfo->url : null,
        ];
    }
}
