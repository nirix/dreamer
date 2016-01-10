<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer\Models;

use DateTime;

class Post extends Model
{
    protected $validations = [
        'title'        => ['required'],
        'slug'         => ['required'],
        'content'      => ['required'],
        'user_id'      => ['required'],
        'published_at' => ['required']
    ];

    public function __construct(array $properties = [])
    {
        parent::__construct($properties);

        if (isset($properties['published_at']) && !($properties['published_at'] instanceof DateTime)) {
            $this['published_at'] = new DateTime($properties['published_at']);
        }
    }
}
