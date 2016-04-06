<div>&#160;</div>
<div id="nav-progress"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places<?= (ci()->setting->item('code_google_map') ? '&ampkey=' . ci()->setting->item('code_google_map') : '') ?>'></script>
<script src='<?= $this->theme->asset('static/tinymce/tinymce.js', false) ?>'></script>
<script src="<?= $this->theme->asset('static/js/portal.js') ?>"></script>