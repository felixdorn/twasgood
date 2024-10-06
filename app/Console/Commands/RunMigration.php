<?php

namespace App\Console\Commands;

use App\Models\Tag;
use Illuminate\Console\Command;

class RunMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tags = Tag::all();

        foreach ($tags as $tag) {
            $this->components->task($tag->name, fn () => $tag->generateSlug());
        }
    }
}
