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
                <?= $this->form->field('multiple', array(
                    0 => array(
                        array( 'id' => 1, 'name' => 'Option 1'),
                        array( 'id' => 2, 'label' => 'Option 2'),
                        array( 'id' => 3, 'value' => 'Option 3'),
                        array( 'id' => 4, 'title' => 'Option 4')
                    ),
                    3 => array(
                        array( 'id' => 5, 'title' => 'Option 5'),
                        array( 'id' => 6, 'title' => 'Option 6'),
                        array( 'id' => 7, 'title' => 'Option 7'),
                        array( 'id' => 8, 'title' => 'Option 8')
                    ),
                    7 => array(
                        array( 'id' => 9, 'title' => 'Option 9'),
                        array( 'id' => 10, 'title' => 'Option 10'),
                        array( 'id' => 11, 'title' => 'Option 11')
                    )
                )) ?>
            </div>
            <div class="col-md-8">
                <?= $this->form->field('tinymcelen') ?>
            </div>
        </div>
    </div>
    <?= $this->theme->file('foot') ?>
    <?= $this->form->javascript(); ?>
</body>
</html>