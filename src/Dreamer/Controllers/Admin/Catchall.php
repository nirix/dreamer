<?php

namespace Dreamer\Controllers\Admin;

class Catchall extends Controller
{
    public function indexAction()
    {
        return $this->render('admin/index.phtml');
    }
}
