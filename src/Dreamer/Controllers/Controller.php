<?php

namespace Dreamer\Controllers;

use Dreamer\Models\User;

class Controller extends \Avalon\Http\Controller
{
    protected $layout = false;
    protected $currentUser;

    public function __construct()
    {
        // parent::__construct();

        $this->getCurrentUser();
    }

    protected function getCurrentUser()
    {
        if (isset($_COOKIE['dreamer'])) {
            $this->currentUser = User::find('session_hash', $_COOKIE['dreamer']);
        }
    }
}
