<?php

class Mysql_Driver extends Database_Library
{
    private $connection;
    private $query;
    private $result;

    function selectDb($dbName){
        $db= mysql_select_db($dbName);
        if (!$db) {
            die ('Can\'t use magento : ' . mysql_error());
        }

    }
    function getDbParams(){
        //$file = $_SERVER['DOCUMENT_ROOT'] . '/magento/app/etc/local.xml';
        $file= '/var/www/magento/app/etc/local.xml';
        $dbParams = json_decode(json_encode(simplexml_load_file($file, "SimpleXmlElement", LIBXML_NOCDATA)), true);
        $dbParams = array_slice($dbParams['global']['resources']['default_setup']['connection'],0, 4);

        return $dbParams;
    }
    public function connect()
    {
        $dbParams = getDbParams();
        //connection parameters
        $host = $dbParams['host'];
        $user = $dbParams['username'];
        $password = $dbParams['password'];
        $database = $dbParams['dbname'];

        //your implementation may require these...
        $port = NULL;
        $socket = NULL;

        //create new mysqli connection
        $this->connection = new mysqli
        (
            $host , $user , $password , $database , $port , $socket
        );
        //var_dump($this->connection);
        return TRUE;
    }

    public function disconnect()
    {
        //clean up connection!
        $this->connection->close();

        return TRUE;
    }


    public function prepare($query)
    {
        //store query in query variable
        $this->query = $query;

        return TRUE;
    }

    /**
     * Execute a prepared query
     */
    public function query()
    {

    }

    /**
     * Fetch a row from the query result
     *
     * @param $type
     */
    public function fetch($type = 'object')
    {

    }
    /**
     * Sanitize data to be used in a query
     *
     * @param $data
     */
    public function escape($data)
    {
        return $this->connection->real_escape_string($data);
    }
}

