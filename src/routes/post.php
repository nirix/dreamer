<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

$query = db()->prepare('SELECT * FROM '.PREFIX.'posts WHERE slug = ? AND published_at < NOW() LIMIT 1');
$query->bindValue(1, Request::$properties['slug']);
$query->execute();

$post = $query->fetch();

if (!$post) {
    return show404();
}

return render('posts/show.phtml', ['post' => $post]);
