<?php
/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 14/06/2016
 * Time: 04:33 AM
 */

namespace Notes\Library;


class Utils
{

    public function downloadImage($url, $imgName)
    {
        // Create a stream
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: en\r\n" 
//                  TODO: Move getCookies to Library class
//                    "Cookie: " . getCookies()[1] . "=" . getCookies()[0]
            )
        );

        $context = stream_context_create($opts);

        file_put_contents($imgName, file_get_contents($url, false, $context));
    }
}