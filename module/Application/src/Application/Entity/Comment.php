<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 

/**
 * A Comment associated with an Album.
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks 
 * @ORM\Table(name="comments")
 * @property string $message
 * @property string $author
 * @property string $email 
 * @property string $dated
 * @property int $id
 */
class Comment //implements InputFilterAwareInterface 
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
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="comment")
     */
    protected $album;
    
    
    /**
     * @ORM\Column(name="message",type="string")
     */
    protected $message;

    /**
     * @ORM\Column(name="author",type="string")
     */
    protected $author;
    
    /**
     * @ORM\Column(name="email",type="string")
     */
    protected $email;
    
    /**
     * @ORM\Column(name="dated", type="datetime")
     */
    protected $dated;
        
    
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
    
    public function setMessage($message = ''){
        $this->message = $message;
        return $this;
    }
    
    public function getMessage(){
        
        if (!isset($this->message)){
            $this->setMessage();
        }
        return $this->message;
    }        
    
    public function setAuthor($author = 'Anonymous'){
        $this->author = $author;
        return $this;
    }
    
    public function getAuthor(){
        
        if (!isset($this->author)){
            $this->setAuthor();
        }
        return $this->author;
    }  
    
    public function setEmail($email = 'Not provided'){
        $this->email = $email;
        return $this;
    }
    
    public function getEmail(){
        
        if (!isset($this->email)){
            $this->setEmail();
        }
        return $this->email;
    }  
    
    public function setDated(\DateTime $dated = null){
        
        if ($dated==null){
            $dated = new \DateTime("now");
        }
        $this->dated = $dated;
        return $this;
    }
    
    public function getDated(){
                
        if (!isset($this->dated)){
            $this->setDated();
        }
        return $this->dated->format('Y-m-d H:i');
    }

    public function setAlbum(Album $album = null){
        $this->album = $album;
        return $this;
    }
    
    public function getAlbum(){
        
        if (!isset($this->album)){
            $this->setAlbum();
        }
        return $this->album;
    }
    
    
    
    /** 
    *  @ORM\PrePersist 
    */
    public function prePersist()
    {
        $this->getDated(); // makes sure we have a default time set
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
                'name'     => 'message',
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
                'name'     => 'author',
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
                'name'     => 'email',
                'required' => false,
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