<?php
    $menus = $this->menu->item('admin');
    if($menus){
        $tx = '';
        foreach($menus as $menu){
            $classes = [];
            $submenu = array_key_value_or('submenu', $menu);
            if($submenu)
                $classes[] = 'dropdown';
            $active_on_hover = array_key_exists('target', $menu);
            if($active_on_hover && $submenu)
                $classes[] = 'dropdown-toggle-on-hover';
            
            $tx.= '<li'.($classes?' class="'.implode(' ',$classes).'"':'').'>';
            
            $tx.= '<a';
            $tx.= array_key_exists('target', $menu) ? ' href="'.$menu['target'].'"' : '';
            if($submenu){
                $tx.= ' aria-expanded="false" aria-haspopup="true" role="button" class="dropdown-toggle"';
                if(!$active_on_hover)
                    $tx.= ' class="dropdown-toggle" data-toggle="dropdown"';
            }
            $tx.= '>';
            
            $tx.= _l($menu['label']);
            $tx.= $submenu ? ' <span class="caret"></span>' : '';
            $tx.= '</a>';
            
            if($submenu){
                $tx.= '<ul class="dropdown-menu">';
                foreach($submenu as $sub){
                    if($sub['label'] == '---'){
                        $tx.= '<li class="divider" role="separator"></li>';
                    }else{
                        $tx.= '<li>';
                        $tx.=   '<a href="' . $sub['target'] . '">';
                        $tx.=       $sub['label'];
                        $tx.=   '</a>';
                        $tx.= '</li>';
                    }
                }
                $tx.= '</ul>';
            }
            $tx.= '</li>';
        }
        
        echo $tx;
    }
?>