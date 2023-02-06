<?php

class validate
{
    public $conect;
public $good=[];
    public  $errors=[];
    public function  validation($input){
         $input=trim($input);
         $input=htmlspecialchars($input);
         $input=stripcslashes($input);
         return $input;

    }
    public function __construct()
    {

        try{
           $this->conect=new PDO('mysql:host=localhost;dbname=college','root','');
        }catch (PDOException $e) {
            echo "connection failed" . $e->getMessage();
            die();
        }
    }


    public  function  check_unique($table,$column,$input,$key,$error){
              $input_result=$this->conect->query("SELECT $column FROM $table WHERE $column='$input'");
                $count_input=$input_result->rowCount();
                if($count_input >0){
                    $this->errors[$key]=$error;

                }
    }



    public  function  check_int($input,$key,$error){
        if(! filter_var($input,FILTER_VALIDATE_INT)){
            $this->errors[$key]=$error;
            return false;
        }else{
          return  true;
        }

    }

   public function pass($input,$key){
       $uppercase = preg_match('@[A-Z]@', $input);
       $lowercase = preg_match('@[a-z]@', $input);
       $number    = preg_match('@[0-9]@', $input);
       $specialChars = preg_match('@[^\w]@', $input);

       if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($input) < 8) {
         $this->errors[$key]= 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
       }else{
           $this->good['pass_accept'] ='Strong password.';
       }
   }
   //code validation
   public function valid_code($code){
       if (empty($code)) {
           $this->errors ['code_required'] = "please enter your code..";
       }else{
           if( $this->check_int($code, 'code_int', "the code must be only numbers"))
               $this->check_unique('students', 'code', $code, 'code_unique', 'this code is exist..');

       }
   }
   //password validation
   public function valid_pass($password){
       if (empty($password)) {
        $this->errors['password_required'] = "please enter your password..";
    }else{
      $this->pass($password,'pass_invalid');

    }
   }
    //email validation
   public function valid_email($email){

       if (empty($email)) {
           $this->errors['email_required'] = "please enter your email..";
       }else{
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $this->errors['emailErr'] = "Invalid email format";
           }else {
               $this->check_unique('students', 'email', $email, 'email_unique', 'this email is exist..');
           }
       }
   }
   // phone validation
   public function valid_phone($phone){
       if (empty($phone)) {
           $this->errors['phone_required'] = "please enter your phone..";
       }else{

           if (strlen($phone) != 11) {
               $this->errors['length'] = "the length must be exactly 11";
           }else{
               $this->check_unique('students', 'phone', $phone, 'phone_unique', 'this phone is exist..');
           }
       }
   }
   //name validation
   public function valid_name($name){
       if (empty($name)) {
           $this->errors['name_required'] = "please enter your name..";
       }else{
           if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
               $this->errors['letters'] = "only letters an spaces..";
           }
       }
   }

}