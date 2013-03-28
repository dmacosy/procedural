<?php

/**
 *Xml_Model includes all of the backend logic of this Simple XML exercise
 *
 */

class Xml_Model extends Database_Model
{



    public function __construct()
    {

    }


    /**
     * Function to display all the url in the history array
     */
    public function showUrl(){
        echo '<div style="text-align: center; margin: 25px 500px 0px 500px;  ">';

        if(isset($_SESSION['history'])){
            foreach($_SESSION['history']as $value){
                echo '<tr style="border-bottom: 2px solid #ccc; color: #669; padding: 6px 8px;">';
                echo '<td>Session</td>';
                echo '<td>'.$value.'</td>';
                echo '</tr>';
            }
            if(sizeof($_SESSION['history'])!=5){
                for($i=sizeof($_SESSION['history']); $i<5;$i++){
                    echo '<tr style="border-bottom: 2px solid #ccc; color: #669; padding: 6px 8px;">';
                    echo '<td>Cookie#'.$i.'</td>';
                    echo '<td>'.$_COOKIE["cookie$i"].'</td>';
                    echo '</tr>';
                }
            }
        }
        else{
            for($i=0; $i<5;$i++){
                echo '<tr style="border-bottom: 2px solid #ccc; color: #669; padding: 6px 8px;">';
                echo '<td>Cookie#'.$i.'</td>';
                echo '<td>'.$_COOKIE["cookie$i"].'</td>';
                echo '</tr>';
            }

        }
    }

    /**
     * Function to display log files based on the selected month.
     */
    public function listFiles(){
        $month = $_GET['month'];

        if ($month != "none"){
            $month = "-{$month}-*.txt";

            if (count(glob("history/*{$month}"))==0){
                $date=date("F", mktime(0, 0, 0, $_GET['month']));
                echo "There are no log files for the month of $date. ";
            }

            foreach (glob("history/*{$month}") as $filename) {
                echo "<a href={$filename}>{$filename}</a><br/>";
            }
        }
        else{
            echo "No month was chosen.";
        }
    }

    /**
     * Creates a log entry text file to be stored in a history directory that is
     * created if its not already there
     */
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

    /**
     * Set a cookie with a 30 day expiration for each url stored in history
     */
    public function makeCookies(){

        $expire=time()+(3600*24*30);

        for($i=0; $i<count($_SESSION['history']);$i++){
            setcookie("cookie$i",$_SESSION['history'][$i],$expire);

        }

    }

    /**
     * Function to store the last 5 visited urls in a session array
     *
     * @return session array
     */
    public function history(){

        if(!isset($_SESSION['history'])) $_SESSION['history'] = array();
        array_unshift($_SESSION['history'],"http://procedural.dev".$_SERVER['REQUEST_URI']);
        if(count($_SESSION['history']) > 5) {
            unset($_SESSION['history'][5]);
        }
        return $_SESSION['history'];

    }

    /**
     * Accepts a product id as a parameter to be added to a MySql query in order
     * to retrieve the product name from the database.
     *
     * @param string $id
     * @return string
     */
    public function viewProduct($id){

        $query= "SELECT value
             FROM catalog_product_entity cpe, catalog_product_entity_varchar cpev,
              catalog_product_website cpw, core_website cw
             WHERE (cpev.entity_id=$id)
             AND (cpev.attribute_id=96) group by value";

        $info=mysqli_query(self::$link, $query);


        $s = '';
        while($result = mysqli_fetch_assoc($info)){

            $s .= ''.$result['value'];
        }
       return($s);
    }

    public function addToTable(){

        $data=array(date('Y:m:d'),$_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'], session_id());

        $query="INSERT INTO admin_log (date, ip_address, url,session_id)
                VALUES ('$data[0]', '$data[1]', '$data[2]', '$data[3]')";

        mysqli_query(self::$link, $query);


    }

    /**
     * Returns the limit value to be included in the Mysql query. Limit will default
     * to 8 if no value is submitted
     *
     * @return int|string
     */
    public function limitTo(){
        $text_input=$_GET['limit'];

        if(is_numeric($text_input)){
            return $text_input;
        }
        else{
            return 8;
        }
    }

    /**
     * Returns the sorting method: ascending or descending order
     *
     * @return string
     */
    public function sortBy(){
        if(isset($_GET['sort'])){
            $selected_radio = $_GET['sort'];

            if ($selected_radio == 'asc') {

                return "ASC";

            }
            else if ($selected_radio == 'desc') {

                return "DESC";
            }
        }
    }

    /**
     * Returns the method in with the database is ordered by: name or product id
     *
     * @return string
     */
    public function orderBy(){
        if(isset($_GET['order'])){
            $selected_radio = $_GET['order'];

            if ($selected_radio == 'value') {

                return "value";

            }
            else if ($selected_radio == 'product_id') {

                return "product_id";
            }
        }
    }

    /**
     * Returns the MySql query after accepting parameters to manipulate the ordering, sorting, and limits
     *
     * @param string $orderBy
     * @param string $list
     * @param string $limit
     * @return string $query
     */
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
}