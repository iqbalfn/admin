<?php

function event_banner_created($object){
    file_put_contents(dirname(BASEPATH) . '/last-update.txt', time());
}

function event_banner_deleted($id){
    file_put_contents(dirname(BASEPATH) . '/last-update.txt', time());
}

function event_banner_updated($old, $new){
    file_put_contents(dirname(BASEPATH) . '/last-update.txt', time());
}