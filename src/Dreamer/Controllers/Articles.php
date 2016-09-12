<?php

namespace Dreamer\Controllers;

class Articles extends Controller
{
    public function indexAction()
    {
        return $this->render('articles/index.phtml');
    }
}
