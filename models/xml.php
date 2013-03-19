<?php

    class Xml_Model{


        public function __construct()
        {

        }

        public function showUrl(){
            echo '<div style="text-align: center; margin: 25px 500px 0px 500px;  ">';
            foreach($_SESSION['history']as $value){
                echo $value."<br>";
            }
        }
        public function listFiles(){
            $month = $_GET['month'];
            if ($month != "none"){
                $month = "-{$month}-*.txt";
            } else
                $month = ".txt";
            foreach (glob("history/*{$month}") as $filename) {
                echo "<a href={$filename}>{$filename}</a><br/>";
            }
        }
        public function createLog(){
            if(!is_dir(getcwd().'/history')){
                mkdir(getcwd().'/history');
            }

            $filename=getcwd().'/history/'.date('Y-m-d').'.txt';
            $str=date('H:i:s')." | ".$_SERVER['REMOTE_ADDR']." | ".$_SERVER['REQUEST_URI']." | ".session_id()."\n";

            $file=fopen($filename,'a+');
            fwrite($file,$str);
            fclose($file);


        }
        public function makeCookies(){

            $expire=time()+(3600*24*30);
            $i=1;

            //setcookie("cookie$i",$_SESSION['history'][$i],$expire);

            for($i=0; $i<count($_SESSION['history']);$i++){

                setcookie("cookie$i",$_SESSION['history'][$i],$expire);
            }


        }
        public function history(){

            if(!isset($_SESSION['history'])) $_SESSION['history'] = array();
            array_unshift($_SESSION['history'],$_SERVER['REQUEST_URI']);
            if(count($_SESSION['history']) > 5) {
                unset($_SESSION['history'][5]);
            }


            return $_SESSION['history'];

        }

        public function viewProduct($id){

            $query= "SELECT *
                 FROM catalog_product_entity cpe, catalog_product_entity_varchar cpev,
                  catalog_product_website cpw, core_website cw
                 WHERE (cpev.entity_id=$id)
                 AND (cpev.attribute_id=96)";

            $info=mysql_query($query);
            $s = '';
            while($info = mysql_fetch_assoc($info)){
                $s.= ''.$info['value'];

            }
            return ($s);
        }
        public function limitTo(){
            $text_input=$_GET['limit'];

            if(is_numeric($text_input)){
                return $text_input;
            }
            else{
                return 8;
            }
        }
        public function sortBy(){
            $selected_radio = $_GET['sort'];

            if ($selected_radio == 'asc') {

                return "ASC";

            }
            else if ($selected_radio == 'desc') {

                return "DESC";
            }
        }

        public function orderBy(){

            $selected_radio = $_GET['order'];

            if ($selected_radio == 'value') {

                return "value";

            }
            else if ($selected_radio == 'product_id') {

                return "product_id";
            }

        }

        public function connect($host, $user, $pass) {
            $link = mysql_connect($host, $user, $pass);

            if (!$link) {
                die('Could not connect: ' . mysql_error());
            }
            echo '<br /><br />';
        }

        public function sql($orderBy,$list, $limit){

            $query = "SELECT *
                  FROM catalog_product_entity cpe, catalog_product_entity_varchar cpev,
                  catalog_product_website cpw, core_website cw

                  WHERE ( (cpev.entity_id=cpe.entity_id)
                  AND (cpe.entity_id=cpw.product_id)
                  AND (cpw.website_id=cw.website_id))
                  And (cpev.attribute_id=96)
                  ORDER BY {$orderBy} {$list}
                  LIMIT 0,$limit";


            return $query;

        }
        public function disconnect(){
            mysql_close();
        }
        public function selectDb($dbName){
            $db= mysql_select_db($dbName);
            if (!$db) {
                die ('Can\'t use magento : ' . mysql_error());
            }

        }
        public function getDbParams(){
            //$file = $_SERVER['DOCUMENT_ROOT'] . '/magento/app/etc/local.xml';
            $file= '/var/www/magento/app/etc/local.xml';
            $dbParams = json_decode(json_encode(simplexml_load_file($file, "SimpleXmlElement", LIBXML_NOCDATA)), true);
            $dbParams = array_slice($dbParams['global']['resources']['default_setup']['connection'],0, 4);

            return $dbParams;
        }

    }