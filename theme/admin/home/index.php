<!DOCTYPE html>
<html lang="en-US">
<head>
    <?= $this->theme->file('head') ?>
</head>
<body>
    <?= $this->theme->file('header') ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="page-header"><h2>
                        <a class="btn btn-default" href="<?= base_url('/admin/stat/calculate/alexa') ?>">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </a>
                        Alexa
                    </h2>
                </div>
                <canvas id="rank-alexa" width="555" height="250"></canvas>
                <?php if(array_key_exists('alexa', $ranks)): ?>
                <div class="row">
                    <div class="col-md-6 text-right lead"><i class="glyphicon glyphicon-globe"></i> <?= number_format($ranks['alexa']['rank_international']) ?></div>
                    <div class="col-md-6 lead"><i class="glyphicon glyphicon-home"></i> <?= number_format($ranks['alexa']['rank_local']) ?></div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <div class="page-header">
                    <h2>
                        <a class="btn btn-default" href="<?= base_url('/admin/stat/calculate/similarweb') ?>">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </a>
                        SimilarWeb
                    </h2>
                </div>
                <canvas id="rank-similarweb" width="555" height="250"></canvas>
                <?php if(array_key_exists('similarweb', $ranks)): ?>
                <div class="row">
                    <div class="col-md-6 text-right lead"><i class="glyphicon glyphicon-globe"></i> <?= number_format($ranks['similarweb']['rank_international']) ?></div>
                    <div class="col-md-6 lead"><i class="glyphicon glyphicon-home"></i> <?= number_format($ranks['similarweb']['rank_local']) ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    <script>
        var dataRanks = <?= json_encode($ranks); ?>;
        var rankOptions = {
                animation: false,
                responsive: true,
                tooltipTemplate: function(v){ return Math.abs(v.value).toLocaleString(); },
                scaleShowVerticalLines: false,
                bezierCurve: false,
                scaleShowLabels: false,
                scaleFontSize: 10
            };
        for(var vendor in dataRanks){
            var ctx = document.getElementById('rank-' + vendor).getContext("2d");
            (new Chart(ctx).Line(dataRanks[vendor], rankOptions));
        }
    </script>
</body>
</html>