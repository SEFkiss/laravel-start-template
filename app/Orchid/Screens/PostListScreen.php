<?php

namespace App\Orchid\Screens;

use App\Post;
use Orchid\Screen\Screen;
use App\Orchid\Layouts\PostListLayout;
use Orchid\Screen\Actions\Link;

class PostListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Посты';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Список постов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'posts' => Post::paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Создать новый пост')
                ->icon('icon-pencil')
                ->route('platform.post.edit')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            PostListLayout::class
        ];
    }
}
