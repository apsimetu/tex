<?php

namespace tex\utils;

class TwigExtensions extends \Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'tex';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('showLikeButton', [$this, 'showLikeButton']),
        ];
    }

    public function showLikeButton($betId, $likeCount)
    {
        $url = "http://nimbo.lt/tex/{$betId}/";

        $fql = "SELECT share_count, like_count, comment_count ";
        $fql .= " FROM link_stat WHERE url = '{$url}'";

        $fqlURL = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);

        $response = json_decode(file_get_contents($fqlURL));
        $fbLikeCount = $response[0]->like_count;

        return $fbLikeCount <= $likeCount;
    }
}