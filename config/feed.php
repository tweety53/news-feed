<?php
declare(strict_types=1);

$currentTime = time();

return [
    'feed' => [
        'current_source' => 'rbc',
        'sources' => [
            'rbc' => [
                'base_uri' => 'https://www.rbc.ru/',
                'url' => "https://www.rbc.ru/v10/ajax/get-news-feed/project/spb_sz/lastDate/{$currentTime}/limit/30?_={$currentTime}",
                'list_params' => [
                    'selector' => 'a.news-feed__item',
                ],
                'title_params' => [
                    'selector' => 'div.article__header__title'
                ],
                'description_params' => [
                    'selector' => 'div.article__content > div.article__text > p',
                    'short_description_length' => 200,
                ],
                'image_params' => [
                    'selector' => 'div.article__main-image > div.article__main-image__wrap > img.article__main-image__image',
                ],
            ],
        ],
    ],
];