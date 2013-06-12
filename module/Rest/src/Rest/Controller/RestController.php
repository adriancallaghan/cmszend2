<?php
namespace Rest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;


use Application\Form\AlbumForm;
use Zend\View\Model\JsonModel;


class RestController extends AbstractRestfulController
{
    
    
    public function getList()
    {

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $albumRepo = $em->getRepository('\Application\Entity\Album');
        $albums = $albumRepo->findAll();
        $notLazy = array();

        if (count($albums)>0){
            foreach($albums AS $album){
                $notLazy[] = $album->toArray();
            }
        }
        
        return new JsonModel(array(
            'data' => $notLazy,
        ));

    }

    public function get($id)
    {
        
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');        

        $album = $em->getRepository('Application\Entity\Album')->findOneBy(array('id'=>$id));

        return new JsonModel(array(
            'data' => !is_null($album) ? $album->toArray() : null,
        ));
        
    }

    public function create($data)
    {

        $form = new AlbumForm();
        $album = new \Application\Entity\Album();
                
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        
        if ($form->isValid()) {            
            $album->setOptions($form->getData()); // set the data            
            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // entity manager
            $em->persist($album); // set data
            $em->flush(); // save
        }         
        
        return new JsonModel(array(
            'data' => $album->toArray(),
        ));
        
    }

    public function update($id, $data)
    {
               
        // identical to create, the only change is the id is manually added after 
        // getting the form data, this is becuase the form does not have the id
        $form = new AlbumForm();
        
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $album = $em->getRepository('Application\Entity\Album')->find($id);
        
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        
        // album was found, add the form data, and reinstate the id
        if ($album && $form->isValid()) {  

            $album->setOptions($form->getData()); // set the data    
            $album->id = $id;        
            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // entity manager
            $em->persist($album); // set data
            $em->flush(); // save
                     
        }
        
        return new JsonModel(array(
            'data' => $album->toArray(),
        ));
        
        
    }

    public function delete($id)
    {
         
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $album = $em->getRepository('Application\Entity\Album')->find($id);
        $em->remove($album);
        $em->flush();
        
        return new JsonModel(array(
            'data' => $id,
        ));
        
    }
    
    
}