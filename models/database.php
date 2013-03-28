<?php

class Database_Model{

    /**
     * MySql Resource
     *
     * @var mixed
     */
    protected static $link;

    /**
     * Database
     *
     * @var string
     */
    protected static $db;

    /**
     * @return MySql resource
     */
    public function getLink() {
        return self::$link;
    }

    /**
     * Opens a new connection to MySql
     *
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param string $db
     * @return MySql resource
     */
    public function connect($host, $user, $pass, $db) {
        if(isset(self::$link)) return self::$link;
        self::$link = mysqli_connect($host, $user, $pass, $db);

        if (!self::$link) {
            die('Could not connect: ' . mysql_error());
        }
        echo '<br /><br />';
        return self::$link;
    }

    /**
     *Close opened database connection
     */
    public function disconnect(){
        mysqli_close(self::$link);
    }

    /**
     * Retrieve the database parameters from /var/www/magento/app/etc/local.xml
     *
     * @return array
     */
    public function getDbParams(){
        $file= '/var/www/magento/app/etc/local.xml';
        $dbParams = json_decode(json_encode(simplexml_load_file($file, "SimpleXmlElement", LIBXML_NOCDATA)), true);
        $dbParams = array_slice($dbParams['global']['resources']['default_setup']['connection'],0, 4);

        return $dbParams;
    }
}