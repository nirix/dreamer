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
    $post = new Post([
        'published_at' => new DateTime()
    ]);

    if (Request::$method == 'POST') {
        $post->set([
            'title'        => Request::$post['title'],
            'slug'         => Request::$post['slug'],
            'content'      => Request::$post['content'],
            'user_id'      => currentUser()->get('id'),
            'published_at' => new DateTime(Request::$post['published_at'])
        ]);

        if ($post->validate()) {

        }
    }

    return renderAdmin('admin/posts/new.phtml', ['post' => $post]);
}
