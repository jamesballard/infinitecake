<?php
/* CAT:Polar and radars */
$day = $_GET['dayData'];
$night = $_GET['nightData'];

$dayData = unserialize(base64_decode($day));
$nightData = unserialize(base64_decode($night));

/* pChart library inclusions */
include("../../../Vendor/pChart/pData.class.php");
include("../../../Vendor/pChart/pDraw.class.php");
include("../../../Vendor/pChart/pRadar.class.php");
include("../../../Vendor/pChart/pImage.class.php");

/* Create and populate the pData object */
$MyData = new pData();
$MyData->addPoints($dayData,"Activity1");
$MyData->addPoints($nightData,"Activity2");
$MyData->setSerieDescription("Activity1","Day");
$MyData->setSerieDescription("Activity2","Night");
$MyData->setPalette("Activity",array("R"=>157,"G"=>196,"B"=>22));

/* Define the absissa serie */
$MyData->addPoints(array("I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII"),"Time");
$MyData->setAbscissa("Time");

/* Create the pChart object */
$myPicture = new pImage(750,500,$MyData);
$myPicture->drawGradientArea(0,0,750,500,DIRECTION_VERTICAL,array("StartR"=>200,"StartG"=>200,"StartB"=>200,"EndR"=>240,"EndG"=>240,"EndB"=>240,"Alpha"=>100));
$myPicture->drawGradientArea(0,0,750,20,DIRECTION_HORIZONTAL,array("StartR"=>30,"StartG"=>30,"StartB"=>30,"EndR"=>100,"EndG"=>100,"EndB"=>100,"Alpha"=>100));
$myPicture->drawLine(0,20,500,20,array("R"=>255,"G"=>255,"B"=>255));
$RectangleSettings = array("R"=>180,"G"=>180,"B"=>180,"Alpha"=>100);

/* Add a border to the picture */
$myPicture->drawRectangle(0,0,749,499,array("R"=>0,"G"=>0,"B"=>0));

/* Write the picture title */
$myPicture->setFontProperties(array("FontName"=>"../../../Vendor/pChart/fonts/helvetica.ttf","FontSize"=>12));
$myPicture->drawText(10,13,"Around the Clock",array("R"=>255,"G"=>255,"B"=>255));

/* Set the default font properties */
$myPicture->setFontProperties(array("FontName"=>"../../../Vendor/pChart/fonts/helvetica.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

/* Enable shadow computing */
$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

/* Create the pRadar object */
$SplitChart = new pRadar();

/* Draw a radar chart */
$myPicture->setGraphArea(10,25,740,490);
$Options = array("DrawPoly"=>TRUE,"AxisRotation"=>-60,"Layout"=>RADAR_LAYOUT_CIRCLE,"LabelPos"=>RADAR_LABELS_HORIZONTAL);
$SplitChart->drawRadar($myPicture,$MyData,$Options);

/* Write the chart legend */
$myPicture->setFontProperties(array("FontName"=>"../../../Vendor/pChart/fonts/helvetica.ttf","FontSize"=>10));
$myPicture->drawLegend(655,35,array("Style"=>LEGEND_BOX,"Mode"=>LEGEND_HORIZONTAL));

/* Render the picture (choose the best way) */
//$myPicture->autoOutput("pictures/example.radar.values.png");
$myPicture->Stroke();

?>