<?php

class Event {
    public $id;
    public $start;
    public $end;
   	
    public $width;
    public $top;
    public $left;
    
    public $title;
    public $location;
    
    public function __construct($id, $start, $end, $title = "Sample Item", $loc = "Sample Location") {
        $this->id = $id;
        $this->start = $start;
        $this->end = $end;
        
        $this->title = $title;
        $this->location = $loc;
        
        $this->validate();
    }
    
    private function validate() {
        //Bounds for solution
        if ($this->start < 0) {
            throw new Exception('invalid start time');
        }
        if ($this->end > (2100 - 900)) {
            throw new Exception('invalid end time');
        }
    }
    
    public function toString() {
        return "// an event from " . $this->getStart() . " to " . $this->getEnd();
    }
    
    public function toStringRaw() {
        return "{ id : $this->id, start : $this->start, end : $this->end } ";
    }
    
    public function getStart() {
        $t1h = floor($this->start / 60);
        $t1m = $this->start - ($t1h * 60);

        $t1 = (((9 + $t1h) % 12)*100) + $t1m;
        $t1 .= (9 + $t1h >= 12) ? "pm": "am";
        
        return substr_replace($t1, ":", -4, -4);
        //return $t1;
    }
    
    public function getEnd() {
        $t2h = floor($this->end / 60);
        $t2m = $this->end - ($t2h * 60);

        $t2 = (((9 + $t2h) % 12)*100);
        $t2 = ($t2 === 0) ? 1200 : $t2;
        $t2 += $t2m;
        $t2 .= (9 + $t2h >= 12) ? "pm": "am";
        
        return substr_replace($t2, ":", -4, -4);
        return $t2;
    }
    
    function overlaps($that) {
        if ($this->start >= $that->start && $this->start < $that->end){return true;}
        if ($this->start <= $that->start && $this->end >= $that->end){return true;}
        if ($this->start >= $that->start && $this->end <= $that->end){return true;}
        if ($this->start <= $that->start && $this->end > $that->start){return true;}
        return false;
    }

    function sortDesc($j, $k) {
        if ($j->end == $k->end) {
            return 0;
        }
        
        return ($j->end < $k->end) ? -1 : 1;
    }
    
    function sortAsc($j, $k) {
        if ($j->end == $k->end) {
            return 0;
        }
        
        return ($j->end > $k->end) ? -1 : 1;
    }
}

//class needed for multiple position pointers. ie. need ways to keep track of current in layOutEvents()
class EventArrayIterator {
    public $array;
    
    public function __construct($array) {
        $this->array = $array;
    }
    
    public function getCurrent() {
        return current($this->array);
    }
    
    public function getCurrentKey() {
        return key($this->array);
    }
    
    public function unsetCurrent() {
        $key = key($this->array);
        unset($this->array[$key]);
        return;
    }
    
    public function getNext() {
        //returns -1 on no next obj
        return  next($this->array);
    }
    
    public function getPrev() {
        return prev($this->array);
    }
    
    public function hasNext() {
        return(current($this->array) !== end($this->array));
    }
    
    public function reset() {
        reset($this->array);
    }
    public function toString() {
        $output = "[";
        foreach($this->array as $event) {
            $output .= $event->toStringRaw();
            $output .= ", ";
        }
        $output .= "]";
        return $output;
    }
}

?>
