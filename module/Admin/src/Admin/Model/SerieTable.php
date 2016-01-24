<?php 

namespace Admin\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Where;

 class SerieTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getSerie($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function getSerieTitre($titre)
     {
         $titre  = (string) $titre;

         $where = new Where();    
         $where->like("titre", "%".$titre."%");

         $rowset = $this->tableGateway->select($where);

         $row = $rowset->current();
         if ($row) {
             return $row;
         }
         else{
          throw new \Exception("Could not find serie $titre");
         }
     }

     public function saveSerie(Serie $serie)
     {
         $data = array(
             'titre' => $serie->titre,
             'synopsys' => $serie->synopsys,
             'anneeDebut' => $serie->anneeDebut,
             'anneeFin' => $serie->anneeFin,
             'image'  => $serie->image,
         );

         $id = (int) $serie->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getSerie($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Serie id does not exist');
             }
         }
     }

     public function deleteSerie($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }