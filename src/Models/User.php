<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer\Models;

class User extends Model
{
    protected $validations = [
        'name'     => ['required'],
        'username' => ['required', 'minLength' => 4],
        'password' => ['required', 'minLength' => 6],
        'email'    => ['required', 'email']
    ];

    protected $permissions = [];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties);

        if (isset($properties['permissions']) && !is_array($properties['permissions'])) {
            $this->permissions = json_decode($properties['permissions'], true);
        }
    }

    // -------------------------------------------------------------------------
    // Permissions

    public function isAdmin()
    {
        return $this->hasPermission('is_admin');
    }

    public function hasPermission($permission)
    {
        return isset($this->permissions[$permission]) ? $this->permissions[$permission] : false;
    }

    // -------------------------------------------------------------------------
    // Validation

    public function validate()
    {
        // Unique
        $query = db()->prepare('SELECT id FROM '.PREFIX.'users WHERE username = ? LIMIT 1');
        $query->bindValue(1, $this['username'], \PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch();

        if ($result && $result['id'] != $this['id']) {
            $this->addError('username', 'unique');
        }

        return parent::validate();
    }
}
