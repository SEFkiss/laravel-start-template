<?php

namespace App\Orchid\Screens;

use App\User;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EmailSenderScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Отправка писем';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Инструмент для отправки писем';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'subject' => date('F').' Company news'
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
            Button::make('Send Message')
                ->icon('icon-paper-plane')
                ->method('sendMessage')
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
                Input::make('subject')
                    ->title('Subject')
                    ->required()
                    ->placeholder('Message subject line')
                    ->help('Enter the subject line for you message'),
                
                Relation::make('users.')
                    ->title('Recipients')
                    ->multiple()
                    ->required()
                    ->placeholder('Email address')
                    ->help('Enter the users')
                    ->fromModel(User::class, 'name', 'email'),

                Quill::make('content')
                    ->title('Content')
                    ->required()
                    ->placeholder('Insert text here...')
                    ->help('Add the content for the message')
            ]),
        ];
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'subject' => 'required|min:6|max:50',
            'users' => 'required',
            'content' => 'required|min:10'
        ]);
        //Disabled function sender email
        /*Mail::raw($request->get('content'), function(Message $message) use ($request)
        {
            $message->subject($request->get('subject'));

            foreach($request->get('users') as $email){
                $message->to($email);
            }
        });*/

        Alert::info('You email message has been sent successfully.');
        return back();
    }
}
