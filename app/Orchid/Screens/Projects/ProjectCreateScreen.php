<?php

namespace App\Orchid\Screens\Projects;

use App\Models\CompBind;
use App\Models\Domain;
use App\Models\Project;
use App\Models\Server;
use Illuminate\Http\Request;
use Orchid\Platform\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectCreateScreen extends Screen
{
    public $name = "Добавить проект";
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('note')
                ->method('create')
        ];
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
            Layout::rows([
                Input::make('project.name')
                    ->type('text')
                    ->title('Название'),
                Relation::make('domains.')
                    ->fromModel(Domain::class, 'name')
                    ->applyScope('spare')
                    ->multiple()
                    ->title('Домены'),
            ])
        ];
    }

    public function create(Request $request, Project $project)
    {
        $project = $project->create($request->input('project'));
        Domain::whereIn("id", $request->input('domains'))->update(["project_id" => $project->id]);
        Toast::info("Успешно сохранено.");
    }
}
