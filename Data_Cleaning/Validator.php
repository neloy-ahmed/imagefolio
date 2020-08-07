<?php
class Validator{

    private $is_valid = true;

    public $errors = [];


    public function isValid(): bool
    {
        return $this->is_valid;
    }


    public function getError($fieldName)
    {
        return isset($this->errors[$fieldName]) ? $this->errors['fieldName'] : '';
    }


    public function validate(array $rules, array $payload)
    {
        foreach ($rules as $rule) {

            if (!$this->validateRequired($rule, $payload)) {
              
                continue;
            }
            switch ($rule['type']) {

                case 'valid_file_type':
                    $this->validateFileType($rule, $payload);
                    break;

            }
        }

        return $this->isValid();
    }

    public function validateRequired(array $rule, array $payload)
    {
      
    //  die(var_dump($_FILES['image'])) ;
        if (true === $rule['required'] && empty($payload[$rule['fieldName']]["name"])) {
          
            $this->is_valid = false;
            $this->errors[$rule['fieldName']] = "{$rule['fieldName']} field is required";

            return false;
        }
        elseif(false === $rule['required'] && empty($payload[$rule['fieldName']])){
          
          //If the field is optional do not check any other rule if user pass empty
          return false;
        }

        // die('heel');
        return true;
    }




    

    

    public function validateFileType($rule, $payload){
      
      $type = explode(".",$payload[$rule['fieldName']]['name']);
      $type = $type[count($type)-1];

      if(!in_array($type, array('jpeg','jpg','bmp','png'))){
        $this->is_valid = false;
        $this->errors[$rule['fieldName']] = "{$rule['fieldName']} should contain valid image type";
      }
    }

}
