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

        // Admin
        'admincp'   => 'AdminCP',
        'view_site' => 'View Site',
        'dashboard' => 'Dashboard',
        'profile'   => 'Profile',

        // Posts
        'posts'        => 'Posts',
        'new_post'     => 'New Post',
        'edit_post'    => 'Edit Post',
        'title'        => 'Title',
        'slug'         => 'Slug',
        'content'      => 'Content',
        'published_at' => 'Published at',
        'publish_date' => 'Publish Date',
        'create_post'  => 'Create Post',
        'save_post'    => 'Save Post',

        // Pages
        'pages'    => 'Pages',
        'new_page' => 'New Page',

        // Users
        'users'  => 'Users',
        'groups' => 'Groups',

        // Errors
        'errors.validation.required'  => '{field} is required',
        'errors.validation.confirm'   => '{field} doesn\'t match confirmation',
        'errors.validation.minLength' => '{field} must at least {length} characters long',
        'errors.validation.email'     => '{field} is not a valid email address',
        'errors.validation.unique'    => '{field} is already in use',
    ];
}
