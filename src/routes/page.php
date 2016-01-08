<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

$page = db()->prepare('SELECT id, name, slug, content FROM '.PREFIX.'pages WHERE slug = ? LIMIT 1');
$page->bindValue(1, Request::$properties['slug']);
$page->execute();

return render('pages/show.phtml', ['page' => $page->fetch()]);
