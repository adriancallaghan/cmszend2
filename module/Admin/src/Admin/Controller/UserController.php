<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
Zend\View\Model\ViewModel,
Admin\Form\LoginForm,
Application\Form\UserForm,
DoctrineModule\Paginator\Adapter\Collection as Adapter,
Zend\Paginator\Paginator,
Doctrine\Common\Collections;


class UserController extends AbstractActionController
{  
    
    
    public function homeAction()
    {
        
        /*
        $this->flashMessenger()->addMessage('You must do something.');           
        $this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
        $this->flashMessenger()->addMessage(array('alert-success'=>'Well done!'));           
        $this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 
        */
        
        $identity = $this->identity()->getId();
        var_dump($identity);
        
        
        return new ViewModel(array(
            'title'     => 'Example page',
            'content'   => 'This should be changed in the router to resolve to a controller within the Admin section',
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));

    }
    
    
    public function indexAction()
    {

        
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $albumEntity = $em->getRepository('Application\Entity\User');

        $albums = $albumEntity->findAll();

        $collection = new Collections\ArrayCollection($albums);

        // Create the paginator itself
        $paginator = new Paginator(new Adapter($collection));
        
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator
                ->setCurrentPageNumber(
                    (int)$this->params()->fromQuery('page', 1)
                )
                ->setItemCountPerPage(10);

        
        return new ViewModel(array(
            'paginator' => $paginator,
            'title'     => 'Users',
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));

    }
    
    public function addAction()
    {

        $user = new \Application\Entity\User();
        $form = new UserForm();      
        $form->setInputFilter($user->getInputFilter())
            ->setData($this->getRequest()->getPost())
            ->get('submit')->setValue('Add');
        
        
        if ($this->getRequest()->isPost() && $form->isValid()) {                
            $user->setOptions($form->getData()); // set the data            
            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // entity manager
            $em->persist($user); // set data
            $em->flush(); // save      
            // set messages 
            //$this->flashMessenger()->addMessage('You must do something.');           
            //$this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
            $this->flashMessenger()->addMessage(array('alert-success'=>'Added!'));           
            //$this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 

            // Redirect to list of users
            return $this->redirect()->toRoute('admin/user');
        }
        
        
        return array('form' => $form);
    }

       
    // Add content to this method:
    public function editAction()
    {
       
        
        $id = (int) $this->params()->fromRoute('id', 0); // id that we editing, defaults to zero
        $form  = new UserForm(); // form used for the edit
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');  
        $user = $em->getRepository('Application\Entity\User')->find($id);
        
        
        // if we do not have an entry for the user, i.e id not found or not defined
        // send them to add
        if (!$user) {
            return $this->redirect()->toRoute('admin/user', array(
                'action' => 'add'
            ));
        }

        // setup form
        // (validation, data and button)
        $form->setInputFilter($user->getInputFilter())
                ->setData($user->toArray())
                ->get('submit')->setAttribute('value', 'Edit');


        // process a submission
        if ($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost()); // set the form with the submitted values

            // is valid?
            if ($form->isValid()) {
                
                $user->setOptions($form->getData()); // set the data    
                $user->id = $id;        
                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // entity manager
                $em->persist($user); // set data
                $em->flush(); // save
                
                $this->flashMessenger()->addMessage(array('alert-success'=>'Updated!'));           

                
                // Redirect to list of users
                return $this->redirect()->toRoute('admin/user');

            } else {
                //$this->flashMessenger()->addMessage(array('alert-error'=>'Form error'));
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        
        $id = (int) $this->params()->fromRoute('id', 0); // id that we deleting, defaults to zero
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');  
        $user = $em->getRepository('Application\Entity\User')->find($id);
        
        
        // if we do not have an entry for the user, i.e id not found or not defined
        // send them back to the main screen
        if (!$user) {
            return $this->redirect()->toRoute('admin/user');
        }
        

        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('del', 'No') == 'Yes') {
  
            $em->remove($user); // boom biddy bye bye
            $em->flush();
                 
            $this->flashMessenger()->addMessage(array('alert-info'=>'Deleted'));

            // Redirect to list of users
            return $this->redirect()->toRoute('admin/user');
        }

        return array(
            'id'    => $id,
            'user' => $user
        );
    }
    
    
    public function loginAction(){

        $form = new LoginForm(); 

        if ($this->getRequest()->isPost() && $form->setData($this->getRequest()->getPost())->isValid()) {
                

            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                        
            $authService->setAdapter(
                $authService->getAdapter()
                    ->setIdentity($form->getInputFilter()->getValue('username'))
                    ->setCredential(md5($form->getInputFilter()->getValue('password')))
            );
            
                
            // check if authentication was successful
            // if authentication was successful, user information is stored automatically by adapter
            if ($authService->authenticate()->isValid()) {
                
                if ($this->identity()->getActive()==1){
                    // redirect to user index page
                    return $this->redirect()->toRoute('admin');
                }
                
                // user account is not active, so set error message and flush identity
                $form->get('username')->setMessages(array('Your account has been deactivated'));
                $authService->clearIdentity(); // clear user
                

            } else {
                $form->get('username')->setMessages(array('Invalid username & password combination'));
                $form->get('password')->setMessages(array('Invalid username & password combination'));
            }
                
             
        }
        
         
        return array('form' => $form);
        
    }
    
    public function logoutAction(){
        
        $sm = $this->getServiceLocator();
        $authService = $sm->get('Zend\Authentication\AuthenticationService');
        $authService->clearIdentity();
        
        //return $this->redirect()->toRoute('admin'); // no need the redirection is picked up by the module
        
    }

}
