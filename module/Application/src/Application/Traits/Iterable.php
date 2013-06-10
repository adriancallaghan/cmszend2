<?php

namespace Application\Traits;


trait Iterable{
    
   
    protected $_position;
    protected $_data;

    
    public function rewind() {

        $this->_position = 0;
    }

    public function current() {

        if ($this->valid()){
            $data = $this->getData();
            return $data[$this->_position];
        } 
        
    }

    public function key() {

        return $this->_position;
    }

    public function next() {

        ++$this->_position;
    }

    public function valid() {

        $data = $this->getData();
        return isset($data[$this->_position]);
    }
    
    protected function setData(array $data = null){
        $this->_data = $data;
        $this->rewind();
        return $this;
    }
    
    public function getData(){
        
        if (!isset($this->_data)){
            $this->setData();
        }
        return $this->_data;
    }
    
    public function getStart(){
        
        if (isset($this->_data[0])){
            return $this->_data[0];
        }
        return null;
    }
    
    public function getEnd(){

        $count = count($this->_data)-1;
        if ($count>0){
            return $this->_data[$count];
        }
        
        return null;
    }
    
    /*
     * Required by countable
     */
    public function count(){
        return count($this->_data);
    }    
}

?>
