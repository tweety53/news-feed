<?php
/**
 * NewsFeedParsingService.php
 *
 * Created: 11/27/19 2:25 PM
 * User: tweety53
 * Project: feed
 */

namespace App\Feed\Parser\Service;


use App\Feed\Parser\ParserConfig;
use App\Feed\UrlFetcher;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class NewsFeedParsingService
 * @package App\Feed\Parser\Service
 */
class NewsFeedParsingService
{
    public const MAX_URLS = 15;

    /**
     * @param ParserConfig $parserConfig
     * @return array
     * @throws \Exception
     */
    public function getData(ParserConfig $parserConfig): array
    {
        $newsItemUrls = [];
        $newsItemDates = [];
        $result = [];

        $dataJson = UrlFetcher::fetch($parserConfig::getUrl());

        $data = json_decode($dataJson, true)['items'];

        foreach ($data as $datum) {
            $crawler = new Crawler(null, $parserConfig::getBaseUri());
            $crawler->addHtmlContent($datum['html'], 'UTF-8');

            $newsItemUrl = $crawler->filter($parserConfig::getListParams()['selector'])->attr('href');

            if (false === strpos($newsItemUrl, $parserConfig::getBaseUri())) {
                continue;
            }

            $newsItemUrls[] = $newsItemUrl;
            $newsItemDates[] = date('Y-m-d H:i:s', $datum['publish_date_t']);

            if (self::MAX_URLS === \count($newsItemUrls)) {
                break;
            }
        }

        foreach ($newsItemUrls as $idx => $newsItemUrl) {

            $html = UrlFetcher::fetch($newsItemUrl);

            $crawler = new Crawler(null, $parserConfig::getBaseUri());
            $crawler->addHtmlContent($html, 'UTF-8');

            $title = $crawler->filter($parserConfig::getTitleParams()['selector'])->text() ?? '';

            $description = '';

            $crawler->filter($parserConfig::getDescriptionParams()['selector'])->each(
                function (Crawler $node) use (&$description) {
                    $description .= strip_tags(mb_convert_encoding($node->text(), 'UTF-8')) . '<br><br>';
                });

            $imageUrl = $crawler->filter($parserConfig::getImageParams()['selector'])->attr('src');

            $descriptionWithoutNewLines = str_replace('<br><br>','', $description);

            $result[] = [
                'title' => $title,
                'description' => $description,
                'short_description' =>
                    mb_strlen($descriptionWithoutNewLines, 'UTF-8') <= $parserConfig::getDescriptionParams()['short_description_length']
                        ? $descriptionWithoutNewLines
                        : mb_substr($descriptionWithoutNewLines, 0, $parserConfig::getDescriptionParams()['short_description_length'], 'UTF-8'),
                'image_url' => $imageUrl,
                'created_at' => $newsItemDates[$idx],
            ];
        }

        return $result;
    }
}