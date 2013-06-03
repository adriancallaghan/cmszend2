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
use Application\Model\Album;          
use Application\Form\AlbumForm;       
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class AdminController extends AbstractActionController
{
    
    protected $albumTable;
    
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Application\Model\AlbumTable');
        }
        return $this->albumTable;
    }
    
    
    public function indexAction()
    {
        

        // grab the paginator from the AlbumTable
        $paginator = $this->getAlbumTable()->fetchAll(true);
        
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1))
                ->setItemCountPerPage(2);


        /*
        $this->flashMessenger()->addMessage('You must do something.');           
        $this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
        $this->flashMessenger()->addMessage(array('alert-success'=>'Well done!'));           
        $this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 
        */
        
        
        return new ViewModel(array(
            'paginator' => $paginator,
            'title'     => 'Admin',
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));

    }
    
    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');


        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $album->exchangeArray($form->getData());
                $this->getAlbumTable()->saveAlbum($album);

                // set messages 
                //$this->flashMessenger()->addMessage('You must do something.');           
                //$this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
                $this->flashMessenger()->addMessage(array('alert-success'=>'Added!'));           
                //$this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('admin');
            } else {
                //$this->flashMessenger()->addMessage(array('alert-error'=>'Form error'));
            }
        }
        return array('form' => $form);
    }

       
    // Add content to this method:
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('object', array(
                'action' => 'add'
            ));
        }
        $album = $this->getAlbumTable()->getAlbum($id);

        $form  = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAlbumTable()->saveAlbum($form->getData());
                
                // set messages 
                //$this->flashMessenger()->addMessage('You must do something.');           
                //$this->flashMessenger()->addMessage(array('alert-info'=>'Soon this changes.'));           
                $this->flashMessenger()->addMessage(array('alert-success'=>'Updated!'));           
                //$this->flashMessenger()->addMessage(array('alert-error'=>'Sorry, Error.')); 
                
                // Redirect to list of albums
                return $this->redirect()->toRoute('admin');
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
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAlbumTable()->deleteAlbum($id);
                $this->flashMessenger()->addMessage(array('alert-info'=>'Deleted'));
            } 
            
            // Redirect to list of albums
            return $this->redirect()->toRoute('admin');
        }

        return array(
            'id'    => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        );
    }
    
}
