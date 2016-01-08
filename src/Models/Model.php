<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer\Models;

use Unf\ParameterBag;

/**
 * Data model based off the `ParameterBag` class from Unframework.
 *
 * A model is primarily used for validation, not for fetching, creating or saving data.
 *
 * @package Dreamer
 * @author Nirix
 * @since 2.0.0
 */
abstract class Model extends ParameterBag
{
    protected $validations = [];
    public $errors = [];

    // -------------------------------------------------------------------------
    // Errors

    /**
     * @param string $field
     * @param string $error
     * @param array  $options
     */
    public function addError($field, $error, array $options = [])
    {
        $this->errors[$field][] = $options + [
            'field' => $field,
            'error' => $error
        ];
    }

    /**
     * @param string $field
     *
     * @return boolean
     */
    public function hasError($field)
    {
        return isset($this->errors[$field]);
    }

    /**
     * @param string $field
     *
     * @return array
     */
    public function getError($field)
    {
        if (isset($this->errors[$field])) {
            return $this->errors[$field][0];
        }
    }

    /**
     * @return boolean
     */
    public function validate()
    {
        foreach ($this->validations as $field => $validations) {
            foreach ($validations as $validation => $options) {
                if (is_numeric($validation)) {
                    $validation = $options;
                    $options = null;
                }

                if ($validation == 'required') {
                    if ($this[$field] === null || empty($this[$field])) {
                        $this->addError($field, 'required');
                    }
                } elseif ($validation == 'email') {
                    if (!filter_var($this[$field], \FILTER_VALIDATE_EMAIL)) {
                        $this->addError($field, 'email');
                    }
                } elseif ($validation == 'minLength') {
                    if (strlen($this[$field]) < $options) {
                        $this->addError($field, 'minLength', ['length' => $options]);
                    }
                }
            }
        }

        return !count($this->errors);
    }
}
