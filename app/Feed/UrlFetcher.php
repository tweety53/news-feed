<?php
declare(strict_types=1);

namespace App\Feed;

use Exception;

/**
 * Class UrlFetcher
 * @package App\Feed
 */
class UrlFetcher
{
    /**
     * @param string $url
     * @return bool|string
     * @throws Exception
     */
    public static function fetch(string $url): string
    {
        $handler = curl_init();

        curl_setopt($handler, CURLOPT_URL, $url);
        curl_setopt($handler, CURLOPT_POST, false);
        curl_setopt($handler, CURLOPT_BINARYTRANSFER, false);
        curl_setopt($handler, CURLOPT_HEADER, true);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($handler, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $response = curl_exec($handler);
        $hlength = curl_getinfo($handler, CURLINFO_HEADER_SIZE);
        $httpCode = curl_getinfo($handler, CURLINFO_HTTP_CODE);
        $body = substr($response, $hlength);

        if (200 !== $httpCode) {
            throw new Exception($httpCode);
        }

        return $body;
    }
}