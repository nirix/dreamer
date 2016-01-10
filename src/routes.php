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
    '/admin/posts'             => 'routes/admin/posts.php',
    '/admin/posts/new'         => 'routes/admin/posts.php',
    '/admin/posts/{id}/edit'   => 'routes/admin/posts.php',
    '/admin/posts/{id}/delete' => 'routes/admin/posts.php',

    // Pages
    '/admin/pages'             => 'routes/admin/pages.php',
    '/admin/pages/new'         => 'routes/admin/pages.php',
    '/admin/pages/{id}/edit'   => 'routes/admin/pages.php',
    '/admin/pages/{id}/delete' => 'routes/admin/pages.php',

    // -------------------------------------------------------------------------
    // Pages
    '/{slug}' => 'routes/page.php'
];
