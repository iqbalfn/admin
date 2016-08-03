window.tmplCtrl = `&lt;?php                                                     | 1
                                                                                | 1
if(!defined('BASEPATH'))                                                        | 1
    die;                                                                        | 1
                                                                                | 1
/**                                                                             | 1
 * The '#ctrl_name#' controller                                                 | 1
 */                                                                             | 1
class #ctrl_name# extends #ctrl_parent#                                         | 1
{                                                                               | 1
                                                                                | 1
    function __construct(){                                                     | 1
        parent::__construct();                                                  | 1
                                                                                | model_name
        $this->load->model('#model_name#_model', '#model_name#');               | model_name
    }                                                                           | 1
                                                                                | ctrl_edit
    function edit($id=null){                                                    | ctrl_edit
        if(!$this->user)                                                        | ctrl_edit
            return $this->redirect('/admin/me/login?next=' . uri_string());     | ctrl_edit
        if(!$id && !$this->can_i('#ctrl_edit_permission_create#'))              | ctrl_edit, ctrl_edit_permission_create
            return $this->show_404();                                           | ctrl_edit, ctrl_edit_permission_create
        if($id && !$this->can_i('#ctrl_edit_permission_edit#'))                 | ctrl_edit, ctrl_edit_permission_edit
            return $this->show_404();                                           | ctrl_edit, ctrl_edit_permission_edit
                                                                                | ctrl_edit
        $this->load->library('SiteForm', '', 'form');                           | ctrl_edit
                                                                                | ctrl_edit
        $params = [];                                                           | ctrl_edit
                                                                                | ctrl_edit
        if($id){                                                                | ctrl_edit
            $object = $this->#model_name#->get($id);                            | ctrl_edit
            if(!$object)                                                        | ctrl_edit
                return $this->show_404();                                       | ctrl_edit
            if($object->user != $this->user->id)                                | ctrl_edit, ctrl_edit_mine_only
                return $this->show_404();                                       | ctrl_edit, ctrl_edit_mine_only
            $params['title'] = _l('#ctrl_edit_title_edit#');                    | ctrl_edit
        }else{                                                                  | ctrl_edit, ctrl_edit_permission_create
            $object = (object)array();                                          | ctrl_edit, ctrl_edit_permission_create
            $params['title'] = _l('#ctrl_edit_title_create#');                  | ctrl_edit, ctrl_edit_permission_create
        }else{                                                                  | ctrl_edit, !ctrl_edit_permission_create
            return $this->show_404();                                           | ctrl_edit, !ctrl_edit_permission_create
        }                                                                       | ctrl_edit
                                                                                | ctrl_edit
        $this->form->setObject($object);                                        | ctrl_edit
        $this->form->setForm('#ctrl_edit_form_name#');                          | ctrl_edit
                                                                                | ctrl_edit
        $params['#table_name#'] = $object;                                      | ctrl_edit
                                                                                | ctrl_edit
        if(!($new_object=$this->form->validate($object)))                       | ctrl_edit
            return $this->respond('#ctrl_edit_view#', $params);                 | ctrl_edit
                                                                                | ctrl_edit
        if($new_object === true)                                                | ctrl_edit
            return $this->redirect('#ctrl_edit_redirect#');                     | ctrl_edit
                                                                                | ctrl_edit, ctrl_edit_set_updated_field
        $new_object['updated'] = date('Y-m-d H:i:s');                           | ctrl_edit, ctrl_edit_set_updated_field
                                                                                | ctrl_edit
        if(!$id){                                                               | ctrl_edit, ctrl_edit_permission_create
            $new_object['user'] = $this->user->id;                              | ctrl_edit, ctrl_edit_set_user_field, ctrl_edit_permission_create
            $new_object['id'] = $this->#model_name#->create($new_object);       | ctrl_edit, ctrl_edit_permission_create
        }else{                                                                  | ctrl_edit, ctrl_edit_permission_create
            $this->#model_name#->set($id, $new_object);                         | ctrl_edit, ctrl_edit_permission_create
        }                                                                       | ctrl_edit, ctrl_edit_permission_create
        $this->#model_name#->set($id, $new_object);                             | ctrl_edit, !ctrl_edit_permission_create
                                                                                | ctrl_edit
        $this->redirect('#ctrl_edit_redirect#');                                | ctrl_edit
    }                                                                           | ctrl_edit
                                                                                | ctrl_index
    function index(){                                                           | ctrl_index
        if(!$this->user)                                                        | ctrl_index
            return $this->redirect('/admin/me/login?next=' . uri_string());     | ctrl_index
        if(!$this->can_i('#ctrl_index_permission#'))                            | ctrl_index, ctrl_index_permission
            return $this->show_404();                                           | ctrl_index, ctrl_index_permission
                                                                                | ctrl_index
        $params = array(                                                        | ctrl_index
            'title' => _l('#ctrl_index_title#'),                                | ctrl_index
            '#ctrl_index_param_name#' => []                                     | ctrl_index, !ctrl_index_rpp
            '#ctrl_index_param_name#' => [],                                    | ctrl_index, ctrl_index_rpp
            'pagination' => false                                               | ctrl_index, ctrl_index_rpp
        );                                                                      | ctrl_index
                                                                                | ctrl_index
        $cond = array();                                                        | ctrl_index
        $cond['user'] = $this->user->id;                                        | ctrl_index, ctrl_index_mine_only
                                                                                | ctrl_index, ctrl_index_params_filter
        $args = [#ctrl_index_params_filter#];                                   | ctrl_index, ctrl_index_params_filter
        foreach($args as $arg){                                                 | ctrl_index, ctrl_index_params_filter
            $arg_val = $this->input->get($arg);                                 | ctrl_index, ctrl_index_params_filter
            if($arg_val)                                                        | ctrl_index, ctrl_index_params_filter
                $cond[$arg] = $arg_val;                                         | ctrl_index, ctrl_index_params_filter
        }                                                                       | ctrl_index, ctrl_index_params_filter
                                                                                | ctrl_index
        $rpp = #ctrl_index_rpp#;                                                | ctrl_index, ctrl_index_rpp
        $page= $this->input->get('page');                                       | ctrl_index, ctrl_index_rpp
        if(!$page)                                                              | ctrl_index, ctrl_index_rpp
            $page = 1;                                                          | ctrl_index, ctrl_index_rpp
        $rpp = true;                                                            | ctrl_index, !ctrl_index_rpp
        $page= false;                                                           | ctrl_index, !ctrl_index_rpp
                                                                                | ctrl_index
        $result = $this->#model_name#->getByCond($cond, $rpp, $page);                               | ctrl_index
        if($result){                                                                                | ctrl_index
            $this->load->library('ObjectFormatter', '', 'formatter');           | ctrl_index
            $params['#ctrl_index_param_name#'] = $this->formatter->#table_name#($result, false, true); | ctrl_index
        }                                                                              | ctrl_index, ctrl_index_rpp
                                                                                       | ctrl_index, ctrl_index_rpp
        // for pagination                                                              | ctrl_index, ctrl_index_rpp
        $total = $this->#model_name#->countByCond($cond);                              | ctrl_index, ctrl_index_rpp
        if($total > $rpp){                                                             | ctrl_index, ctrl_index_rpp
            $pcond = $cond;                                                            | ctrl_index, ctrl_index_rpp
            $this->load->helper('pagination');                                         | ctrl_index, ctrl_index_rpp
            $params['pagination'] = calculate_pagination($total, $page, $rpp, $pcond); | ctrl_index, ctrl_index_rpp
        }                                                                              | ctrl_index, ctrl_index_rpp
                                                                                | ctrl_index
        $this->respond('#ctrl_index_view#', $params);                           | ctrl_index
    }                                                                           | ctrl_index
                                                                                | ctrl_remove
    public function remove($id){                                                | ctrl_remove
        if(!$this->user)                                                        | ctrl_remove
            return $this->redirect('/admin/me/login?next=' . uri_string());     | ctrl_remove
        if(!$this->can_i('#ctrl_remove_permission#'))                           | ctrl_remove, ctrl_remove_permission
            return $this->show_404();                                           | ctrl_remove, ctrl_remove_permission
                                                                                | ctrl_remove
        $object = $this->#model_name#->get($id);                                | ctrl_remove, ctrl_remove_mine_only
        if($object){                                                            | ctrl_remove, ctrl_remove_mine_only
            if($object->user != $this->user->id)                                | ctrl_remove, ctrl_remove_mine_only
                return $this->show_404();                                       | ctrl_remove, ctrl_remove_mine_only
        }                                                                       | ctrl_remove, ctrl_remove_mine_only
                                                                                | ctrl_remove, ctrl_remove_mine_only
        $this->cache->file->delete('#ctrl_remove_cache#');                      | ctrl_remove, ctrl_remove_cache
                                                                                | ctrl_remove, ctrl_remove_cache
        $this->#model_name#->remove($id);                                       | ctrl_remove
        $this->redirect('#ctrl_remove_redirect#');                              | ctrl_remove
    }                                                                           | ctrl_remove
}                                                                               | 1`;

$(function(){
    var form = $('form');
    
    form.submit(function(){
        var Data = {};
        
        $('input').each(function(i,e){
            var id = e.id;
            var val= e.value;
            if(e.type == 'checkbox')
                val = e.checked;
            
            Data[id] = val;
        });
        
        if(Data.table_name){
            var model_name = Data.table_name.toLowerCase().replace(/[^a-z0-9]/g,'');
            Data.model_name = model_name[0].toUpperCase() + model_name.slice(1).toLowerCase();
        }
        
        var ct = tmplCtrl.split('\n');
        var tx = [];
        
        for(var i=0; i<ct.length; i++){
            var tx_rules = ct[i].split('|');
            var tx_rule  = tx_rules.pop().trim();
            
            if(tx_rule != 1){
                var tx_rule = tx_rule.split(',');
                var show = true;
                for(var j=0; j<tx_rule.length; j++){
                    var varl = tx_rule[j].trim();
                    var reverse = false;
                    
                    if(varl[0] == '!'){
                        varl = varl.slice(1);
                        reverse = true;
                    }
                    
                    if(reverse == !!Data[varl]){
                        show = false;
                        break;
                    }
                }
                
                if(!show)
                    continue;
            }
            
            tx_rules = tx_rules.join('|').replace(/([ ]+)$/,'');
            
            for(var k in Data){
                var kre = new RegExp('#'+k+'#', 'g');
                tx_rules = tx_rules.replace(kre, Data[k]);
            }
            tx.push(tx_rules);
        }
        
        $('#ctrl-result').html(tx.join('\n'));
        
        return false;
    });
    
    $('#table_name').change(function(){
        var val = $(this).val();
        $('.value-table-based').each(function(i,e){
            var $e = $(e);
            
            if($e.data('touched'))
                return;
            
            var value = $e.data('perms').replace(/\$\$/g, val);
            if($e.hasClass('value-slashed-trans'))
                value = value.replace(/_/g, '/');
            if($e.hasClass('value-last-trim')){
                value = value.split('_');
                value = value[value.length-1];
            }
            $e.val(value);
        });
        
        var title = val.replace(/_/g, ' ');
        title = title[0].toUpperCase() + title.slice(1);
        title = title.replace(/ ([a-z])/g, function(m){ return m.toUpperCase(); });
        
        $('#ctrl_edit_title_edit').val('Edit '+title);
        $('#ctrl_edit_title_create').val('Create New '+title);
        $('#ctrl_index_title').val(title);
    });
    
    $('.value-table-based').focus(function(){
        $(this).data('touched', true);
    });
});