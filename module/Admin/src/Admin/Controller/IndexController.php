<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    
    
    public function indexAction()
    {
        

        /*
        $this->flashMessenger()->addMessage('You must do something.');           
        $this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
        $this->flashMessenger()->addMessage(array('alert-success'=>'Well done!'));           
        $this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 
        */
        
        
        
        return new ViewModel(array(
            'title'     => 'Home',
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));

    }
    
    public function loginAction(){
        
    }
    
    public function logoutAction(){
        
    }

}
