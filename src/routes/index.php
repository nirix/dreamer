<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

$posts = db()->query('
    SELECT id, title, slug, content
    FROM '.PREFIX.'posts
    WHERE is_published = 1
    ORDER BY published_at DESC
');

return render('posts/index.phtml', ['posts' => $posts->fetchAll()]);
