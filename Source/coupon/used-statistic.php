<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_USED_STATISTIC, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thống kê sử dụng</title>
        <?php require_once '../part/cssjs.php'; ?>        
    </head>
    <body>
        <div id="body-wrapper">
            <?php
            require_once '../part/menu.php';
            ?>
            <div id="main-content">
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thống kê sử dụng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form method="post" action="">
                                <?php
                                require_once '../models/coupon_assign.php';
                                require_once '../models/coupon_used.php';
                                require_once '../models/helper.php';
                                
                                
                                ?>
                                <fieldset>
                                    <p>
                                        <label for="year">Chọn năm (*)</label>
                                        <select class="small-input" name="year" id="year">
                                            <?php for($year = date('Y'); $year >= date('Y') - 5; $year--): ?>
    										<option value="<?php echo $year; ?>"
    										        <?php
    										        if(isset($_POST['year']) && $_POST['year'] == $year)
    										            echo "selected='selected'";
    										        ?>
    										        ><?php echo $year; ?></option>
    										<?php endfor; ?>
									    </select>
                                        <br /><small>Chọn năm cần thống kê</small>
                                    </p>
                                    <p>
                                        <input type="submit" class="button" value="Thống kê" name="submit">
                                    </p>
                                    <?php                                    
                                    if(isset($_POST['submit'])):
                                        require_once '../libchart/libchart/classes/libchart.php';
                                    
                                        $year = $_POST['year'];
                                    
                                        $chart = new VerticalBarChart(850, 500);
                                        
                                        $db = new coupon_assign();
                                        $array = $db->statistic($year);
                                        $serie1 = new XYDataSet();
                                        foreach ($array as $key => $value)
                                        {
                                            $serie1->addPoint(new Point($key, $value));
                                        }
                                        
                                        $db = new coupon_used();
                                        $array = $db->statistic($year);
                                        $serie2 = new XYDataSet();
                                        foreach ($array as $key => $value)
                                        {
                                            $serie2->addPoint(new Point($key, $value));
                                        }
                                        
                                        $dataSet = new XYSeriesDataSet();
                                        $dataSet->addSerie("Assign", $serie1);
                                        $dataSet->addSerie("Used", $serie2);
                                        $chart->setDataSet($dataSet);
                                        $chart->getPlot()->setGraphCaptionRatio(0.65);
                                        
                                        $chart->setTitle("Thống kê tình hình sử dụng coupon năm " . $year);
                                        $chart->render("../libchart/generated/vertical_chart.png");
                                    ?>
                                    <p>
                                        <img style="border: 1px solid gray;" alt="Line chart" src="../libchart/generated/vertical_chart.png" />
                                    </p>
                                    <?php endif; ?>
                                </fieldset>
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>                    
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>