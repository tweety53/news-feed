<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsItem
 * @package App
 */
class NewsItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'short_description', 'image_url'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getShortDescriptionAttribute($value): string
    {
        return 200 === mb_strlen($value, 'UTF-8') ? $value . '...' : $value;
    }
}
