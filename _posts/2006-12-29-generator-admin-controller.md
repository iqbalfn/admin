---
layout: post
title: Generator Admin Controller
category: Generator
---

<style>
label{display:inline-block;vertical-align:top;font-size:12px;margin-bottom:5px;}
input{border:1px solid #ccc;padding:5px 10px}
</style>

<form>
<fieldset>
    <legend>General</legend>
    <label>Table Name:<br><input type="text" id="table_name" autofocus="autofocus"></label>
    <label>Controller Name:<br><input type="text" id="ctrl_name" value="Object"></label>
    <label>Controller Parent:<br><input type="text" id="ctrl_parent" value="MY_Controller"></label>
</fieldset>

<fieldset>
    <legend><label><input type="checkbox" id="ctrl_edit"> Create/Edit</label></legend>
    <label>Permission For Edit:<br><input type="text" id="ctrl_edit_permission_edit" class="value-table-based" data-perms="update-$$"></label>
    <label>Permission For Create:<br><input type="text" id="ctrl_edit_permission_create" class="value-table-based" data-perms="create-$$"></label>
    <label>View Name:<br><input type="text" id="ctrl_edit_view" class="value-table-based value-slashed-trans" data-perms="$$/edit"></label>
    <label>Edit Page Title:<br><input type="text" id="ctrl_edit_title_edit"></label>
    <label>Create Page Title:<br><input type="text" id="ctrl_edit_title_create"></label>
    <label>Form Name:<br><input type="text" id="ctrl_edit_form_name" class="value-table-based value-slashed-trans" data-perms="/admin/$$"></label>
    <label>Redirect On Done:<br><input type="text" id="ctrl_edit_redirect" class="value-table-based value-slashed-trans" data-perms="/admin/$$"></label>
    
    <br>
    <label><input type="checkbox" id="ctrl_edit_mine_only"> Edit mine only</label>
    <label><input type="checkbox" id="ctrl_edit_set_user_field"> Set `user` field</label>
    <label><input type="checkbox" id="ctrl_edit_set_updated_field"> Set `updated` field</label>
</fieldset>

<fieldset>
    <legend><label><input type="checkbox" id="ctrl_index"> Indexable</label></legend>
    <label>Permission:<br><input type="text" id="ctrl_index_permission" class="value-table-based" data-perms="read-$$"></label>
    <label>View Name:<br><input type="text" id="ctrl_index_view" class="value-table-based value-slashed-trans" data-perms="$$/index"></label>
    <label>Result per Page:<br><input type="text" id="ctrl_index_rpp"></label>
    <label>URL Params Filter:<br><input type="text" id="ctrl_index_params_filter"></label>
    <label>Page Title:<br><input type="text" id="ctrl_index_title"></label>
    <label>View Params name:<br><input type="text" id="ctrl_index_param_name" class="value-table-based value-last-trim" data-perms="$$"></label>
    <br>
    <label><input type="checkbox" id="ctrl_index_mine_only"> List mine only</label>
</fieldset>

<fieldset>
    <legend><label><input type="checkbox" id="ctrl_remove"> Removable</label></legend>
    <label>Permission:<br><input type="text" id="ctrl_remove_permission" class="value-table-based" data-perms="delete-$$"></label>
    <label>Redirect Target On Done:<br><input type="text" id="ctrl_remove_redirect" class="value-table-based value-slashed-trans" data-perms="/admin/$$"></label>
    <label>Cache to Remove:<br><input type="text" id="ctrl_remove_cache" class="value-table-based" data-perms="$$"></label>
    <br>
    <label><input type="checkbox" id="ctrl_remove_mine_only"> Remove mine only</label>
</fieldset>

<div>&#160;</div>

<hr>
<p style="text-align:right"><button>Generate</button></p>
</form>


<pre id="ctrl-result"></pre>

<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
<script src="{{ "/js/2006-12-29-generator-admin-controller.js" | prepend: site.baseurl }}"></script>