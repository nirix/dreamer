<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

use Unf\View;
use Dreamer\Models\Model;
use Dreamer\Models\User;

// -----------------------------------------------------------------------------
// Settings

/**
 * Get the specified setting value.
 *
 * @param string $setting
 *
 * @return string
 */
function setting($setting)
{
    static $settings;

    if (!$settings) {
        $query = db()->query('SELECT setting, value FROM '.PREFIX.'settings');
        foreach ($query->fetchAll() as $row) {
            $settings[$row['setting']] = $row['value'];
        }
    }

    return $settings[$setting];
}

// -----------------------------------------------------------------------------
// Users

/**
 * @return User
 */
function currentUser()
{
    static $user;

    if (!$user && isset($_COOKIE['dreamer'])) {
        $query = db()->prepare('SELECT u.*, g.permissions
            FROM '.PREFIX.'users u
            LEFT JOIN '.PREFIX.'groups g ON g.id = u.group_id
            WHERE u.session_hash = ?
            LIMIT 1');

        $query->bindValue(1, $_COOKIE['dreamer']);
        $query->execute();

        if ($user = $query->fetch()) {
            $user = new User($user);
        }
    }

    return $user;
}

// -----------------------------------------------------------------------------
// Pages

/**
 * Get all pages.
 *
 * @return array[]
 */
function getPages()
{
    return db()->query('SELECT * FROM '.PREFIX.'pages ORDER BY name ASC')->fetchAll();
}

// -----------------------------------------------------------------------------
// Database

/**
 * Get the database connection object.
 *
 * @return PDO
 */
function db()
{
    return $GLOBALS['db'];
}

// -----------------------------------------------------------------------------
// URLs

/**
 * @param string $append
 *
 * @return string
 */
function baseUrl($append = null)
{
    return Request::$basePath . rtrim('/' . ltrim($append, '/'), '/');
}

/**
 * Redirect to the specified path.
 *
 * @param string $path
 */
function redirect($path)
{
    header('Location: ' . baseUrl($path));
    exit;
}

// -----------------------------------------------------------------------------
// Views

/**
 * Render the 404 page.
 *
 * @return string
 */
function show404()
{
    return render('errors/404.phtml');
}

/**
 * Render a view with the layout.
 *
 * A different layout can be specified by passing `'_layout' => 'my_layout.phtml`
 * as a local variable.
 *
 * @param string $view   view file
 * @param arrray $locals local variables
 *
 * @return string
 */
function render($view, array $locals = [])
{
    $locals = $locals + [
        '_layout' => 'default.phtml'
    ];

    $view = view($view, $locals);

    if ($locals['_layout']) {
        return view("layouts/{$locals['_layout']}", ['content' => $view]);
    } else {
        return $view;
    }
}

/**
 * Render a view.
 *
 * @param string $view   view file
 * @param arrray $locals local variables
 *
 * @return string
 */
function view($view, array $locals = [])
{
    return View::render($view, $locals);
}

/**
 * Escape HTML.
 *
 * @param string $string
 *
 * @return string
 */
function e($string)
{
    return htmlspecialchars($string);
}

// -----------------------------------------------------------------------------
// CSRF

/**
 * Get CSRF token form field.
 *
 * @return string
 */
function csrfField()
{
    return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}

/**
 * Generate a CSRF token for this request, but only generate it once in case there are
 * multiple forms on the one page.
 *
 * @return string
 */
function csrfToken()
{
    static $token;

    if (!$token) {
        $_SESSION['CSRF_TOKEN'] = $token = randomHash();
    }

    return $token;
}

/**
 * Get the CSRF token from the session.
 *
 * @return string|boolean
 */
function getCsrfToken()
{
    if (isset($_SESSION['CSRF_TOKEN'])) {
        return $_SESSION['CSRF_TOKEN'];
    }

    return false;
}

// -----------------------------------------------------------------------------
// Model/Validation Errors

function errorMessageFor(Model $model, $field)
{
    if (!$model->hasError($field)) {
        return;
    }

    $error = $model->getError($field);
    $error['field'] = t($error['field']);
    return t('errors.validation.' . $error['error'], $error);
}

// -----------------------------------------------------------------------------
// Misc.

/**
 * Generate a random hash.
 *
 * @return string
 */
function randomHash()
{
    return bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
}

/**
 * Somewhat shortcut kind of way for `($cond ? $true : $false)`.
 *
 * @param boolean $cond
 * @param mixed   $true
 * @param mixed   $false
 *
 * @return mixed
 */
function iif($cond, $true, $false = null)
{
    return $cond ? $true : $false;
}

/**
 * Dump a die.
 *
 * @see https://secure.php.net/var_dump
 */
function dd()
{
    echo '<pre>';
    call_user_func_array('var_dump', func_get_args());
    exit;
}
