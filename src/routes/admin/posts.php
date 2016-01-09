<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

use Dreamer\Models\Post;

if (!Request::seg(2)) {
    $posts = db()->query('SELECT * FROM '.PREFIX.'posts ORDER BY published_at DESC')->fetchAll();
    return renderAdmin('admin/posts/index.phtml', ['posts' => $posts]);
} elseif (Request::seg(2) == 'new') {
    $post = new Post;

    if (Request::$method == 'POST') {

    }

    return renderAdmin('admin/posts/new.phtml', ['post' => $post]);
}
