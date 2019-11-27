<?php

namespace App\Console\Commands;

use App\Feed\Parser\ParserConfig;
use App\Feed\Parser\Service\NewsFeedParsingService;
use App\NewsItem;
use Illuminate\Console\Command;

/**
 * Class ParseNews
 * @package App\Console\Commands
 */
class ParseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses first N news from RBC.ru news feed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Facade\Ignition\Exceptions\InvalidConfig
     */
    public function handle()
    {
        ParserConfig::init();

        $data = (new NewsFeedParsingService())->getData(new ParserConfig());

        foreach ($data as $datum) {
            $newsItem = new NewsItem();
            $newsItem->title = $datum['title'];
            $newsItem->description = $datum['description'];
            $newsItem->short_description = $datum['short_description'];
            $newsItem->image_url = $datum['image_url'];
            $newsItem->created_at = $datum['created_at'];

            $newsItem->save();
        }
    }
}
