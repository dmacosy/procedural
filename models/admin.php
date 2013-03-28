<?php

class Admin_Model extends Database_Model{

    /**
     * This function takes user registration input and add it to the data base if every thing checks out
     *
     * @return bool
     */
    public function checkRegIn(){
        echo '<div style="text-align: center; margin: 25px 500px 0px 550px;  ">';

        if(empty($_POST['fname'])){
            unset($_POST['registered']);
            echo "Error:First Name is required<br>";
        }
        else{
            $firstname=$_POST['fname'];
        }
        if(empty($_POST['lname'])){
            unset($_POST['registered']);
            echo "Error:Last Name is required<br>";
        }
        else{

            $lastname=$_POST['lname'];
        }
        if(empty($_POST['email'])){
            unset($_POST['registered']);
            echo "Error:Email is required<br>";
        }
        else{
            $email=$_POST['email'];
        }
        if(empty($_POST['regPassword'])){
            unset($_POST['registered']);
            echo "Error:Password is required<br>";
        }
        else{
            $password=$_POST['regPassword'];
            $pwdmd5 = md5($password);
        }

        if(isset($firstname) && isset($lastname) && isset($email) && isset($pwdmd5)){

            if($this->checkEmail($email)==true){
                $data=array($firstname,$lastname,$email, $pwdmd5);
                $query="INSERT INTO admin_log_users (firstname, lastname, email,password)
                        VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]')";

                mysqli_query(self::$link, $query);
                return true;
            }
            else{
                unset($_POST['registered']);
                echo "Error:The email address provided is already in use. Please provide a new email email address.<br>";
                return false;
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
        echo '<div style="text-align: center;  ">';

        if(empty($_POST['username'])){

            echo "Error:Username is required<br>";
        }
        else{
            $username=$_POST['username'];
        }
        if(empty($_POST['password'])){

            echo "Error: Password required";
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
                //echo "Welcome {$_SESSION['loggedIn']}<br><br>";
                //echo '<INPUT TYPE="button" onClick="history.go(0)" VALUE="Continue">';
                return true;
            }
            else{
                echo "Invalid username or password. Please try again.";
                return false;
            }
        }
    }
}