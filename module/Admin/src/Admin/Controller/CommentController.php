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
use Application\Form\CommentForm;       
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Zend\Paginator\Paginator;
use Doctrine\Common\Collections;



class CommentController extends AbstractActionController
{

    
    public function indexAction()
    {       
        
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $commentDao = $em->getRepository('Application\Entity\Comment');
        
        $comments = $commentDao->findAll();

        $collection = new Collections\ArrayCollection($comments);

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
            'title'     => 'Comments',
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));

    }
    
    public function addAction()
    {

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // entity manager
        
        
        $albumId = (int) $this->params()->fromRoute('id', 0); // album that we are adding to, defaults to zero
        $albumDao = $em->getRepository('Application\Entity\Album');
        $album = $albumDao->find($albumId);

        YOU ARE HERE!!
        
        ABOUT TO ADD DETECTION FOR WHICH ALBUM you are adding a comment to (this should be a drop down)
            
        EDIT SHOULD HAVE THIS DROPDOWN TO

        NATURAL FLOW SHOULD BE TO POPULATE A NEW FORM WITH THE IDS AND NAMES OF ALBUMS
            
            ON SUBMISSION THIS ID WOULD BE USED AGAINST THE \Application\Entity\Album::
                
                CURRENTLY THE ID IS NOT BEING SUBMITTED AT ALL
            
            
        $comment = new \Application\Entity\Comment();
        $form = new CommentForm();      
        $form->setInputFilter($comment->getInputFilter())
            ->setData($this->getRequest()->getPost())
            ->get('submit')->setValue('Add');
        
        
        if ($this->getRequest()->isPost() && $form->isValid()) {                
            $comment->setOptions($form->getData()); // set the data           
            $em->persist($album); // set data
            $em->persist($comment); // set data
            $em->flush(); // save      
            // set messages 
            //$this->flashMessenger()->addMessage('You must do something.');           
            //$this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
            $this->flashMessenger()->addMessage(array('alert-success'=>'Added!'));           
            //$this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 

            // Redirect to list of comments
            return $this->redirect()->toRoute('admin/comment');
        }
        
        
        return array('form' => $form);
    }

       
    // Add content to this method:
    public function editAction()
    {
       
        
        $id = (int) $this->params()->fromRoute('id', 0); // id that we editing, defaults to zero
        $form  = new CommentForm(); // form used for the edit
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');  
        $comment = $em->getRepository('Application\Entity\Comment')->find($id);
        
        
        // if we do not have an entry for the album, i.e id not found or not defined
        // send them to add
        if (!$comment) {
            return $this->redirect()->toRoute('admin/comment', array(
                'action' => 'add'
            ));
        }

        // setup form
        // (validation, data and button)
        $form->setInputFilter($comment->getInputFilter())
                ->setData($comment->toArray())
                ->get('submit')->setAttribute('value', 'Edit');


        // process a submission
        if ($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost()); // set the form with the submitted values

            // is valid?
            if ($form->isValid()) {
                
                $comment->setOptions($form->getData()); // set the data    
                $comment->id = $id;        
                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // entity manager
                $em->persist($comment); // set data
                $em->flush(); // save
                
                // set messages 
                //$this->flashMessenger()->addMessage('You must do something.');           
                //$this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
                $this->flashMessenger()->addMessage(array('alert-success'=>'Updated!'));           
                //$this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 
                
                // Redirect to list of comments
                return $this->redirect()->toRoute('admin/comment');

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
        $comment = $em->getRepository('Application\Entity\Comment')->find($id);
        
        
        // if we do not have an entry for the album, i.e id not found or not defined
        // send them back to the main screen
        if (!$comment) {
            return $this->redirect()->toRoute('admin/comment');
        }
        

        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('del', 'No') == 'Yes') {
  
            $em->remove($comment); // boom biddy bye bye
            $em->flush();
                 
            $this->flashMessenger()->addMessage(array('alert-info'=>'Deleted'));

            // Redirect to list of albums
            return $this->redirect()->toRoute('admin/comment');
        }

        return array(
            'id'    => $id,
            'comment' => $comment
        );
    }
        
    
}
