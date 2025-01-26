<?php

namespace App\Console\Commands;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;

class AssignUserToRecipes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-user-to-recipes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = select(
            label: "Which user should be used for user-less recipes?",
            options: User::pluck('email', 'id'),
        );

        Recipe::whereNull('user_id')->update(['user_id' => $user]);
    }
}
