<?php 

 namespace Admin\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Admin\Model\Serie;         
 use Admin\Form\SerieForm; 
 use Admin\Form\SearchSerieForm; 

 class AdminController extends AbstractActionController
 {
 	protected $serieTable;

    public function indexAction()
     {
         return new ViewModel(array(
             'series' => $this->getSerieTable()->fetchAll(),
         ));
     }

     public function detailsAction()
     {
        $id = (int) $this->params()->fromRoute('id', 0);      
        try {
             $serie = $this->getSerieTable()->getSerie($id);
        }
        catch (\Exception $ex) {
             return $this->redirect()->toRoute('admin', array(
                 'action' => 'index'
             ));
        }

        return array(
             'serie' => $serie,
        );
     }

    public function addAction()
    {
         $form = new SerieForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $serie = new Serie();
             $form->setInputFilter($serie->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $serie->exchangeArray($form->getData());
                 $this->getSerieTable()->saveSerie($serie);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('admin');
             }
         }
         return array('form' => $form);
    }

    public function searchAction(){
        $form = new SearchSerieForm();
        $form->get('submit')->setValue('Search');

        if ($this->getRequest()->isPost()) {          

              $titre = $this->getRequest()->getPost('titre');

              echo "<p> Le titre est " . $titre;
              $serieSearch = $this->getSerieTable()->getSerieTitre($titre);
              if ($serieSearch) {
                // var_dump($serieSearch->id);
                  return $this->redirect()->toRoute('admin', array(
                    'action' => 'details',
                    'id' => $serieSearch->id
                  ));
              }
        }
        return array('form' => $form);
    }

    public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('admin', array(
                 'action' => 'add'
             ));
         }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $serie = $this->getSerieTable()->getSerie($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('admin', array(
                 'action' => 'index'
             ));
         }

         $form  = new SerieForm();
         $form->bind($serie);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($serie->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getSerieTable()->saveSerie($serie);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('admin');
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
                 $this->getSerieTable()->deleteSerie($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('admin');
         }

         return array(
             'id'    => $id,
             'serie' => $this->getSerieTable()->getSerie($id)
         );
     }

     public function getSerieTable()
     {
         if (!$this->serieTable) {
             $sm = $this->getServiceLocator();
             $this->serieTable = $sm->get('Admin\Model\SerieTable');
         }
         return $this->serieTable;
     }


 }