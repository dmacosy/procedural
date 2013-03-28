<?php
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);


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
     public $template='template';

    /**
     * Main controller function to connect the model and view classes
     * Retrieved parameters and connect to the database
     * Render view and create log file for today
     */
    public function main(){
//        require_once  'lib / Twig / Autoloader.php' ;
//        Twig_Autoloader :: register ();
//        $ Loader  = new  Twig_Loader_Filesystem ( 'views' );
//        $ Twig  = new  Twig_Environment ( $ loader , array (
//            'Cache'  => 'cache' ,
//            'Debug'  => 'true'
//        ));

        $xmlModel = new Xml_Model;
        $view = new View_Model($this->template);
        $dbParams =  $xmlModel->getDbParams();
        $xmlModel->connect($dbParams['host'], $dbParams['username'], $dbParams['password'], $dbParams['dbname']);

        if(!isset($_SESSION['loggedIn'])){
            $view->setContent(SERVER_ROOT . '/views/' . 'login' . '.phtml');
            $view->renderView();
        }
        else{
            $view->setContent(SERVER_ROOT . '/views/' . 'xml' . '.phtml');
            $view->renderView();
        }

        $xmlModel->createLog();
        $xmlModel->addToTable();
        $xmlModel->history();
        $xmlModel->makeCookies();
    }
}