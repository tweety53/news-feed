<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\NewsItem;

/**
 * Class NewsItemController
 * @package App\Http\Controllers\Feed
 */
class NewsItemController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $news = NewsItem::select(['id', 'created_at', 'title', 'short_description'])->paginate(10);

        return view('news_item.index', ['news' => $news]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(int $id)
    {
        $newsItem = NewsItem::select(['id', 'created_at', 'title', 'description', 'image_url'])->findOrFail($id);

        return view('news_item.view', ['newsItem' => $newsItem]);
    }
}