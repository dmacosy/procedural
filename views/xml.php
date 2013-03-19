<html>
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
                Limit:<input type='text' Name= 'limit' value='limit'><br>If no limit is set default is 8.<br><br>
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
            <input type = "Submit" Name = "show" VALUE = "Display Log Files" /><br><br>
            <input type = "Submit" Name = "url" VALUE = "Display URL History" /><br><br>
        </fieldset>



    </div>

</form>
</body>
</html>

<?php
$xmlModel = new Xml_Model;
if(isset($_GET["url"])){
    echo '<div style="text-align: center; margin: 25px ;  ">';
    $xmlModel->showUrl();
}
else if(isset($_GET["show"])){
    echo '<div style="text-align: center; margin: 25px 500px 0px 500px;  ">';
    $xmlModel->listFiles();
}
else if(isset($_GET['product_id']) && is_numeric($_GET['product_id'])){

    $xmlModel->createLog();
    echo '<div style="text-align: center; margin: 25px 500px 0px 500px;  ">';
    echo "<h1>".viewProduct($_GET['product_id'])."</h1>";
    $xmlModel->history();
    $xmlModel->makeCookies();
}
else if (isset($_GET['Submit']) && $_GET['sort'] && $_GET['order']) {
    $xmlModel->createLog();
    $_SESSION['order']=$xmlModel->orderBy();
    $_SESSION['sort']=$xmlModel->sortBy();
    $_SESSION['limit']=$xmlModel->limitTo();


    $s=mysql_query($xmlModel->sql($_SESSION['order'], $_SESSION['sort'],$_SESSION['limit']));

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
    $xmlModel->history();
    //die(var_dump($_SESSION['History']));
    $xmlModel->makeCookies();

}
$xmlModel->disconnect();