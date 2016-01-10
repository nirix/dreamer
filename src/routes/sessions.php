<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

// Login
if (Request::seg(0) == 'login') {
    $error = false;

    title(t('login'));

    if (Request::$method == 'POST') {
        $query = db()->prepare('SELECT id, password, session_hash FROM '.PREFIX.'users WHERE username = ? LIMIT 1');
        $query->bindValue(1, Request::$post['username']);
        $query->execute();

        $user = $query->fetch();

        if ($user && password_verify(Request::$post['password'], $user['password'])) {
            setcookie('dreamer', $user['session_hash'], time() + (60 * 60 * 24 * 7), '/');
            return redirect('/admin');
        }

        $error = true;
    }

    return render('users/login.phtml', [
        '_layout' => false,
        'error'   => $error
    ]);
} elseif (Request::seg(0) == 'logout') {
    echo 'logout';
}
