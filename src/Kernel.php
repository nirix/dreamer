<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer;

use PDO;
use Unf\AppKernel;
use Unf\Router;
use Unf\Request;
use Unf\NoRouteFoundException;
use Dreamer\Translations\EnglishAu;

/**
 * Dreamer core.
 *
 * @package Dreamer
 * @author Nirix
 * @since 2.0.0
 */
class Kernel extends AppKernel
{
    /**
     * Dreamer version string.
     *
     * @var string
     */
    const VERSION = '2.0.0-dev';

    /**
     * Version ID used for updates.
     *
     * @var integer
     */
    const VERSION_ID = 20000;

    public function __construct()
    {
        session_start();

        parent::__construct();

        $_ENV['env'] = $this->config['environment'];

        if ($_ENV['env'] == 'development') {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }

        class_alias('Unf\\Request', 'Request');

        $dbConfig = $this->config['db'][$this->config['environment']];
        $GLOBALS['db'] = new PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $GLOBALS['db']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $GLOBALS['db']->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        define('PREFIX', $dbConfig['prefix']);
        unset($dbConfig);

        $GLOBALS['language'] = new EnglishAu;

        require __DIR__ . '/common.php';

        title(setting('title'));
    }

    protected function loadRoutes()
    {
        Router::$routes = require __DIR__ . '/routes.php';
    }

    /**
     * Override the `run()` method to check CSRF and permissions.
     */
    public function run()
    {
        Request::init();

        // Check CSRF token
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['csrf_token'] !== $_SESSION['CSRF_TOKEN']) {
                echo show404();
                exit;
            }
        }

        if (Request::seg(0) == 'admin') {
            if (!currentUser()) {
                echo showLogin();
                exit;
            }
        }

        try {
            return parent::run();
        } catch (NoRouteFoundException $r) {
            echo show404();
        }
    }
}
