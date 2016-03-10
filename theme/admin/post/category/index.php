<!DOCTYPE html>
<html lang="en-US">
<head>
    <?= $this->theme->file('head') ?>
</head>
<body>
    <?= $this->theme->file('header') ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <?php if(ci()->can_i('create-post_category')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/post/category/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <?php
                    if(array_key_exists(0, $categories)){
                        $recursiver = function($parent, $index) use ($categories, &$recursiver){
                            if(!array_key_exists($parent, $categories))
                                return;
                            
                            $left_width = $index;
                            $right_width= 12 - $index;
                            $next_index = $index + 1;
                            
                            foreach($categories[$parent] as $cat){
                                echo '<div class="row">';
                                if($left_width)
                                    echo '<div class="col-md-' . $left_width . '"></div>';
                                
                                echo    '<div class="col-md-' . $right_width . '">';
                                echo        '<div class="list-group">';
                                echo            '<a href="' . base_url('/admin/post/category/' . $cat->id) . '" class="list-group-item">';
                                echo                '<h4 class="list-group-item-heading">' . $cat->name . '</h4>';
                                echo                '<p class="list-group-item-text">' . base_url($cat->page) . '</p>';
                                echo            '</a>';
                                echo            '<a href="' . base_url($cat->page) . '" class="list-group-closer btn btn-default btn-xs"><i class="glyphicon glyphicon-new-window"></i></a>';
                                echo        '</div>';
                                echo    '</div>';
                                echo '</div>';
                                
                                if(array_key_exists($cat->id, $categories))
                                    $recursiver($cat->id, $next_index);
                            }
                        };
                        
                        $recursiver(0, 0);
                    }
                ?>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>