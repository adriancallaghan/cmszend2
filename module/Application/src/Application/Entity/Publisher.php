<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 

/**
 * A Publisher associated with an Album.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks 
 * @ORM\Table(name="publisher")
 * @property string $name
 * @property string $established
 * @property int $id
 */
class Publisher //implements InputFilterAwareInterface 
{
    
    use \Application\Traits\ReadOnly;
    
    
    protected $_inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $_id;

    /**
     * @ORM\Column(name="name",type="string")
     */
    protected $_name;

    /**
     * @ORM\Column(name="established", type="datetime")
     */
    protected $_established;
        
    
    public function setId($id = 0){
        $this->_id = $id;
        return $this;
    }
    
    public function getId(){
        
        if (!isset($this->_id)){
            $this->setId();
        }
        return $this->_id;
    }
    
    public function setName($name = 'Unknown'){
        $this->_name = $name;
        return $this;
    }
    
    public function getName(){
        
        if (!isset($this->_name)){
            $this->setName();
        }
        return $this->_name;
    }        
    
    public function setEstablished($established = null){
        
        if ($established==null){
            $established = new \DateTime("now");
        }
        $this->_established = $established;
        return $this;
    }
    
    public function getEstablished(){
                
        if (!isset($this->_established)){
            $this->setEstablished();
        }
        return $this->_established->format('Y-m-d H:i');
    }

    /** 
    *  @ORM\PrePersist 
    */
    public function prePersist()
    {
        $this->getEstablished(); // makes sure we have a default time set
    }
    
/*
    public function setInputFilter(InputFilterInterface $inputFilter = null)
    {
        
        if ($inputFilter==null){
            
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'       => 'id',
                'required'   => true,
                'filters' => array(
                    array('name'    => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'artist',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
        }
        
        $this->_inputFilter = $inputFilter;
        
        return $this;
    }

    public function getInputFilter()
    {
        
        if (!isset($this->_inputFilter)) {
            $this->setInputFilter();        
        }
        
        return $this->_inputFilter;
    } */
}