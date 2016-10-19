<?php
    $header_menus = $this->menu->item('admin');
    if($header_menus){
        $tx = '';
        foreach($header_menus as $header_menu){
            $classes = [];
            $header_submenu = array_key_value_or('submenu', $header_menu);
            if($header_submenu)
                $classes[] = 'dropdown';
            $active_on_hover = array_key_exists('target', $header_menu);
            if($active_on_hover && $header_submenu)
                $classes[] = 'dropdown-toggle-on-hover';
            if($header_menu['active'])
                $classes[] = 'active';
            
            $tx.= '<li'.($classes?' class="'.implode(' ',$classes).'"':'').'>';
            
            $tx.= '<a';
            $tx.= array_key_exists('target', $header_menu) ? ' href="'.$header_menu['target'].'"' : '';
            if($header_submenu){
                $tx.= ' aria-expanded="false" aria-haspopup="true" role="button" class="dropdown-toggle"';
                if(!$active_on_hover)
                    $tx.= ' data-toggle="dropdown"';
            }
            $tx.= '>';
            
            $tx.= _l($header_menu['label']);
            $tx.= $header_submenu ? ' <span class="caret"></span>' : '';
            $tx.= '</a>';
            
            if($header_submenu){
                $tx.= '<ul class="dropdown-menu">';
                foreach($header_submenu as $sub){
                    if($sub['label'] == '---'){
                        $tx.= '<li class="divider" role="separator"></li>';
                    }else{
                        $cls = $sub['active'] ? ' class="active"' : '';
                        $tx.= '<li' . $cls . '>';
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