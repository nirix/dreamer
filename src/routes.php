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

    // -------------------------------------------------------------------------
    // Pages
    '/{slug}' => 'routes/page.php'
];
