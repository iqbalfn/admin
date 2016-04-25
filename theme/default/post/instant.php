<!doctype html>
<html lang="en" prefix="op: http://media.facebook.com/op#">
  <head>
    <meta charset="utf-8">
    <link rel="canonical" href="<?= base_url($post->page) ?>">
    <meta property="op:markup_version" content="v1.0">
  </head>
  <body>
    <article>
      <header>
        <h1><?= $post->title->clean(); ?></h1>
        <time class="op-published" datetime="<?= $post->published->format('c') ?>"><?= $post->published->format('M d, Y') ?></time>
        <time class="op-modified" dateTime="<?= $post->updated->format('c') ?>"><?= $post->updated->format('M d, Y') ?></time>
        <address>
          <a rel="facebook" href="#"><?= $post->user->fullname ?></a>
          <?= $post->user->about ?>
        </address>
        <figure>
          <img src="<?= $post->cover ?>" alt="<?= $post->title->clean(); ?>" />
          <?php if($post->cover_label): ?>
          <figcaption><?= $post->cover_label ?></figcaption>
          <?php endif; ?>
        </figure>
      </header>
      
      <?= $post->content ?>

      <?php if($post->embed): ?>
      <figure class="op-interactive">
        <?= $post->embed ?>
      </figure>
      <?php endif; ?>
      
      <footer>
        <aside>&copy; 2015 <?= ci()->setting->item('site_name') ?> All rights reserved.</aside>
        <small><a href="<?= base_url('/page/privacy-policy') ?>">Legal notes</a></small>
      </footer>
    </article>
  </body>
</html>