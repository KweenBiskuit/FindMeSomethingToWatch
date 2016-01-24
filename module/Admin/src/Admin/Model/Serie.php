<?php

namespace Admin\Model;

 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 // class Serie implements InputFilterAwareInterface
 class Serie 
 {
     public $id;
     public $titre;
     public $synopsys;
     public $anneeDebut;
     public $anneeFin;
     public $image;
     protected $inputFilter; 

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->titre = (!empty($data['titre'])) ? $data['titre'] : null;
         $this->synopsys  = (!empty($data['synopsys'])) ? $data['synopsys'] : null;
         $this->anneeDebut  = (!empty($data['anneeDebut'])) ? $data['anneeDebut'] : null;
         $this->anneeFin  = (!empty($data['anneeFin'])) ? $data['anneeFin'] : null;
         $this->image  = (!empty($data['image'])) ? $data['image'] : null;
     }

//Gestion du Form     
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'titre',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 200,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'synopsys',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 800,
                         ),
                     ),
                 ),
             ));
                 
                $inputFilter->add(array(
                 'name'     => 'anneeDebut',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 4,
                         ),
                     ),
                 ),
            ));
                    
                $inputFilter->add(array(
                 'name'     => 'anneeFin',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 4,
                         ),
                     ),
                 ),
            ));
                    
             $inputFilter->add(array(
                 'name'     => 'image',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
                    
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }
