<?php
use Avalon\Routing\Router;

Router::root('Dreamer\\Controllers\\Articles::index');
Router::set404('Dreamer\\Controllers\\Errors::notFound');

Router::post('login', '/login', 'Dreamer\\Controllers\\Sessions::new');
Router::post('register', '/users', 'Dreamer\\Controllers\\Users::new');

Router::get('admin', '/admin.*', 'Dreamer\\Controllers\\Admin\\Catchall::index');
