<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer\Translations;

use Dreamer\Translation;

class EnglishAu extends Translation
{
    protected static $name = 'English';
    protected static $locale = 'en_AU';
    protected static $strings = [
        'login'    => 'Login',
        'register' => 'Register',

        // Users
        'name'     => 'Name',
        'username' => 'Username',
        'password' => 'Password',
        'email'    => 'Email',

        // Forms
        'create_account' => 'Create Account',

        // Errors
        'errors.validation.required'  => '{field} is required',
        'errors.validation.confirm'   => '{field} doesn\'t match confirmation',
        'errors.validation.minLength' => '{field} must at least {length} characters long',
        'errors.validation.email'     => '{field} is not a valid email address',
        'errors.validation.unique'    => '{field} is already in use',
    ];
}
