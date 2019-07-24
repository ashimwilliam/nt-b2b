<?php

namespace App\Traits;

use Validator;
use Illuminate\Support\MessageBag;

trait ValidationTrait
{
    //=============== return errors after validation ===================
    private $errors;

    private $skip_validations = false;

    public function set_skip_validation($val){
        $this->skip_validations=$val;
    }

    public function get_skip_validation(){
        return $this->skip_validations;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function addError($messages){
        $this->initialize_or_create_error_obj()->merge($messages);
    }

    private function initialize_or_create_error_obj(){
        if(!$this->errors){
            $this->errors = new MessageBag();
        }
        return $this->errors;
    }

    public function validateObject()
    {
        $this->errors = null;
        $v = Validator::make($this->toArray(), $this->getValidationRules());
        
        if ($v->fails())
        {
            // set errors and return false
            $this->addError($v->errors());
            return false;
        }

        // validation pass
        return true;
    }

    public function getValidationRules(){
        return array();
    }

}