<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    <?php foreach($pages as $page): ?>
    <url>
        <loc><?= $page->page ?></loc>
        <news:news>
            <news:publication>
                <news:name><?= $page->publisher ?></news:name>
                <news:language>id</news:language>
            </news:publication>
            <news:genres>PressRelease, Blog</news:genres>
            <news:publication_date><?= $page->published ?></news:publication_date>
            <news:title><?= htmlspecialchars($page->title, ENT_QUOTES) ?></news:title>
            <?php if($page->keywords): ?>
            <news:keywords><?= $page->keywords ?></news:keywords>
            <?php endif; ?>
        </news:news>
    </url>
    <?php endforeach; ?>
</urlset>