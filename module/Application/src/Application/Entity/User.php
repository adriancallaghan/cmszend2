<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 

/**
 * A CMS user.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks 
 * @ORM\Table(name="cms_user")
 * @property string $username
 * @property string $password
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
     * @ORM\Column(name="username",type="string")
     */
    protected $_username;

    /**
     * @ORM\Column(name="password",type="string")
     */
    protected $_password;

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
    
    public function setUsername($username = 'Unknown'){
        $this->_username = $username;
        return $this;
    }
    
    public function getUsername(){
        
        if (!isset($this->_username)){
            $this->setUsername();
        }
        return $this->_username;
    }
    
    public function setPassword($password = 'No Password'){
        $this->_password = $password;
        return $this;
    }
    
    public function getPassword(){
        
        if (!isset($this->_password)){
            $this->setPassword();
        }
        return $this->_password;
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