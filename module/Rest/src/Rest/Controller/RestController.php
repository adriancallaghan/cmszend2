<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;


use Application\Model\Album;
use Application\Form\AlbumForm;
use Application\Model\AlbumTable;
use Zend\View\Model\JsonModel;


class RestController extends AbstractRestfulController
{
    
    protected $albumTable;
    
    
    public function getList()
    {

        $results = $this->getAlbumTable()->fetchAll();
        $data = array();
        
        foreach($results as $result) {
            $data[] = $result;
        }

        
        return new JsonModel(array(
            'data' => $data,
        ));

    }

    public function get($id)
    {

        $album = $this->getAlbumTable()->getAlbum($id);
 
        return new JsonModel(array(
            'data' => $album,
        ));
        
    }

    public function create($data)
    {

        $id = 0;
        $form = new AlbumForm();
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        
        if ($form->isValid()) {
            $album->exchangeArray($form->getData());
            $id = $this->getAlbumTable()->saveAlbum($album);
        }         
        
        return new JsonModel(array(
            'data' => $this->getAlbumTable()->getAlbum($id),
        ));
        
    }

    public function update($id, $data)
    {

        $data['id'] = $id;
        $album = $this->getAlbumTable()->getAlbum($id);
        
        $form = new AlbumForm();
        $form->bind($album);
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getAlbumTable()->saveAlbum($form->getData());
        }

        return new JsonModel(array(
            'data' => $this->getAlbumTable()->getAlbum($id),
        ));
        
        
    }

    public function delete($id)
    {
        
        $this->getAlbumTable()->deleteAlbum($id);
 
        return new JsonModel(array(
            'data' => 'deleted',
        ));
        
    }
    
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Application\Model\AlbumTable');
        }
        return $this->albumTable;
    }
    
}