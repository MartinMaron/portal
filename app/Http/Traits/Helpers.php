<?php
namespace App\Http\Traits;

trait Helpers
{
    public $params = null;
    
    public function castStringToDouble($value){
        if($value){     
            $tvalue = str_replace('.','@', $value);
            $tvalue = str_replace(',','.', $tvalue);
            $tvalue = str_replace('@','', $tvalue);
            return floatval($tvalue);
        }
        return null;
    }
    public function getParam($index, $default = null)
    {
        if (array_key_exists($index, $this->params))
        {
            return $this->params[$index];
        }else{
            return $default;
        }
    }
}
