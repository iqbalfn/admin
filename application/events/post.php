<?php

function event_post_created($object){
    file_put_contents(dirname(BASEPATH) . '/last-update.txt', time());
}

function event_post_deleted($object){
    file_put_contents(dirname(BASEPATH) . '/last-update.txt', time());
}

function event_post_updated($old, $new){
    file_put_contents(dirname(BASEPATH) . '/last-update.txt', time());
}