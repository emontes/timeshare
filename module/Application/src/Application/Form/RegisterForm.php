<?php
namespace Application\Form;

use ZfcUser\Form\Register;
class RegisterForm extends Register {
    
    public function __construct($name = null,$options = null) {
        
        parent::__construct($name,$options);
        
/*         $this->add(array(
            'name'=>'lname',
            'type'=>'Zend\Form\Element',
            'options'=>array('label'=>'Lastname'),
            'attributes'=>array('required'=>'required','type'=>'text')
        )); */
        
    }
}