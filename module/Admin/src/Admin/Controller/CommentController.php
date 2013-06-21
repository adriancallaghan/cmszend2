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

        $albumDao = $em->getRepository('Application\Entity\Album');       

        /*
         * so far findAll() seems somewhat limited, it returns just an array with no relationship to the primary keys
         * Index By can used by this does not work with findAll and appears to require crafting a full query - which seems
         * a bit backward!
         * 
         * initial flow was to cast findAll to an array collection to allow mapping, then looping through returning the property I wanted
         * and mantaining the keys - however the keys are just an array and have little to do with the data - so no go :(
         * 
         * $albums = new Collections\ArrayCollection($albumDao->findAll()); 
         * 
         *  $form->get('album_id')->setAttributes(
            array(
                'options'=>$albums->map(function($v){
                    return "{$v->title} ({$v->artist})";            
                    })->toArray()
                )
        );
         * 
         * Brute forced until I learn more..... 
         */
        $albumTitles = array();
        foreach ($albumDao->findAll() AS $v){
            $albumTitles[$v->id] = "{$v->title} ({$v->artist})";
        }

        $comment = new \Application\Entity\Comment();
        $form = new CommentForm();      
        $form->get('album_id')
                ->setValue((int) $this->params()->fromRoute('id', 0)) // defaults to the route
                ->setAttributes(array('options'=>$albumTitles));
        $form->setInputFilter($comment->getInputFilter())
            ->setData($this->getRequest()->getPost())
            ->get('submit')->setValue('Add');

        
        if ($this->getRequest()->isPost() && $form->isValid()) {  
            
            
            $albumId = (int) $form->get('album_id')->getValue();
            $album = $albumDao->find($albumId);                        
            $comment->setOptions($form->getData()); // set the data     
            
            if ($album){
                $em->persist($album); // set data
                $em->persist($comment); // set data
                $album->addComment($comment);
                $em->flush(); // save            
                $this->flashMessenger()->addMessage(array('alert-success'=>'Comment added!'));  
            }
            else {
                $this->flashMessenger()->addMessage(array('alert-error'=>'Error! Album not found!')); 
            }

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
        $albumDao = $em->getRepository('Application\Entity\Album');  
        $comment = $em->getRepository('Application\Entity\Comment')->find($id);
        
        
        // if we do not have an entry for the comment, i.e id not found or not defined
        // send them to add
        if (!$comment) {
            return $this->redirect()->toRoute('admin/comment', array(
                'action' => 'add'
            ));
        }

        // retarded but robust way to do this
        $albumTitles = array();
        foreach ($albumDao->findAll() AS $v){
            $albumTitles[$v->id] = "{$v->title} ({$v->artist})";
        }
        
        
        // setup form
        // (validation, data and button)        
        $form->setInputFilter($comment->getInputFilter())
                ->setData($comment->toArray())
                ->get('submit')->setAttribute('value', 'Edit');

        $form->get('album_id')
                ->setValue((int) !isset($comment->album) ? null : $comment->album->id)
                ->setAttributes(array('options'=>$albumTitles));
        
        // process a submission
        if ($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost()); // set the form with the submitted values

            // is valid?
            if ($form->isValid()) {
                
                $albumId = (int) $form->get('album_id')->getValue();
                
                
                $comment->setOptions($form->getData()); // set the data    
                $comment->id = $id;        
                
                $album = $albumDao->find($albumId);                        
                $comment->setOptions($form->getData()); // set the data     
            
                if ($album){
                    $em->persist($album); // set data
                    $em->persist($comment); // set data
                    $album->addComment($comment);
                    $em->flush(); // save            
                    $this->flashMessenger()->addMessage(array('alert-success'=>'Comment Updated!'));  
                }
                else {
                    $this->flashMessenger()->addMessage(array('alert-error'=>'Error! Album not found!')); 
                }
                
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
