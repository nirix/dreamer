<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

use Dreamer\Models\User;

$user = new User;

if (Request::$method == 'POST') {

    $user->set([
        'name'     => Request::$post['name'],
        'username' => Request::$post['username'],
        'email'    => Request::$post['email'],
        'password' => Request::$post['password']
    ]);

    if (Request::$post['password'] !== Request::$post['password_confirm']) {
        $user->addError('password', 'confirm');
    }

    if ($user->validate()) {
        db()->beginTransaction();

        $query = db()->prepare('
            INSERT INTO '.PREFIX.'users
            (name, username, email, password, session_hash, created_at)
            VALUES(:name, :username, :email, :password, :session_hash, NOW())
        ');

        $query->bindValue(':name', $user['name']);
        $query->bindValue(':username', $user['username']);
        $query->bindValue(':email', $user['email']);
        $query->bindValue(':password', password_hash($user['password'], PASSWORD_DEFAULT));
        $query->bindValue(':session_hash', randomHash());

        $query->execute();

        db()->commit();

        return redirect('/login');
    }
}

return render('users/register.phtml', [
    '_layout' => false,
    'user'    => $user
]);
