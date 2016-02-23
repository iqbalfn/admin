<!DOCTYPE html>
<html lang="en-US">
<head>
    <?= $this->theme->file('head') ?>
</head>
<body>
    <?= $this->theme->file('header') ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1><?= $title ?></h1>
                <hr>
                <form method="post" data-name="<?= $this->form->name ?>">
                    <?= $this->form->field('name') ?>
                    <?= $this->form->field('password') ?>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-primary"><?= _l('Login') ?></button>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    <?= $this->form->focusInput(); ?>
</body>
</html>