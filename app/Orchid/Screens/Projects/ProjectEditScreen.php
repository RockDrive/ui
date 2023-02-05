<?php

namespace App\Orchid\Screens\Projects;

use App\Models\Server;
use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectEditScreen extends Screen
{
    public $name = "Сервер";
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Server $server): iterable
    {
        $this->name = $server["name"];
        return [
            'user' => User::firstOrFail(),
        ];
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Детальная информация сервера';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return array
     * @throws \Throwable
     *
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('user', [
                Sight::make('id')->popover('Identifier, a symbol which uniquely identifies an object or record'),
                Sight::make('name'),
                Sight::make('email'),
                Sight::make('email_verified_at', 'Email Verified')->render(fn (User $user) => $user->email_verified_at === null
                    ? '<i class="text-danger">●</i> False'
                    : '<i class="text-success">●</i> True'),
                Sight::make('created_at', 'Created'),
                Sight::make('updated_at', 'Updated'),
                Sight::make('Simple Text')->render(fn () => 'This is a wider card with supporting text below as a natural lead-in to additional content.'),
                Sight::make('Action')->render(fn () => Button::make('Show toast')
                    ->type(Color::DEFAULT())
                    ->method('showToast')),
            ])->title('User'),
        ];
    }

    /**
     * @param Request $request
     */
    public function showToast(Request $request): void
    {
        Toast::warning($request->get('toast', 'Hello, world! This is a toast message.'));
    }
}
