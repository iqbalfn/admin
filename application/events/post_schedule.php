<?php

function event_post_schedule_published($ids){
    file_put_contents(dirname(BASEPATH) . '/last-update.txt', time());
}