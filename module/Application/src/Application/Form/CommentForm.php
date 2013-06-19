<?php
namespace Application\Form;

use Zend\Form\Form;




class CommentForm extends Form
{


    
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('album');
        $this->setAttribute('method', 'post');
        
        $this->add(array(     
            'type' => 'Zend\Form\Element\Select',       
            'name' => 'album_id',
            'attributes' =>  array(
                'id' => 'album_id',                
                'options' => array(
                    '0' => 'Error! Cannot load Albums',
                ),
            ),
            'options' => array(
                'label' => 'Album',
            ),
        ));    

        
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'message',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Message',
            ),
        ));
        $this->add(array(
            'name' => 'author',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Author',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}