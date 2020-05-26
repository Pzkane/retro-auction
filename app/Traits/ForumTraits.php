<?php

namespace App\Traits;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Log;

trait ForumTraits
{
    public function getAuthor($userId) {
        return UserController::findById($userId);
    }
}
