<?php

namespace App\Http\Controllers\Console;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdateProfileController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->update($data);

        return back();
    }
}
