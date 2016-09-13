<?php

namespace Dreamer\Controllers;

use Avalon\Http\Request;
use Dreamer\Models\User;

class Sessions extends Controller
{
    public function newAction()
    {
        $user = User::find('username', Request::$post->get('username'));

        if ($user && $user->authenticate(Request::$post->get('password'))) {
            return $this->respondTo(function ($format) use ($user) {
                if (Request::isXhr()) {
                    return $this->jsonResponse([
                            'id' => $user->id,
                            'username' => $user->username
                        ])
                        ->addCookie('dreamer', $user->session_hash, time() + (7 * 24 * 60 * 60), '/');
                }
            });
        } else {
            return $this->respondTo(function ($format) {
                if (Request::isXhr()) {
                    return $this->jsonResponse([
                        'error' => 'Invalid username or password'
                    ], 400);
                }
            });
        }
    }

    public function destroyAction()
    {
        return $this->respondTo(function ($format) {
            if (Request::isXhr()) {
                $resp = $this->jsonResponse([
                    'success' => 'You are now logged out'
                ]);
            } else {
                $resp = $this->redirectTo('root');
            }

            return $resp->addCookie('dreamer', '', time(), '/');
        });
    }
}
