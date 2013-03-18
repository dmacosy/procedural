<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <body>
        <form method ="get" action="" >
            <div style="text-align: center; margin: 25px 500px 0px 500px;  ">
            <fieldset style= "border: 4px solid; margin:"auto>
                <legend>Display Database</legend><br><br>
                     <label>
                        <input type = 'radio' Name ='order' value= 'value' >Value
                    </label>
                    <label>
                        <input type = 'radio' Name ='order' value= 'product_id' >Product ID<br><br>
                    </label>
                    <label>
                        <input type = 'radio' Name ='sort' value= 'asc' >Ascending
                    </label>
                    <label>
                        <input type = 'radio' Name ='sort' value= 'desc' >Descending<br><br>
                    </label>
                    <label>
                        Limit:<input type='text' Name= 'limit' value='limit'><br>If no limit is set default is 20.<br><br>
                    </label>
                    <input type = "Submit" Name = "Submit" VALUE = "Submit" /><br><br>
            </fieldset><br>
                <fieldset style= "border: 4px solid; margin:"auto>
                    <legend>Display Logs</legend><br><br>
                    <label>
                        <select name='month'>
                            <option value="none">---------</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </label>
                <input type = "Submit" Name = "show" VALUE = "Display Log Files " /><br><br>
                <input type = "Submit" Name = "url" VALUE = "Display URL History" /><br><br>
                </fieldset>

            </div>

        </form>
    </body>
</html>
<pre>
    <?php
//    error_reporting(E_ALL | E_STRICT);
//    ini_set('display_errors', 1);

        $dbParams = getDbParams();

        connect($dbParams['host'], $dbParams['username'], $dbParams['password']);


        selectDb($dbParams['dbname']);

        session_start();
        createLog();
         if(isset($_GET["url"])){
             echo '<div style="text-align: center; margin: 25px ;  ">';
             showUrl();
         }
        else if(isset($_GET["show"])){
           echo '<div style="text-align: center; margin: 25px 500px 0px 500px;  ">';
           listFiles();
        }
        else if(isset($_GET['product_id']) && is_numeric($_GET['product_id'])){

            createLog();
            echo '<div style="text-align: center; margin: 25px 500px 0px 500px;  ">';
            echo "<h1>".viewProduct($_GET['product_id'])."</h1>";
            history();
            makeCookies();





        }
        else if (isset($_GET['Submit']) && $_GET['sort'] && $_GET['order']) {
            createLog();
            $_SESSION['order']=orderBy();
            $_SESSION['sort']=sortBy();
            $_SESSION['limit']=limitTo();


            $s=mysql_query(sql($_SESSION['order'], $_SESSION['sort'],$_SESSION['limit']));

            echo '<div style="text-align: center; margin: 25px 500px 0px 650px;  ">';
            echo '<table cellpadding="5" cellspacing="5" style="margin:auto">';
            echo '<tr>
                    <th style="font-size: 14px; font-weight: normal; color: #039; padding: 10px 8px; border-bottom: 4px solid #6678b1;" scope="col">Product #</th>
                    <th style="font-size: 14px; font-weight: normal; color: #039; padding: 10px 8px; border-bottom: 4px solid #6678b1;" scope="col">Website</th>
                    <th style="font-size: 14px; font-weight: normal; color: #039; padding: 10px 8px; border-bottom: 4px solid #6678b1;" scope="col">Product Name</th><th>
                  </tr>';

            while($info = mysql_fetch_assoc($s)){
                echo '<tr>';
                echo '<td style="border-bottom: 2px solid #ccc; color: #669; padding: 6px 8px;">'.$info['product_id'].
                     '</td><td>'. $info['name']. '</td><td>'.'<a href="http://procedural.dev/simpleXML.php?product_id='.$info['product_id'].'">'.$info['value'].'</a></td>';
                echo '</tr>';
            }
            echo '</table><br />';
            echo '</div>';
            history();
            //die(var_dump($_SESSION['History']));
            makeCookies();

        }
        disconnect();


//**********************************************************************************************************************
//**********************************************************************************************************************
//**********************************************************************************************************************
    function showUrl(){
        echo '<div style="text-align: center; margin: 25px 500px 0px 500px;  ">';
        foreach($_SESSION['history']as $value){
          echo $value."<br>";
        }
    }
    function listFiles(){
        $month = $_GET['month'];
        if ($month != "none"){
            $month = "-{$month}-*.txt";
        } else
            $month = ".txt";
        foreach (glob("history/*{$month}") as $filename) {
            echo "<a href={$filename}>{$filename}</a><br/>";
        }
    }
    function createLog(){
        if(!is_dir(getcwd().'/history')){
            mkdir(getcwd().'/history');
        }

        $filename=getcwd().'/history/'.date('Y-m-d').'.txt';
        $str=date('H:i:s')." | ".$_SERVER['REMOTE_ADDR']." | ".$_SERVER['REQUEST_URI']." | ".session_id()."\n";

        $file=fopen($filename,'a+');
        fwrite($file,$str);
        fclose($file);


    }
    function makeCookies(){

        $expire=time()+(3600*24*30);
        $i=1;

        //setcookie("cookie$i",$_SESSION['history'][$i],$expire);

        for($i=0; $i<count($_SESSION['history']);$i++){

            setcookie("cookie$i",$_SESSION['history'][$i],$expire);
        }


    }
    function history(){

        if(!isset($_SESSION['history'])) $_SESSION['history'] = array();
        array_unshift($_SESSION['history'],$_SERVER['REQUEST_URI']);
        if(count($_SESSION['history']) > 5) {
            unset($_SESSION['history'][5]);
        }


        return $_SESSION['history'];

    }

    function viewProduct($id){

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
    function limitTo(){
        $text_input=$_GET['limit'];

        if(is_numeric($text_input)){
            return $text_input;
        }
        else{
            return 20;
        }
    }
    function sortBy(){
        $selected_radio = $_GET['sort'];

        if ($selected_radio == 'asc') {

            return "ASC";

        }
        else if ($selected_radio == 'desc') {

            return "DESC";
        }
    }

    function orderBy(){

        $selected_radio = $_GET['order'];

        if ($selected_radio == 'value') {

            return "value";

        }
        else if ($selected_radio == 'product_id') {

            return "product_id";
        }

    }

    function connect($host, $user, $pass) {
        $link = mysql_connect($host, $user, $pass);

        if (!$link) {
            die('Could not connect: ' . mysql_error());
        }
        echo '<br /><br />';
    }

    function sql($orderBy,$list, $limit){

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
    function disconnect(){
        mysql_close();
    }
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