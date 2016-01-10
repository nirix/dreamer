<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer\Models;

class Page extends Model
{
    protected $validations = [
        'name' => ['required'],
        'slug' => ['required']
    ];
}
