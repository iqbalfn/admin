<?php

class SiteMenu
{
    private $menus = array();
    private $CI;
    
    function __construct(){
        $this->CI =&get_instance();
    }
    
    /**
     * Generate admin menu
     * @return array the menu
     */
    private function _generateAdminMenu(){
        if(!$this->CI->user){
            $this->menus['admin'] = array();
            return $this->menus['admin'];
        }
        
        $menus = array(
            array(
                'label' => 'Home',
                'perms' => 'read_admin-page',
                'target'=> '/admin',
                'submenu' => array(
                    array(
                        'label' => 'Generate Alexa Rank',
                        'perms' => 'create_alexa-rank',
                        'target'=> '/admin/rank/alexa'
                    )
                )
            ),
            array(
                'label' => 'User',
                'perms' => 'read_admin-user',
                'target'=> '/admin/user'
            ),
            array(
                'label' => 'Setting',
                'submenu' => array(
                    array(
                        'label' => 'System Enum',
                        'perms' => 'read_system-enum',
                        'target'=> '/admin/enum'
                    ),
                    array(
                        'label' => '---',
                        'perms' => 'read_site-param'
                    ),
                    array(
                        'label' => 'System Params',
                        'perms' => 'read_site-param',
                        'target'=> '/admin/param'
                    )
                )
            )
        );
        
        $admin_menu = array();
        
        foreach($menus as $menu){
            $menu_label    = $menu['label'];
            $menu_perms    = array_key_value_or('perms', $menu);
            $menu_show     = $menu_perms ? $this->CI->can_i($menu_perms) : false;
            $menu_sub      = array_key_value_or('submenu', $menu);
            $menu_sub_show = false;
            $menu_target   = array_key_value_or('target', $menu);
            
            $admin_submenu_items = [];
            
            if($menu_sub){
                foreach($menu_sub as $submenu){
                    $submenu_perms = $submenu['perms'];
                    $submenu_show  = $this->CI->can_i($submenu_perms);
                    
                    if($submenu_show){
                        $menu_sub_show = true;
                        if(!$menu_show){
                            $menu_show = true;
                            $menu_target= '';
                        }
                        
                        $admin_submenu_item = array('label' => $submenu['label']);
                        
                        if(array_key_exists('target', $submenu))
                            $admin_submenu_item['target'] = $submenu['target'];
                        
                        $admin_submenu_items[] = $admin_submenu_item;
                    }
                }
            }
            
            if(!$menu_show)
                continue;
            
            $admin_menu_item = array('label' => $menu_label);
            if($menu_target)
                $admin_menu_item['target'] = $menu_target;
            
            if($menu_sub_show)
                $admin_menu_item['submenu'] = $admin_submenu_items;
            
            $admin_menu[] = $admin_menu_item;
        }
        
        return ($this->menus['admin'] = $admin_menu);
    }
    
    /**
     * Get the menu based on menu name.
     * @param string name The menu name.
     * @return array The menu.
     */
    public function item($name){
        if(array_key_exists($name, $this->menus))
            return $this->menus[$name];
        
        if($name == 'admin')
            return $this->_generateAdminMenu();
    }
}