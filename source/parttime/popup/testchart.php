<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>jqPlot Examples</title>

    <script language="javascript" type="text/javascript" src="../resources/scripts/jquery-1.6.1.min.js"></script>
    <script language="javascript" type="text/javascript" src="../resources/scripts/charts/jquery.jqplot.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../resources/scripts/charts/jquery.jqplot.css" />
    <script type="text/javascript" src="../resources/scripts/charts/plugins/jqplot.pieRenderer.min.js"></script>
    <script type="text/javascript" src="../resources/scripts/charts/plugins/jqplot.donutRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="../resources/scripts/utility/dashboard/customer_statistic.js"></script>
 </head>
    <body>
    <h1>jqPlot Examples</h1>

    <script id="source" language="javascript" type="text/javascript">
$(document).ready(function(){
    var dataT = [];
    dataT=statistic();
    console.log("*************"+dataT+ "*****************");
    var plot1 = $.jqplot('pie1', [dataT], {
        gridPadding: {top:0, bottom:38, left:0, right:0},
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer, 
            trendline:{ show:false }, 
            rendererOptions: { padding: 8, showDataLabels: true }
        },
        legend:{
            show:true, 
            placement: 'outside', 
            rendererOptions: {
                numberRows: 1
            }, 
            location:'s',
            marginTop: '15px'
        }       
    });
});
    </script>
   <div id="pie1" style="height:300px;width:300px; "></div>
   <div id="ipe2" style="height:300px;width:300px; "> </div>
 </body>
</html>
<html>
