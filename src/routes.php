<?php
return [
    '/' => 'routes/index.php',

    // -------------------------------------------------------------------------
    // Users
    '/register' => 'routes/register.php',
    '/login'    => 'routes/sessions.php',
    '/logout'   => 'routes/sessions.php',

    '/{slug}' => 'routes/page.php'
];
