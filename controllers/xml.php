<?php
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
session_start();

/**
 * This class handles the retrieval of the logic and view of this simple XML exercise
 */
class Xml_Controller
{
    /**
     * HTML view template
     *
     * @var string
     */

        public $template = 'xml';


    /**
     * Main controller function to connect the model and view classes
     * Retrieved parameters and connect to the database
     * Render view and create log file for today
     */
    public function main(){
//        if(!isset($_POST['login'])){
//
//            $this->template = 'login';
//
//        }
//        else{
//            $this->template = 'xml';
//        }

        $xmlModel = new Xml_Model;
        $view = new View_Model($this->template);

        $dbParams =  $xmlModel->getDbParams();
        $xmlModel->connect($dbParams['host'], $dbParams['username'], $dbParams['password'], $dbParams['dbname']);
        $view->renderView();

        $xmlModel->createLog();
        $xmlModel->addToTable();
        $xmlModel->history();
        $xmlModel->makeCookies();

    }

}