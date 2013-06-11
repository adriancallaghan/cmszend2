<?php

namespace Application\Traits;


trait Readonly{
    
    
    public function __construct(array $options = null)
    {     
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (method_exists($this, $method)) {
            $this->$method($value);
            return $this;
        }
                
        throw new \Exception('"'.$name.'" is an invalid property of '.__CLASS__.' assignment of "'.$value.'" failed!');
        
    }

    public function __get($name)
    {
        
        $method = 'get' . $name;
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        
        throw new \Exception('Invalid '.__CLASS__.' property '.$name);
    }
    
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }  
    

     
    public function toArray(){
        
        $methods = get_class_methods($this);
        $array = array();
        if (is_array($methods) && count($methods)>0){
            foreach ($methods as $method) {
                if (substr($method, 0, 3)=='get'){
                    $array[lcfirst(substr($method, 3))] = $this->$method();
                }
            }
        }
        return $array;
    }

    
}

?>
