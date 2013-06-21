<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface; 

/**
 * A CMS user.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks 
 * @ORM\Table(name="cmsuser")
 * @property string $username
 * @property string $password
 * @property int $id
 */
class User 
{
    
    use \Application\Traits\ReadOnly;
    
    
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="firstname",type="string")
     */
    protected $firstname;
    
    /**
     * @ORM\Column(name="lastname",type="string")
     */
    protected $lastname;
    

    /**
     * @ORM\Column(name="email",type="string")
     */
    protected $email;
    
    
    /**
     * @ORM\Column(name="username",type="string")
     */
    protected $username;

    /**
     * @ORM\Column(name="password",type="string")
     */
    protected $password;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;
        
    
    /**
     * @ORM\Column(name="active",type="boolean")
     */
    protected $active;
    
    
    
    
    public function setId($id = 0){
        $this->id = $id;
        return $this;
    }
    
    public function getId(){
        
        if (!isset($this->id)){
            $this->setId();
        }
        return $this->id;
    }
    
    public function setFirstname($firstname = 'Unknown'){
        $this->firstname = $firstname;
        return $this;
    }
    
    public function getFirstname(){
        
        if (!isset($this->firstname)){
            $this->setFirstname();
        }
        return $this->firstname;
    }
    
    public function setLastname($lastname = 'Unknown'){
        $this->lastname = $lastname;
        return $this;
    }
    
    public function getLastname(){
        
        if (!isset($this->lastname)){
            $this->setLastname();
        }
        return $this->lastname;
    }
    
    public function setEmail($email = 'Unknown'){
        $this->email = $email;
        return $this;
    }
    
    public function getEmail(){
        
        if (!isset($this->email)){
            $this->setEmail();
        }
        return $this->email;
    }
    
    public function setUsername($username = 'Unknown'){
        $this->username = $username;
        return $this;
    }
    
    public function getUsername(){
        
        if (!isset($this->username)){
            $this->setUsername();
        }
        return $this->username;
    }
    
    public function setPassword($password = ''){
        $this->password = $password;
        return $this;
    }
    
    public function getPassword(){
        
        if (!isset($this->password)){
            $this->setPassword();
        }
        return $this->password;
    }
    
    
    public function setCreated($created = null){
        
        if ($created==null){
            $created = new \DateTime("now");
        }
        $this->created = $created;
        return $this;
    }
    
    public function getCreated(){
                
        if (!isset($this->created)){
            $this->setCreated();
        }
        return $this->created->format('Y-m-d H:i');
    }

    public function setActive($active = 'Unknown'){
        $this->active = $active;
        return $this;
    }
    
    public function getActive(){
        
        if (!isset($this->active)){
            $this->setActive();
        }
        return $this->active;
    }
    
    /** 
    *  @ORM\PrePersist 
    */
    public function prePersist()
    {
        $this->getCreated(); // makes sure we have a default time set
    }
    
    
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
                'name'     => 'username',
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
                'name'     => 'password',
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
        
        $this->inputFilter = $inputFilter;
        
        return $this;
    }

    public function getInputFilter()
    {
        
        if (!isset($this->inputFilter)) {
            $this->setInputFilter();        
        }
        
        return $this->inputFilter;
    } 
    
    

}