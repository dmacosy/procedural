<?php
    /**
     * This controller routes all incoming requests to the appropriate controller
     */

if(!isset($_SESSION)){
    session_start();
}
    /**
     * Automatically includes files containing classes that are called
     *
     * @param string $className
     */
    function __autoload($className)
    {
        // Parse out filename where class should be located
        // This supports names like 'Example_Model' as well as 'Example_Two_Model'
        list($suffix, $filename) = preg_split('/_/', strrev($className), 2);
        $filename = strrev($filename);
        $suffix = strrev($suffix);

        //select the folder where class should be located based on suffix
        switch (strtolower($suffix))
        {
            case 'model':

                $folder = '/models/';

                break;

            case 'library':

                $folder = '/libraries/';

                break;

            case 'driver':

                $folder = '/libraries/drivers/';

                break;
        }

        //compose file name
        $file = SERVER_ROOT . $folder . strtolower($filename) . '.php';

        //fetch file
        if (file_exists($file))
        {
            //get file
            include_once($file);
        }
        else
        {
            //file does not exist!
            die("File '$filename' containing class '$className' not found in '$folder'.");

        }
    }

    $page = 'xml';
    //compute the path to the file
    $target = SERVER_ROOT . '/controllers/' . $page . '.php';


    //get target
    if (file_exists($target)){

        include_once($target);

        //this modifies page to fit the naming convention
        $class = ucfirst($page) . '_Controller';

        //instantiate the appropriate class
        if (class_exists($class))
        {
            $controller = new $class;
        }
        else
        {
            //did we name our class correctly?
            die('class does not exist!');
        }
    }
    else
    {
        //can't find the file in 'controllers'!
        die('page does not exist!');
    }

    $controller->main();
