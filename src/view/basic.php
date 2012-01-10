<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>UI Puzzle</title>
	<link rel="stylesheet/css" type="text/css" href="view/layout.css"></link><!-- backup compiled css -->
	<link rel="stylesheet/less" type="text/css" href="view/layout.less"></link>
	<script src="view/js/less.js" type="text/javascript"></script>
</head>
<body>
<div id="calendar">
    <div id="times_bar">
        <div class="main_hour">9:00</div><div class="am_pm">AM</div><br />
        <div class="half_hour">9:30</div>
        <div class="main_hour">10:00</div><div class="am_pm">AM</div><br />
        <div class="half_hour">10:30</div>
        <div class="main_hour">11:00</div><div class="am_pm">AM</div><br />
        <div class="half_hour">11:30</div>
        <div class="main_hour">12:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">12:30</div>
        <div class="main_hour">1:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">1:30</div>
        <div class="main_hour">2:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">2:30</div>
        <div class="main_hour">3:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">3:30</div>
        <div class="main_hour">4:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">4:30</div>
        <div class="main_hour">5:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">5:30</div>
        <div class="main_hour">6:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">6:30</div>
        <div class="main_hour">7:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">7:30</div>
        <div class="main_hour">8:00</div><div class="am_pm">PM</div><br />
        <div class="half_hour">8:30</div>
        <div class="main_hour">9:00</div><div class="am_pm">PM</div><br />
    </div>
    <div id="canvas">
        <div id="canvas_wrap">
            <?php
            foreach($eventPostions as $item) { 
            ?><div class="event" style="width: <?php echo $item->width ?>px; top: <?php echo $item->top ?>px; left: <?php echo $item->left ?>px;height: <?php echo $item->end - $item->start; ?>px;">
                <div class="event_wrap">
                    <div class="id"><?php echo $item->id; ?></div>
                    <div class="title"><?php echo $item->title; ?></div>
                    <div class="location"><?php echo $item->location; ?></div>
                </div>
            </div><?php } ?>
        </div>
    </div><!-- //end of canvas -->
</div><!-- //end of calendar -->
</body> 
</html>