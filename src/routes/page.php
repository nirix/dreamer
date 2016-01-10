<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

$query = db()->prepare('SELECT id, name, slug, content FROM '.PREFIX.'pages WHERE slug = ? LIMIT 1');
$query->bindValue(1, Request::$properties['slug']);
$query->execute();

$page = $query->fetch();

if (!$page) {
    return show404();
}

title($page['name']);

return render('pages/show.phtml', ['page' => $page]);
