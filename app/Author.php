<?php
/**
 * Created by PhpStorm.
 * User: vedran.bojicic
 * Date: 28.02.2019
 * Time: 15:12 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

    protected $table= 'authors';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'github', 'twitter', 'location', 'latest_article_published'
    ];


}