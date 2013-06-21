<?php
namespace Application\Form;

use Zend\Form\Form;




class UserForm extends Form
{
 
    
    
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('album');
        
        
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'firstname',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Firstname',
                'autocomplete'=>'off',
            ),
        ));
        $this->add(array(
            'name' => 'lastname',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Lastname',
                'autocomplete'=>'off',
            ),
        ));        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Email',
                'autocomplete'=>'off',
            ),
        ));
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Username',
                'autocomplete'=>'off',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'autocomplete'=>'off',
                
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        /*
        $this->add(array(     
            'type' => 'Zend\Form\Element\Radio',       
            'name' => 'active',
            'attributes' =>  array(             
                'options' => array(
                    '0' => 'no',
                    '1' => 'yes',
                ),
            ),
            'options' => array(
                'label' => 'Active',
            ),
        ));
        */
        $this->add(array(     
            'type' => 'Zend\Form\Element\Checkbox',       
            'name' => 'active',
            'attributes' =>  array(             
                'options' => array(
                    '1' => '1',
                ),
                'value'=>'1',
            ),
            'options' => array(
                'label' => 'Enabled',
                'autocomplete'=>'off',                
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