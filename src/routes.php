<?php
return [
    '/' => 'routes/index.php',

    // -------------------------------------------------------------------------
    // Users
    '/register' => 'routes/register.php',
    '/login'    => 'routes/sessions.php',
    '/logout'   => 'routes/sessions.php',

    // -------------------------------------------------------------------------
    // Admin
    '/admin' => 'routes/admin/dashboard.php',

    // Posts
    '/admin/posts' => 'routes/admin/posts.php',
    '/admin/posts/new' => 'routes/admin/posts.php',

    // -------------------------------------------------------------------------
    // Pages
    '/{slug}' => 'routes/page.php'
];
