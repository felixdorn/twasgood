<?php

namespace App\View\Components\PageEditors;

use App\Models\Recipe;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class About extends Component
{
    public User $user;
    public function __construct()
    {
        $this->user = User::first();
    }

    public function render(): View
    {
        return view('components.page-editors.about');
    }

}
