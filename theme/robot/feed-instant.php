<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title><?= $feed_title ?></title>
        <link><?= $feed_owner_url ?></link>
        <description><?= $feed_description ?></description>
        <language>id-id</language>
        <lastBuildDate><?= $last_update ?></lastBuildDate>
        <image>
            <url><?= $feed_image_url ?></url>
            <link><?= $feed_owner_url ?></link>
            <title><?= $feed_title ?></title>
        </image>
        
        <?php foreach($pages as $page): ?>
        <item>
            <title><?= htmlspecialchars($page->title, ENT_QUOTES) ?></title>
            <link><?= $page->page ?></link>
            <guid><?= $page->page ?></guid>
            <pubDate><?= $page->published ?></pubDate>
            <author><?= $page->author ?></author>
            <description><?= $page->description ?></description>
            <content:encoded>
                <![CDATA[
<?= $page->content ?>

                ]]>
            </content:encoded>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>