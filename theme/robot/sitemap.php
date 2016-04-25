<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <?php foreach($pages as $page): ?>
    <url>
        <loc><?= $page->loc ?></loc>
        <lastmod><?= $page->lastmod ?></lastmod>
        <changefreq><?= $page->changefreq ?></changefreq>
        <priority><?= $page->priority ?></priority>
        <?php if(property_exists($page, 'image_loc')): ?>
        <image:image>
            <image:loc><?= $page->image_loc ?></image:loc>
            <?php if(property_exists($page, 'image_caption')): ?>
            <image:caption><?= htmlspecialchars($page->image_caption, ENT_QUOTES) ?></image:caption>
            <?php endif; ?>
        </image:image>
        <?php endif; ?>
    </url>
    <?php endforeach; ?>
</urlset>