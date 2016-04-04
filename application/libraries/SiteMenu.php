<?php

class SiteMenu
{
    private $menus = array();
    private $CI;
    
    function __construct(){
        $this->CI =&get_instance();
        
        $site_menus = $this->CI->cache->file->get('site_menu');
        
        if(!$site_menus || is_dev()){
            $this->CI->load->model('Sitemenu_model', 'SMenu');
            $site_menus = $this->CI->SMenu->getByCond([], true, false, ['index'=>'ASC']);
            if($site_menus){
                $site_menus = group_by_prop($site_menus, 'group');
                foreach($site_menus as &$site_menu)
                    $site_menu = group_by_prop($site_menu, 'parent');
            }
            $this->CI->cache->file->save('site_menu', $site_menus, 604800);
        }
        
        if($site_menus)
            $this->menus = $site_menus;
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
                'perms' => 'read-admin_page',
                'target'=> '/admin'
            ),
            array(
                'label' => 'Post',
                'perms' => 'read-post',
                'target'=> '/admin/post',
                'submenu' => array(
                    array(
                        'label' => 'Category',
                        'perms' => 'read-post_category',
                        'target'=> '/admin/post/category'
                    ),
                    array(
                        'label' => 'Tag',
                        'perms' => 'read-post_tag',
                        'target'=> '/admin/post/tag'
                    ),
                    array(
                        'label' => 'Selector',
                        'perms' => 'read-post_selector',
                        'target'=> '/admin/post/selector'
                    )
                )
            ),
            array(
                'label' => 'Banner',
                'perms' => 'read-banner',
                'target'=> '/admin/banner'
            ),
            array(
                'label' => 'Gallery',
                'perms' => 'read-gallery',
                'target'=> '/admin/gallery'
            ),
            array(
                'label' => 'Page',
                'perms' => 'read-page',
                'target'=> '/admin/page'
            ),
            array(
                'label' => 'User',
                'perms' => 'read-user',
                'target'=> '/admin/user'
            ),
            array(
                'label' => 'Stat',
                'perms' => 'read-site_statistic',
                'target'=> '/admin/stat'
            ),
            array(
                'label' => 'Setting',
                'submenu' => array(
                    array(
                        'label' => 'Site Enum',
                        'perms' => 'read-site_enum',
                        'target'=> '/admin/setting/enum'
                    ),
                    array(
                        'label' => 'Site Menus',
                        'perms' => 'read-site_menu',
                        'target'=> '/admin/setting/menu'
                    ),
                    array(
                        'label' => 'Site Params',
                        'perms' => 'read-site_param',
                        'target'=> '/admin/setting/param'
                    ),
                    array(
                        'label' => 'SlideShow',
                        'perms' => 'read-slide_show',
                        'target'=> '/admin/setting/slideshow'
                    ),
                    array(
                        'label' => 'URL Redirection',
                        'perms' => 'read-url_redirection',
                        'target'=> '/admin/setting/redirection'
                    ),
                    array(
                        'label' => 'Clear All Cache',
                        'perms' => 'delete-cache',
                        'target'=> '/admin/setting/cache/clear'
                    )
                )
            )
        );
        
        $admin_menu = array();
        $current_uri = '/' . uri_string();
        
        foreach($menus as $menu){
            $menu_label    = $menu['label'];
            $menu_perms    = array_key_value_or('perms', $menu);
            $menu_show     = $menu_perms ? $this->CI->can_i($menu_perms) : false;
            $menu_sub      = array_key_value_or('submenu', $menu);
            $menu_sub_show = false;
            $menu_target   = array_key_value_or('target', $menu);
            $menu_active   = false;
            
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
                        
                        $admin_submenu_item = array(
                            'label' => $submenu['label'],
                            'active' => false
                        );
                        
                        if(array_key_exists('target', $submenu)){
                            $admin_submenu_item['target'] = $submenu['target'];
                            if($submenu['target'] == $current_uri){
                                $menu_active = true;
                                $admin_submenu_item['active'] = true;
                            }
                        }
                        
                        $admin_submenu_items[] = $admin_submenu_item;
                    }
                }
            }
            
            if(!$menu_show)
                continue;
            
            $admin_menu_item = array(
                'label' => $menu_label,
                'active' => $menu_active
            );
            if($menu_target){
                $admin_menu_item['target'] = $menu_target;
                if($menu_target == $current_uri)
                    $admin_menu_item['active'] = true;
            }
            
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