<?php
include_once 'db-connect.php';

class user
{
    private $db;
    private $db_table = "users";

    public function __construct()
    {
        $this->db = new DbConnect();
    }

    public function isLoginExist($email,$password)
    {
        $sqlQ = "SELECT * FROM " . $this->db_table . " WHERE email = '$email' And password = '$password' Limit 1 ";
        $result = mysqli_query($this->db->getDb(),$sqlQ);
        if (mysqli_num_rows($result)>0) {
            mysqli_close($this->db->getDb());
            return true;
        }

        return false;
    }

    function isValidEmail($email)
    {
        return filter_var($email,FILTER_VALIDATE_EMAIL)!==false;
    }
    public function createNewRegisterUser($username , $email,$password)
    {

        $isExisting = $this->isLoginExist($email, $password);

        if ($isExisting) {

            $json['success'] = 0;
            $json['message'] = "Error in registering. Probably the username/email already exists";
        } else {
            $isValid = $this->isValidEmail($email);
            if ($isValid) {
                $query="INSERT INTO ".$this->db_table." (username,email,password) VALUES ('$username','$email','$password')";
                $inserted = mysqli_query($this->db->getDb(),$query);
                if($inserted == 1){

                    $json['success'] = 1;
                    $json['message'] = "Successfully registered the user";

                }else{

                    $json['success'] = 0;
                    $json['message'] = "Error in registering. Probably the username/email already exists";

                }
                mysqli_close($this->db->getDb());
            }
            else{
                $json['success'] = 0;
                $json['message'] = "Error in registering. Email Address is not valid";
            }
        }
        return $json;
    }
    public function loginUsers($email, $password){

        $json = array();

        $canUserLogin = $this->isLoginExist($email, $password);

        if($canUserLogin){

            $json['success'] = 1;
            $json['message'] = "Successfully logged in";

        }else{
            $json['success'] = 0;
            $json['message'] = "Incorrect details";
        }
        return $json;
    }
}
