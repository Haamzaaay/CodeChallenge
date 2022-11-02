<?php

namespace App\Services;

use App\Models\User;

class BladeDataService
{
    public function getSuggestions()
    {
        return User::all();
    }
}
