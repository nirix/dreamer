<?php

namespace Dreamer\Controllers\Admin;

use Avalon\Http\Request;

class Catchall extends Controller
{
    public function indexAction()
    {
        return $this->render('admin/index.phtml');
    }

    public function currentUserAction()
    {
        if ($this->currentUser) {
            return $this->respondTo(function ($format) {
                if (Request::isXhr()) {
                    return $this->jsonResponse([
                        'id' => $this->currentUser->id,
                        'username' => $this->currentUser->username,
                    ]);
                }
            });
        } else {
            return $this->show404();
        }
    }
}
