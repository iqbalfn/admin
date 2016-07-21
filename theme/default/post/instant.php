<!doctype html>
<html lang="en" prefix="op: http://media.facebook.com/op#">
  <head>
    <meta charset="utf-8">
    <link rel="canonical" href="<?= base_url($post->page) ?>">
    <meta property="op:markup_version" content="v1.0">
    <meta property="fb:use_automatic_ad_placement" content="true">
    <meta property="fb:likes_and_comments" content="enable">
    <!-- TODO op:tags -->
  </head>
  <body>
    <article>
      <header>
        <h1><?= $post->title->clean(); ?></h1>
        
        <time class="op-published" datetime="<?= $post->published->format('c') ?>"><?= $post->published->format('M d, Y') ?></time>
        <?php if($post->published->time != $post->updated->time): ?>
        <time class="op-modified" dateTime="<?= $post->updated->format('c') ?>"><?= $post->updated->format('M d, Y') ?></time>
        <?php endif; ?>
        
        <address>
            <a rel="facebook" href="#" title="Reporter"><?= $post->user->fullname ?></a>
        </address>
        
        <?php if($post->cover): ?>
        <figure>
            <img src="<?= $post->cover ?>" />
            <?php if($post->cover_label): ?>
            <figcaption><?= $post->cover_label ?></figcaption>
            <?php endif; ?>
        </figure>
        <?php endif; ?>
      
        <figure class="op-ad">
            <iframe width="320" height="50" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement=1738038036454020_1738038136454010&amp;adtype=banner320x50"></iframe>
        </figure>

      </header>

      <?= $post->content ?>

      <figure class="op-tracker">
          <iframe>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title><?= ( $post->seo_title->clean() ? $post->seo_title->clean() : $post->title->clean() ); ?> - <?= ci()->setting->item('site_name') ?></title>
                    <?= $this->ometa->_generateGA($post->ga_group); ?>
                    <link rel="canonical" href="<?= base_url($post->page) ?>">
                </head>
                <body></body>
            </html>
          </iframe>
      </figure>

      <footer>
        <aside>Semua kontent dalam halaman ini adalah alternatif instant artikel untuk artikel yang sudah ada di website resmi.</aside>
        <small>&copy; 2015 <?= ci()->setting->item('site_name') ?></small>
      </footer>
    </article>
  </body>
</html>