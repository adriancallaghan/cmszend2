<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;
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
 * @property string $comments
 * @property int $id
 */
class Album implements InputFilterAwareInterface 
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
     * @ORM\Column(name="artist",type="string")
     */
    protected $artist;

    /**
     * @ORM\Column(name="title",type="string")
     */
    protected $title;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;
        
    /** 
     * @param \Doctring\Common\Collections\ArrayCollection $property
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="album", cascade={"persist", "remove"}) 
     */    
    protected $comments;
    
 /*
    public function __construct(array $options = null) {
        
        $this->setComments(new \Doctrine\Common\Collections\ArrayCollection());
        
        return parent::__construct($options);
    }*/
    
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
    
    public function setArtist($artist = 'Unknown'){
        $this->artist = $artist;
        return $this;
    }
    
    public function getArtist(){
        
        if (!isset($this->artist)){
            $this->setArtist();
        }
        return $this->artist;
    }
    
    public function setTitle($title = 'No Title'){
        $this->title = $title;
        return $this;
    }
    
    public function getTitle(){
        
        if (!isset($this->title)){
            $this->setTitle();
        }
        return $this->title;
    }
    
    
    public function setCreated(\DateTime $created = null){
        
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
        
    
    public function setComments($comments){
        $this->comments = $comments;
        return $this;
    }
    
    public function getComments(){
        
        if (!isset($this->comments)){            
            $this->setComments();
        }
        return $this->comments;
    }
     
    public function removeComment(Comment $comment) {
        
        throw new \Exception('Not implemented'); // deleted by the entity manager
        /*
         * $comment->setAlbum($this);
        $comments = $this->getComments();        
        $comments[] = $comment;
        $this->setComments($comment);
         */
        //new Collections\ArrayCollection()
        
        //$this->comments->removeElement($comment);
        
        //$comment->unsetAlbum();
    }
 
    public function addComment(Comment $comment) {
        $comment->setAlbum($this);
        $comments = $this->getComments();        
        $comments[] = $comment;
        $this->setComments($comments);
        return $this;
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