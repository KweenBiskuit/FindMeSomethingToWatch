<?php 

 namespace Admin\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Admin\Model\Serie;         
 use Admin\Form\SerieForm; 

 class AdminController extends AbstractActionController
 {
 	protected $serieTable;

    public function indexAction()
     {
         return new ViewModel(array(
             'series' => $this->getSerieTable()->fetchAll(),
         ));
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


     public function editAction()
     {
     }

     public function deleteAction()
     {
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