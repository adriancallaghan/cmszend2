<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 

/**
 * A music album.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks 
 * @ORM\Table(name="album")
 * @property string $artist
 * @property string $title
 * @property int $id
 */
class User //implements InputFilterAwareInterface 
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
     * @ORM\Column(name="artist",type="string")
     */
    protected $_artist;

    /**
     * @ORM\Column(name="title",type="string")
     */
    protected $_title;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    protected $_created;
        
    
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
    
    public function setArtist($artist = 'Unknown'){
        $this->_artist = $artist;
        return $this;
    }
    
    public function getArtist(){
        
        if (!isset($this->_artist)){
            $this->setArtist();
        }
        return $this->_artist;
    }
    
    public function setTitle($title = 'No Title'){
        $this->_title = $title;
        return $this;
    }
    
    public function getTitle(){
        
        if (!isset($this->_title)){
            $this->setTitle();
        }
        return $this->_title;
    }
    
    
    public function setCreated($created = null){
        
        if ($created==null){
            $created = new \DateTime("now");
        }
        $this->_created = $created;
        return $this;
    }
    
    public function getCreated(){
                
        if (!isset($this->_created)){
            $this->setCreated();
        }
        return $this->_created->format('Y-m-d H:i');
    }
        
    
    
    /** 
    *  @ORM\PrePersist 
    */
    public function prePersist()
    {
        $this->getCreated(); // makes sure we have a default time set
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