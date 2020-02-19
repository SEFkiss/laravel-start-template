<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;

class IdeaScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Идея';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'На миллион';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'name' => 'Svjatoslav Torn'
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
            Button::make('Отправить идею')
                ->icon('icon-paper-plane')
                ->method('sendIdea'),
            Link::make('Внешняя ссылка')
                ->href('https://всепесни.рф'),
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
            
        ];
    }

    public function sendIdea()
    {
        Alert::info('Идея успешно отправлена!!!');
        return back();
    }
}
