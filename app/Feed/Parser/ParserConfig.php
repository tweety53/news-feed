<?php
/**
 * ParserConfig.php
 *
 * Created: 11/27/19 2:30 PM
 * User: tweety53
 * Project: feed
 */

namespace App\Feed\Parser;

use Facade\Ignition\Exceptions\InvalidConfig;

/**
 * Class ParserConfig
 * @package App\Feed\Parser
 */
class ParserConfig
{
    /**
     * @var string
     */
    private static $baseUri;

    /**
     * @var string
     */
    private static $url;

    /**
     * @var array
     */
    private static $listParams;

    /**
     * @var array
     */
    private static $titleParams;

    /**
     * @var array
     */
    private static $descriptionParams;

    /**
     * @var array
     */
    private static $imageParams;

    /**
     * @throws InvalidConfig
     */
    public static function init(): void
    {
        $feedConfig = config('feed', []);

        if (empty($feedConfig)) {
            throw new InvalidConfig('Cannot find \'feed\' key config in app configuration.');
        }

        $feedConfig = $feedConfig['feed'];

        $currentSource = $feedConfig['current_source'] ?? '';

        if (empty($currentSource)) {
            throw new InvalidConfig('You must provide parsing source.');
        }

        $parserConfig = $feedConfig['sources'][$currentSource] ?? [];

        if (empty($parserConfig)) {
            throw new InvalidConfig('Cannot find configuration for specified parsing source.');
        }

        self::$baseUri = $parserConfig['base_uri'] ?? '';

        if (empty(self::$baseUri)) {
            throw new InvalidConfig('You must provide base_uri for specified parsing source.');
        }

        self::$url = $parserConfig['url'] ?? '';

        if (empty(self::$url)) {
            throw new InvalidConfig('You must provide url for specified parsing source.');
        }

        self::$listParams = $parserConfig['list_params'];
        self::$titleParams = $parserConfig['title_params'];
        self::$descriptionParams = $parserConfig['description_params'];
        self::$imageParams = $parserConfig['image_params'];
    }

    /**
     * @return string
     */
    public static function getBaseUri(): string
    {
        return self::$baseUri;
    }

    /**
     * @return string
     */
    public static function getUrl(): string
    {
        return self::$url;
    }

    /**
     * @return array
     */
    public static function getListParams(): array
    {
        return self::$listParams;
    }

    /**
     * @return array
     */
    public static function getTitleParams(): array
    {
        return self::$titleParams;
    }

    /**
     * @return array
     */
    public static function getDescriptionParams(): array
    {
        return self::$descriptionParams;
    }

    /**
     * @return array
     */
    public static function getImageParams(): array
    {
        return self::$imageParams;
    }
}