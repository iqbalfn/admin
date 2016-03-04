<?php

/**
 * Calculate pagination
 * @param integer total Total all items.
 * @param integer current Current page.
 * @param integer rpp Result per page.
 * @param array args List of additional argument to append to URL
 * @return array list of pagination object.
 */
function calculate_pagination($total, $current=1, $rpp=12, $args=array()){
    $max_page = ceil($total/$rpp);
    if(!$max_page || $max_page < 2)
        return false;
    
    $first_page = $current - 5;
    if($first_page < 1)
        $first_page = 1;
    
    $last_page = $first_page + 9;
    if($last_page > $max_page){
        $last_page = $max_page;
        
        if($last_page - $first_page < 10){
            $first_page = $last_page - 9;
            if($first_page < 1)
                $first_page = 1;
        }
    }
    
    $prev = $current - 1;
    if($prev < 1)
        $prev = false;
    
    if($prev)
        $args['page'] = $prev;
    $pagging = array(
        '&#171;' => $prev ? '?' . http_build_query($args) : '#'
    );
    
    for($i=$first_page; $i<=$last_page; $i++){
        $args['page'] = $i;
        $page = $current == $i ? '#' : '?' . http_build_query($args);
        $pagging[$i] = $page;
    }
    
    $next = $current + 1;
    if($current >= $max_page)
        $next = false;
    
    if($next)
        $args['page'] = $next;
    $pagging['&#187;'] = $next ? '?' . http_build_query($args) : '#';
    
    return $pagging;
}