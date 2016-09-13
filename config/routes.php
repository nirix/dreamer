<?php
use Avalon\Routing\Router;

Router::root('Dreamer\\Controllers\\Articles::index');
Router::set404('Dreamer\\Controllers\\Errors::notFound');

Router::post('login', '/login', 'Dreamer\\Controllers\\Sessions::new');
Router::post('register', '/users', 'Dreamer\\Controllers\\Users::new');
Router::delete('logout', '/logout', 'Dreamer\\Controllers\\Sessions::destroy');

Router::get('admin_current_user', '/admin/current-user', 'Dreamer\\Controllers\\Admin\\Catchall::currentUser');
Router::get('admin', '/admin.*', 'Dreamer\\Controllers\\Admin\\Catchall::index');
