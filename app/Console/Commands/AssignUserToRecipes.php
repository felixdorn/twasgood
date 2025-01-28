<?php

namespace App\Console\Commands;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\select;

class AssignUserToRecipes extends Command
{
    /** @var string */
    protected $signature = 'app:assign-user-to-recipes {--force}';

    /** @var string */
    protected $description = 'Command description';

    public function handle(): void
    {
        $user = select(
            label: 'Which user should be used for user-less recipes?',
            options: User::pluck('email', 'id'),
        );

        if ($this->option('force') && ! app()->isProduction()) {
            Recipe::query()->update(['user_id' => $user]);
        } else {
            Recipe::whereNull('user_id')->update(['user_id' => $user]);
        }
    }
}
