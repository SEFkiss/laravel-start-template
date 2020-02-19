<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, Attachable;

    protected $fillable = [
        'title',
        'description',
        'body',
        'author',
        'hero'
    ];

    public function hero ()
    {
        return $this->hasOne(Attachment::class, 'id', 'hero');
    }
}
