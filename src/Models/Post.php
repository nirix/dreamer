<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer\Models;

class Post extends Model
{
    protected $validations = [
        'title'        => ['required'],
        'slug'         => ['required'],
        'content'      => ['required'],
        'user_id'      => ['required'],
        'published_at' => ['required']
    ];
}
