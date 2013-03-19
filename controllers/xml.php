<?php
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
session_start();


class Xml_Controller
{

    public $template = 'xml';

    public function main(){

        $xmlModel = new Xml_Model;
        $view = new View_Model($this->template);

        $dbParams =  $xmlModel->getDbParams();
        $xmlModel->connect($dbParams['host'], $dbParams['username'], $dbParams['password']);
        $xmlModel->selectDb($dbParams['dbname']);


        $xmlModel->createLog();
    }

}




