<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

use Dreamer\Models\Post;

if (!currentUser()->hasPermission('manage_posts')) {
    return show403();
}

if (!Request::seg(2)) {
    $posts = db()->query('
        SELECT p.*, u.name AS user_name FROM '.PREFIX.'posts p
        LEFT JOIN '.PREFIX.'users u ON p.user_id = u.id
        ORDER BY published_at DESC
    ')
    ->fetchAll();

    return renderAdmin('admin/posts/index.phtml', ['posts' => $posts]);
} elseif (Request::seg(2) == 'new') {
    $post = new Post([
        'is_published' => true,
        'published_at' => new DateTime()
    ]);

    if (Request::$method == 'POST') {
        $post->set([
            'title'        => Request::$post['title'],
            'slug'         => Request::$post['slug'],
            'content'      => Request::$post['content'],
            'is_published' => Request::$post->get('is_published', false),
            'user_id'      => currentUser()->get('id'),
            'published_at' => DateTime::createFromFormat(PUBLISHED_AT_FORMAT, Request::$post['published_at'])
        ]);

        if ($post->validate()) {
            db()->beginTransaction();

            $query = db()->prepare('
                INSERT INTO '.PREFIX.'posts
                (title, slug, content, user_id, is_published, created_at, published_at)
                VALUES(:title, :slug, :content, :user_id, :is_published, NOW(), :published_at)
            ');

            $query->bindValue(':title', $post['title']);
            $query->bindValue(':slug', $post['slug']);
            $query->bindValue(':content', $post['content']);
            $query->bindValue(':is_published', $post['is_published']);
            $query->bindValue(':user_id', $post['user_id'], PDO::PARAM_INT);
            $query->bindValue(':published_at', $post['published_at']->format(DATETIME_DB_FORMAT));

            $query->execute();

            db()->commit();

            return redirect('/admin/posts');
        }
    }

    return renderAdmin('admin/posts/form.phtml', [
        'action' => 'new',
        'post' => $post
    ]);
} elseif (Request::seg(3) == 'edit') {
    $query = db()->prepare('SELECT * FROM '.PREFIX.'posts WHERE id = ? LIMIT 1');
    $query->bindValue(1, Request::$properties['id']);
    $query->execute();

    $post = $query->fetch();

    if (!$post) {
        return show404();
    }

    $post = new Post($post);

    if (Request::$method == 'POST') {
        $post->set([
            'title'        => Request::$post['title'],
            'slug'         => Request::$post['slug'],
            'content'      => Request::$post['content'],
            'is_published' => Request::$post->get('is_published', false),
            'published_at' => DateTime::createFromFormat(PUBLISHED_AT_FORMAT, Request::$post['published_at'])
        ]);

        if ($post->validate()) {
            db()->beginTransaction();

            $query = db()->prepare('
                UPDATE '.PREFIX.'posts
                SET title = :title,
                    slug = :slug,
                    content = :content,
                    is_published = :is_published,
                    updated_at = NOW(),
                    published_at = :published_at
                WHERE id = :id
                LIMIT 1
            ');

            $query->bindValue(':id', $post['id'], PDO::PARAM_INT);
            $query->bindValue(':title', $post['title']);
            $query->bindValue(':slug', $post['slug']);
            $query->bindValue(':content', $post['content']);
            $query->bindValue(':is_published', $post['is_published']);
            $query->bindValue(':published_at', $post['published_at']->format(DATETIME_DB_FORMAT));

            $query->execute();

            db()->commit();
        }
    }

    return renderAdmin('admin/posts/form.phtml', [
        'action' => 'edit',
        'post' => $post
    ]);
} elseif (Request::seg(3) == 'delete') {
    $query = db()->prepare('DELETE FROM '.PREFIX.'posts WHERE id = ? LIMIT 1');
    $query->bindValue(1, Request::$properties['id'], PDO::PARAM_INT);
    $query->execute();
    return redirect('/admin/posts');
}
