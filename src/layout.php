<?php
include_once('event.php');
include_once('column.php');

class Layout {
    
    public function __construct() {
        //do nothing
    }
    
    public function layOutDay($events) {
        
        $matrix = new Calendar(); //matrix = [column, column ...];
        usort($events, array('Event', 'sortAsc')); //sort events array
        
        $it = new EventArrayIterator($events); //create iterator
        $it->toString();
        
        while($it->hasNext()) {
            $colIndex = $matrix->getClosestCol($it->getCurrent()->start);
            
            if($colIndex === -1) {
                $col = new Column(); //create new column
                $col->put($it->getCurrent()); //put event in column
                $matrix->put($col); //put column in matrix
            }
            else {
                $matrix->get($colIndex)->put($it->getCurrent()); //put event in existing col
            }

            
            $it->unsetCurrent();
            $matrix->sort();
        }
        $matrix->revSort();
        
        //echo "( MATRIX = )";
        //echo $matrix->toString();
        
        $eventPositionsArray = $this->calcPos($matrix);
        
        $matrix->extendWidths(); //extend the width of events who have no collissions
        
        return $eventPositionsArray;
    }
    
    public function calcPos($matrix) {
        $eventPositionsArray = array();
        
        for($y = 0; $y < $matrix->getSize(); $y++) {
            $column = $matrix->get($y);
            
            for($x = 0; $x < $column->getSize(); $x++) {
                $column->get($x)->top = $column->get($x)->start;
                $column->get($x)->width = $matrix->WIDTH/$matrix->getSize();
                $column->get($x)->left = ($y) * $column->get($x)->width;
                $eventPositionsArray[] = $column->get($x);
            }
        }
        return $eventPositionsArray;
    }
    
    public function getPage($eventPostions) {
        //invoke a view
        include('view/basic.php');
    }
}

?>
