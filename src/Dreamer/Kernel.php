<?php

namespace Dreamer;

use Avalon\AppKernel;
use Avalon\Templating\View;
use Avalon\Templating\Engines\PhpExtended;

class Kernel extends AppKernel
{
    public function __construct()
    {
        $this->configDir = dirname(dirname(__DIR__)) . '/config';
        parent::__construct();

        require dirname(__DIR__) . '/common.php';

        class_alias('Avalon\\Http\\Request', 'Request');

        define('PREFIX', $this->config['database'][$this->config['environment']]['prefix']);
    }

    protected function configureTemplating()
    {
        View::setEngine(new PhpExtended);
        View::addPath(dirname(__DIR__) . '/views');
    }
}
