<?php
//class dependencies

include_once('layout.php');

$a = new Event(0, 30, 150); //An event that starts at 9:30am and ends at 11:30am
$b = new Event(1, 540, 600); //An event that starts at 6:00pm and ends at 7:00pm
$c = new Event(2, 560, 620); //An event that starts at 6:20pm and ends at 7:20pm
$d = new Event(3, 610, 670); //An event that starts at 7:10pm pm and ends at 8:10pm

$events = array($a, $b, $c, $d); // array of events

/*
for($x =0; $x < 10; $x++) {
    $a = rand(0 , 720);
    $b = rand($a , 720);
    $events[] = new Event(4+ $x, $a, $b);
}

foreach($events as $item) {
    echo $item->toString();
}
 */


//create layout object
$layout = new Layout();

//generate the position of elements
$eventPositions = $layout->layOutDay($events);

//generate HTML page from event params
$layout->getPage($eventPositions);

?>
