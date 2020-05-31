<?php

namespace App\Traits;

use App\Http\Controllers\UserController;

trait ForumTraits
{
    public function getAuthor($userId) {
        return UserController::findById($userId);
    }
}
