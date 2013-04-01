<?php


class Admin_Model extends Database_Model {

    /**
     * This function takes user registration input and add it to the data base if every thing checks out
     *
     * @return bool
     */
    public function checkRegIn(){

        if(empty($_POST['fname'])){
            Error_Model::getInstance()->setError(Error_Model::ERROR_100);
        }
        else{
            $firstname=$_POST['fname'];
        }
        if(empty($_POST['lname'])){
            Error_Model::getInstance()->setError(Error_Model::ERROR_101);
        }
        else{

            $lastname=$_POST['lname'];
        }
        if(empty($_POST['email'])|| !preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/',$_POST['email'])){

            Error_Model::getInstance()->setError(Error_Model::ERROR_102);
        }
        else{
            $email=$_POST['email'];
        }
        if(empty($_POST['regPassword'])){
            Error_Model::getInstance()->setError(Error_Model::ERROR_103);
        }
        else{
            $password=$_POST['regPassword'];
            $pwdmd5 = md5($password);
        }

       Error_Model::getInstance()->getError();

        if(isset($firstname) && isset($lastname) && isset($email) && isset($pwdmd5)){

            if($this->checkEmail($email)==true){
                $data=array($firstname,$lastname,$email, $pwdmd5);
                $query="INSERT INTO admin_log_users (firstname, lastname, email,password)
                        VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]')";

                mysqli_query(self::$link, $query);
                return true;
            }
            else{
                Error_Model::getInstance()->setError(Error_Model::ERROR_104);
                die(Error_Model::getInstance()->getError());

            }
        }
        else{
            return false;
        }

    }

    /**
     * Function takes the user inputed email as a parameter to check it against the database
     * @param $email
     * @return bool
     */
    public function checkEmail($email){

        $query= "SELECT email FROM admin_log_users
                 WHERE email= '{$email}'";

        $result=mysqli_query(self::$link, $query);

        $new = mysqli_fetch_assoc($result);

        if(!isset($new['email'])){
            return true;
        }
        else{
            return false;
        }

    }

    /**
     * This function first make sure that the fields are not empty then checks the
     * username and password provided against the database
     *
     * @return bool
     */
    public function checkLogin(){

        if(empty($_POST['username'])){

            Error_Model::getInstance()->setError(Error_Model::ERROR_200);
        }
        else{
            $username=$_POST['username'];
        }
        if(empty($_POST['password'])){

            Error_Model::getInstance()->setError(Error_Model::ERROR_201);
        }
        else{

            $password=md5($_POST['password']);

        }

        if(isset($username) && isset($password) ){
            $data=array($username, $password);
            $query = "SELECT firstname FROM admin_log_users
                     WHERE email= '$data[0]' AND password='$data[1]'  ";

            $result=mysqli_query(self::$link, $query);
            $new = mysqli_fetch_assoc($result);

            if(isset($new['firstname'])){

                $_SESSION['loggedIn']=$new['firstname'];
                return true;
            }
            else{
                Error_Model::getInstance()->setError(Error_Model::ERROR_202);
                die(Error_Model::getInstance()->getError());
            }
        }
        Error_Model::getInstance()->getError();
    }
}