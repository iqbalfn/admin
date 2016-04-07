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
            
                <?php if($ranks): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header"><h2><?= $title ?></h2></div>
                    </div>
                    
                    <?php foreach($ranks as $vendor => $data): ?>
                    <div class="col-md-6">
                        <fieldset>
                            <legend>
                                <a href="<?= base_url('/admin/stat/calculate/'.$vendor) ?>" title="<?= _l('Refresh') ?>"><sup class="glyphicon glyphicon-refresh"></sup></a>
                                <?= ucfirst($vendor); ?>
                                <sub>(
                                    <span title="<?= _l('International') ?>"><?= number_format($ranks[$vendor][(count($ranks[$vendor])-1)]['data'][0]['label']) ?></span> /
                                    <span title="<?= _l('Local') ?>"><?= number_format($ranks[$vendor][(count($ranks[$vendor])-1)]['data'][1]['label']) ?></span>
                                )</sub>
                            </legend>
                        </fieldset>
                        
                        <canvas width="555" height="200" class="chart" data-chart='<?= json_encode($ranks[$vendor], JSON_UNESCAPED_SLASHES) ?>'></canvas>
                        <div>&#160;</div>
                        
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?= _l('Date') ?></th>
                                    <th colspan="2" class="text-center"><?= _l('International') ?></th>
                                    <th colspan="2" class="text-center"><?= _l('Local') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php krsort($data); ?>
                            <?php foreach($data as $index => $row): ?>
                            <?php $next_row = $index ? $data[($index-1)] : null; ?>
                            <tr>
                                <td><?= $row['name'] ?></td>
                                <td class="text-right"><?php
                                    if($next_row){
                                        $next_row_rank = $next_row['data'][0]['label'];
                                        $diff = $next_row_rank - $row['data'][0]['label'];
                                        if($diff){
                                            if($diff < 0)
                                                echo '<span class="text-danger">' . number_format(abs($diff)) . ' <i class="glyphicon glyphicon-triangle-bottom"></i></span>';
                                            else
                                                echo '<span class="text-success">' . number_format($diff) . ' <i class="glyphicon glyphicon-triangle-top"></i></span>';
                                        }
                                    }
                                ?></td>
                                <td><?= number_format($row['data'][0]['label']) ?></td>
                                <td class="text-right"><?php
                                    if($next_row){
                                        $next_row_rank = $next_row['data'][1]['label'];
                                        $diff = $next_row_rank - $row['data'][1]['label'];
                                        if($diff){
                                            if($diff < 0)
                                                echo '<span class="text-danger">' . number_format(abs($diff)) . ' <i class="glyphicon glyphicon-triangle-bottom"></i></span>';
                                            else
                                                echo '<span class="text-success">' . number_format($diff) . ' <i class="glyphicon glyphicon-triangle-top"></i></span>';
                                        }
                                    }
                                ?></td>
                                <td><?= number_format($row['data'][1]['label']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endforeach; ?>
                    
                </div>
                <?php endif; ?>
                
            </div>
            
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>