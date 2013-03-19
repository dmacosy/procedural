<?php

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