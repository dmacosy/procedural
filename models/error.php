<?php

class Error_Model{

    protected $_error=array();

    /**
     * Registration Errors 100s
     */
    const ERROR_100 = "Error: First Name is required";
    const ERROR_101 = "Error: Last Name is required";
    const ERROR_102 = "Error: A proper email address is required";
    const ERROR_103 = "Error: Password is required";
    const ERROR_104 = "Error: The email address provided is already in use. Please provide a new email email address.";


    /**
     * Login Errors 200s
     */
    const ERROR_200 = "Error: Username is required";
    const ERROR_201 = "Error: Password required";
    const ERROR_202 = "Error: Invalid username or password. Please try again.";

    /**
     * Main Page Error 300s
     */
    const ERROR_300 = "Error: Both a sorting object and an ordering method is required. ";
    const ERROR_301 = "Error: No month was chosen.";
    const ERROR_302 = "There are no log files for the selected month. ";

    /**
     * @return Error_Model
     */
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Error_Model();
        }
        return $inst;
    }



    public function setError($error){
        $this->_error[]=$error;
    }

    public function getError(){

        foreach($this->_error as $i){
            echo $i.'<br>';

        }

        //return $this->_error;


    }







}

