<?php

class Calendar {
    public $WIDTH;
    public $HEIGHT;
    public $columns;
    public $size;
    
    public function __construct() {
        $this->WIDTH = 600;
        $this->HEIGHT = 720;
        $this->columns = array();
        $this->size = 0;
    }
    
    public function get($index){
        if($index < $this->size){
            return $this->columns[$index];
        }

        //echo "Error";
        return -1;
    }
    
    public function put($column){
        $this->columns[] = $column;
        $this->size++;
    }
    
    public function getSize() {
        //return $this->size;
        return (count($this->columns));
    }
    
    //for debugging only
    public function toString() {
        $output = "[";
        foreach($this->columns as $column) {
            $output .= "[";
            for($x = 0; $x < $column->getSize(); $x++) {
                $output .= "{" . $column->get($x)->id . ", " . $column->get($x)->start . ", " . $column->get($x)->end . "}, ";
            }
            $output .= "], ";
        }
        $output .= "]";
        return $output;
    }
    
    public function sort() {
        usort($this->columns, array('Column', 'compareDesc'));
    }
    
    public function revSort() {
        usort($this->columns, array('Column', 'compareAsc'));
    }
    
    public function getEndTime() {
        if ($this->getSize() === 0){
            return -1;
        }
        $max = 0;
        foreach($this->columns as $col){
            if ($col->getEndTime() > $max){
                $max = $col->getEndTime();
            }
        }
        return $max; //allow fn to throw error naturally   
    }
    
    public function getClosestCol($start) {
        for($x = $this->getSize() - 1; $x >= 0; $x--) { //go backwards, to most tightly fill the gaps
            
            $currEndTime = $this->get($x)->getEndTime();
            
            //echo "(" . $start . ">" . $currEndTime . "-" . $x . ")";
            
            if($start >= $currEndTime) {
                //this means event should insert into a col: $x
                //echo "###/*Inserting into col:" . $x . "*/##";
                
                return $x;
            }
        }
        return -1;
    }
    
    public function extendWidths() {
        for($x = 0; $x < $this->getSize(); $x++) { //iterate over matrix columns;
            $it = new EventArrayIterator($this->get($x)->array);
            
            do {
                $extend = 0;
                //$it-getCurrent() is set up. now look ahead to all elements until overlap.
                
                for($y = $x; $y < $this->getSize() - 1; $y++) { //look ahead (from: next column to: one less than width). the last column does not need extensions
                    $newIT = new EventArrayIterator($this->get($y+1)->array);
                    $flag = false;
                    
                    do {
                        if ($it->getCurrent()->overlaps($newIT->getCurrent())){
                            $flag = true; //break this loop
                            $y = $this->getSize(); //break outer loop
                        }
                    } while(!$flag && $newIT->hasNext());
                    
                    if (!$flag) {
                        //extend width by one
                        $extend++;
                    }
                }

                //extend the width here
                $it->getCurrent()->width += $extend * $this->WIDTH/$this->getSize();
            } while ($it->getNext());
        }
    }
}

class Column {
    public $array;
    public $size;
    
    public function __construct() {
        $this->array = array();
        $this->size = 0;
    }
    
    public function put($event) {
        $this->array[] = $event;
        $this->size++;
    }
    
    public function get($index) { 
        //errors will be handled by throwing out of bounds error on the obj call
        if($index < $this->size){
            return $this->array[$index];
        }

        //echo "Error";
        return -1;
    }
    
    public function compareDesc($j, $k) {
        if ($j->getEndTime() == $k->getEndTime()) {
            return 0;
        }
        return ($j->getEndTime() < $k->getEndTime()) ? -1 : 1;
    }
    
    public function compareAsc($j, $k) {
        if ($j->getEndTime() == $k->getEndTime()) {
            return 0;
        }
        return ($j->getEndTime() > $k->getEndTime()) ? -1 : 1;
    }
    
    public function getSize() {
        //return $this->size;
        return count($this->array);
    }
    
    public function getEndTime() {
        if ($this->getSize() === 0){
            return 0;
        }
        return $this->array[$this->getSize() - 1]->end;
    }
    
    //for debugging only
    public function toString() {
        $output = "[";
        foreach($this->array as $column) {
            $output .= "{" . $column->id . ", " . $column->start . ", " . $column->end . "}, ";
        }
        $output .= "], ";
        return $output;
    }
}
?>
