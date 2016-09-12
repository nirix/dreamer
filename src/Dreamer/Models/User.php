<?php

namespace Dreamer\Models;

use Avalon\Database\Model\SecurePassword;

class User extends Model
{
    use SecurePassword;
    protected $securePasswordField = 'password';

    protected static $_validations = [
        'username' => ['required', 'unique'],
        'password' => ['required'],
        'email' => ['required', 'unique']
    ];

    protected static $_before = [
        'create' => ['preparePassword', 'generateSessionHash']
    ];

    protected function generateSessionHash()
    {
        $this->sessionHash = sha1($this->username . rand(0, 1000) . microtime());
    }
}
