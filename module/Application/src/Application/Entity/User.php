<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    
    public function setPassword($password = 'No Password'){
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

    
    /** 
    *  @ORM\PrePersist 
    */
    public function prePersist()
    {
        $this->getCreated(); // makes sure we have a default time set
    }

}