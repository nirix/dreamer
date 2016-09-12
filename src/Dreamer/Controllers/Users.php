<?php

namespace Dreamer\Controllers;

use Avalon\Http\Request;
use Dreamer\Models\User;

class Users extends Controller
{
    public function newAction()
    {
        $user = new User([
            'name' => Request::$post->get('name'),
            'username' => Request::$post->get('username'),
            'password' => Request::$post->get('password'),
            'email' => Request::$post->get('email')
        ]);

        if ($user->save()) {
            return $this->jsonResponse([
                'id' => $user->id,
                'username' => $user->username
            ]);
        } else {
            return $this->jsonResponse(['errors' => $user->errors()], 400);
        }
    }
}
