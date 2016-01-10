<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */


use Dreamer\Models\Page;

if (!currentUser()->hasPermission('manage_pages')) {
    return show403();
}

if (!Request::seg(2)) {
    $pages = db()->query('SELECT * FROM '.PREFIX.'pages ORDER BY name ASC')->fetchAll();
    return renderAdmin('admin/pages/index.phtml', ['pages' => $pages]);
} elseif (Request::seg(2) == 'new') {
    $page = new Page;

    if (Request::$method == 'POST') {
        $page->set([
            'name'    => Request::$post['name'],
            'slug'    => Request::$post['slug'],
            'content' => Request::$post['content']
        ]);

        if ($page->validate()) {
            db()->beginTransaction();

            $query = db()->prepare('
                INSERT INTO '.PREFIX.'pages
                (name, slug, content, created_at)
                VALUES(:name, :slug, :content, NOW())
            ');

            $query->bindValue(':name', $page['name']);
            $query->bindValue(':slug', $page['slug']);
            $query->bindValue(':content', $page['content']);

            $query->execute();

            db()->commit();

            return redirect('/admin/pages');
        }
    }

    return renderAdmin('admin/pages/new.phtml', ['page' => $page]);
} elseif (Request::seg(3) == 'edit') {
    $query = db()->prepare('SELECT * FROM '.PREFIX.'pages WHERE id = ? LIMIT 1');
    $query->bindValue(1, Request::$properties['id'], PDO::PARAM_INT);
    $query->execute();

    $page = $query->fetch();

    if (!$page) {
        return show404();
    }

    $page = new Page($page);

    if (Request::$method == 'POST') {
        $page->set([
            'name'    => Request::$post['name'],
            'slug'    => Request::$post['slug'],
            'content' => Request::$post['content']
        ]);

        if ($page->validate()) {
            db()->beginTransaction();

            $query = db()->prepare('
                UPDATE '.PREFIX.'pages
                SET name = :name,
                    slug = :slug,
                    content = :content
                WHERE id = :id
                LIMIT 1
            ');

            $query->bindValue(':id', $page['id'], PDO::PARAM_INT);
            $query->bindValue(':name', $page['name']);
            $query->bindValue(':slug', $page['slug']);
            $query->bindValue(':content', $page['content']);

            $query->execute();

            db()->commit();

            return redirect("/admin/pages/{$page['id']}/edit");
        }
    }

    return renderAdmin('admin/pages/edit.phtml', ['page' => $page]);
}
