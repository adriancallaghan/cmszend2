<?php
namespace Admin\Form;

use Zend\Form\Form;



class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
                /*'type' => 'tel',
                'required' => 'required',
                'pattern'  => '^0[1-68]([-. ]?[0-9]{2}){4}$'*/
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Password',
            ),
            
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        ));
    }
    

}