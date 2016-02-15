<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button aria-expanded="false" class="navbar-toggle collapsed" data-target="#header-menu" data-toggle="collapse" type="button">
                <span class="sr-only"><?= _l('Toggle navigation'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= base_url('/admin') ?>"><?= $this->setting->item('site_name') ?></a>
        </div>
        <div class="collapse navbar-collapse" id="header-menu">
            <ul class="nav navbar-nav">
                <?= $this->theme->file('header-menu') ?>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="<?= base_url() ?>"><?= _l('Back to site') ?></a>
                </li>
                <?php if($this->user): ?>
                <li class="dropdown">
                    <a aria-expanded="false" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                        <?= $this->user->fullname ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= base_url('/admin/me/setting') ?>"><?= _l('Settings') ?></a>
                        </li>
                        <li class="divider" role="separator"></li>
                        <li>
                            <a href="<?= base_url('/admin/me/logout') ?>"><?= _l('Logout') ?></a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>