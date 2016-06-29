(function ($) {
    'use strict';
    
    function randomRGBA(){
        var tx = 'rgba()';
        var r  = Math.floor((Math.random() * 250) + 0);
        var g  = Math.floor((Math.random() * 250) + 0);
        var b  = Math.floor((Math.random() * 250) + 0);
        var a  = 1;
        
        return 'rgba(' + [r,g,b,a].join(',') + ')';
    }
    
    $.fn.chart = function(presetCharts){
        return this.each(function(i,e){
            var $e = $(e);
            var dataCharts = $e.data('chart');
            var ctx = $e.get(0).getContext("2d");
            var data = { labels: [], datasets: [] };
            
            if(presetCharts)
                dataCharts = presetCharts;
        
            if(!dataCharts)
                return;
            
            var options = {
                    scaleShowVerticalLines: false,
                    bezierCurve: false,
                    animation: false,
                    scaleFontSize: 0,
                    responsive: true,
                    scaleShowLabels: false,
                    tooltipTemplate: function(tip){
                        var val = tip.value;
                        var label = tip.datasetLabel;
                        if(pointToLabel[label] && pointToLabel[label][val])
                            val = pointToLabel[label][val];
                        
                        val = parseInt(val);
                        if((val).toLocaleString)
                            val = (val).toLocaleString();
                        
                        if( label )
                            return label + ': ' + val;
                        return val;
                    }
                };
            options.multiTooltipTemplate = options.tooltipTemplate;
            
            var pointToLabel = [];
            
            for(var i=0; i<dataCharts.length; i++){
                var dataChart = dataCharts[i];
                
                data.labels.push(dataChart.name);
                for(var j=0; j<dataChart.data.length; j++){
                    var dataValues = dataChart.data[j];
                    
                    if(!data.datasets[j]){
                        data.datasets[j] = {
                            label: dataValues.title,
                            fillColor: 'transparent',
                            strokeColor: randomRGBA(),
                            pointColor: randomRGBA(),
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: randomRGBA(),
                            data: []
                        }
                    }
                    
                    if(!pointToLabel[dataValues.title])
                        pointToLabel[dataValues.title] = {};
                    pointToLabel[dataValues.title][dataValues.value] = dataValues.label;
                    data.datasets[j].data.push(dataValues.value);
                }
            }
            
            (new Chart(ctx)).Line(data, options);
        });
    };
    
})(jQuery);

$(function(){
    $('canvas.chart').chart();
});