<?= '<?xml version="1.0" ?>' ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
    <atom:link href="<?= $feed_url ?>" rel="self" type="application/rss+xml" />
    <title><?= $feed_title ?></title>
    <link><?= $feed_owner_url ?></link>
    <description><?= hs($feed_description) ?></description>
    <language>id-id</language>
    <image>
        <url><?= $feed_image_url ?></url>
        <link><?= $feed_owner_url ?></link>
        <title><?= $feed_title ?></title>
    </image>
    
    <?php foreach($pages as $page): ?>
    <item>
        <atom:link href="<?= $feed_url ?>" rel="self" type="application/rss+xml" />
        <guid><?= $page->page ?></guid>
        <title><?= hs($page->title) ?></title>
        <link><?= $page->page ?></link>
        <?php if($page->categories): ?>
            <?php foreach($page->categories as $cat): ?>
                <category><?= $cat ?></category>
            <?php endforeach; ?>
        <?php endif; ?>
        <description><?= hs($page->description) ?></description>
    </item>
    <?php endforeach; ?>
</channel>
</rss>