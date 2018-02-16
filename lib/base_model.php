<?php

  class BaseModel{
    protected $validators;

    public function __construct($attributes = null){
      foreach($attributes as $attribute => $value){
        if(property_exists($this, $attribute)){
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      $errors = array();
      foreach($this->validators as $validator){
        $errors = array_merge($errors, $this->{$validator}());
      }
      return $errors;
    }
    
    public function validoi_string($string) {
        $errors = array();
        if ($string == '' || $string == NULL) {
            $errors[] = 'Nimen tulee olla epätyhjä';
        }
        return $errors;
    }
    
    public function validoi_boolean($string) {
        $errors = array();
        if (!($string == 'valmis' || $string == 'kesken')) {
            $errors[] = 'Suorituksen tulee olla "kesken" tai "valmis"';
        }
        return $errors;
    }
    
    public function validoi_integer($integer) {
        $errors = array();
        if (($integer < 1 || $integer > 5)) {
            $errors[] = 'Tärkeysasteen tulee olla väliltä 1...5';
        }
        if ($integer == '' || $integer == NULL) {
            $errors[] = 'Tärkeysasteen tulee olla epätyhjä';
        }
        return $errors;
    }
    
    public function validoi_password($string) {
        $errors = array();
        if ($string == '' || $string == NULL) {
            $errors[] = 'Salasanan tulee olla epätyhjä';
        }
        return $errors;
    }
  }
