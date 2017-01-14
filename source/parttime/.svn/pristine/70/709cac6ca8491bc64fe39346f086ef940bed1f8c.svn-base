<?php
	/* Libchart - PHP chart library
	 * Copyright (C) 2005-2011 Jean-Marc Trémeaux (jm.tremeaux at gmail.com)
	 * 
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 * 
	 */
	
	/**
	 * Multiple horizontal bar chart demonstration.
	 *
	 */

	include "../libchart/classes/libchart.php";

	$chart = new VerticalBarChart(850, 500);

	$serie1 = new XYDataSet();
	$serie1->addPoint(new Point("01", 20));
	$serie1->addPoint(new Point("02", 30));
	$serie1->addPoint(new Point("03", 58));
	$serie1->addPoint(new Point("04", 58));
	$serie1->addPoint(new Point("05", 46));
	$serie1->addPoint(new Point("06", 640));
	$serie1->addPoint(new Point("07", 500));
	$serie1->addPoint(new Point("08", 120));
	$serie1->addPoint(new Point("09", 150));
	$serie1->addPoint(new Point("10", 360));
	$serie1->addPoint(new Point("11", 460));
	$serie1->addPoint(new Point("12", 260));
	
	$serie2 = new XYDataSet();
	$serie2->addPoint(new Point("01", 10));
	$serie2->addPoint(new Point("02", 15));
	$serie2->addPoint(new Point("03", 48));
	$serie2->addPoint(new Point("04", 18));
	$serie2->addPoint(new Point("05", 20));
	$serie2->addPoint(new Point("06", 350));
	$serie2->addPoint(new Point("07", 400));
	$serie2->addPoint(new Point("08", 100));
	$serie2->addPoint(new Point("09", 105));
	$serie2->addPoint(new Point("10", 205));
	$serie2->addPoint(new Point("11", 250));
	$serie2->addPoint(new Point("12", 250));
	
	$dataSet = new XYSeriesDataSet();
	$dataSet->addSerie("Assign", $serie1);
	$dataSet->addSerie("Used", $serie2);
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphCaptionRatio(0.65);

	// $chart->setTitle("Average family income (k$)");
	$chart->setTitle("Thống kê tình hình sử dụng coupon năm 2012");
	$chart->render("generated/demo7.png");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Libchart line demonstration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<img alt="Line chart" src="generated/demo7.png" style="border: 1px solid gray;"/>
</body>
</html>
