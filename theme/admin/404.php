<!DOCTYPE html>
<html lang="en-US">
<head>
    <?= $this->theme->file('head') ?>
</head>
<body>
    <?= $this->theme->file('header') ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?= $this->form->field('email') ?>
                <?= $this->form->field('no-label') ?>
                <?= $this->form->field('with-error') ?>
                <?= $this->form->field('number') ?>
                <?= $this->form->field('password') ?>
                <?= $this->form->field('search') ?>
                <?= $this->form->field('search-prefixed') ?>
                <?= $this->form->field('tel') ?>
                <?= $this->form->field('text') ?>
                <?= $this->form->field('slug') ?>
                <?= $this->form->field('url') ?>
                <?= $this->form->field('color') ?>
                <?= $this->form->field('date') ?>
                <?= $this->form->field('datetime') ?>
                <?= $this->form->field('month') ?>
                <?= $this->form->field('time') ?>
                <?= $this->form->field('range') ?>
                <?= $this->form->field('image') ?>
                <?= $this->form->field('textarea') ?>
                <?= $this->form->field('select', array('a'=>'Lorem', 'b'=>'Ipsum', 'c'=>'Dolor', 'd'=>'Sit', 'e'=>'Amet')) ?>
                <?= $this->form->field('boolean') ?>
                <?= $this->form->field('file') ?>
                <?= $this->form->field('multiple') ?>
            </div>
            <div class="col-md-8">
                <?= $this->form->field('tinymce') ?>
                <a href="lorem">I'm the link</a>
            </div>
        </div>
    </div>
    <?= $this->theme->file('foot') ?>
</body>
</html>