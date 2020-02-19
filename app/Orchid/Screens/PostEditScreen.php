<?php

namespace App\Orchid\Screens;

use App\Post;
use App\User;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Screen;

class PostEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создание нового поста';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Посты блога';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Post $post): array
    {
        $this->exists = $post->exists; //Проверка на существование модели
        if($this->exists){
            $this->name = 'Редактирование поста';
        }
        $post->load('attachment');
        return [
            'post' => $post
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
            Button::make('Создать пост')
                ->icon('icon-pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
            Button::make('Обновление')
                ->icon('icon-note')
                ->method('createOrUpdate')
                ->canSee($this->exists),
            Button::make('Удалить')
                ->icon('icon-trash')
                ->method('remove')
                ->canSee($this->exists),
            
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
            Layout::rows([
                Input::make('post.title')
                    ->title('Заголовок')
                    ->placeholder('Название поста...')
                    ->help('Введите название поста в это окно...'),

                Cropper::make('post.hero')
                    ->title('Large web banner image...')
                    ->width(1000)
                    ->height(500)
                    ->targetId(),

                TextArea::make('post.description')
                    ->title('Описание поста')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Введите описание поста...'),

                Relation::make('post.author')
                    ->title('Автор')
                    ->fromModel(User::class, 'name'),

                Quill::make('post.body')
                    ->title('Тест поста'),

                Upload::make('post.attachment')
                    ->title('All files'),

            ])
        ];
    }

    public function createOrUpdate(Post $post, Request $request)
    {
        $post->fill($request->get('post'))->save();
        $post->attachment()->syncWithoutDetaching(
            $request->input('post.attachment', [])
        );
        Alert::info('Пост успешно создан');

        return redirect()->route('platform.post.list');
    }

    public function remove(Post $post)
    {
        $post->delete()
            ? Alert::info('Пост успешно удален!')
            : Alert::warning('Ошибка удаления')
        ;

        return redirect()->route('platform.post.list');
    }
}
