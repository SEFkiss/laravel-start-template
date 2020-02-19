<?php

namespace App\Orchid\Layouts;

use App\Post;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class PostListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'posts';

    /**
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::set('title', 'Название')
                ->render(function(Post $post){
                    return Link::make($post->title)
                        ->route('platform.post.edit', $post);
                }),
            TD::set('created_at', 'Создано'),
            TD::set('update_at', 'Обновлено'),
        ];
    }
}
