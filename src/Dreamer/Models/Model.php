<?php

namespace Dreamer\Models;

class Model extends \Avalon\Database\Model
{
    public function getErrorsArray()
    {
        $errors = [];

        foreach ($this->_errors as $field => $error) {
            foreach ($error as $msg) {
                $errors[] = $msg;
            }
        }

        return $errors;
    }
}
