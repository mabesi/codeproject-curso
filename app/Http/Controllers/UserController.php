<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\User;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class UserController extends Controller
{
    public function authenticated()
    {
      $userId = userId();
      return User::find($userId);
    }
}
