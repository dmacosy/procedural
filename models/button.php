<?php

class Button_Model
{

    /**
     * This function includes the logic for the user submission of the login/registration page
     */

    public function initDisplay(){

        $buttons = new Admin_Model();


        if(isset($_POST['register'])){
            $check=$buttons->checkRegIn();
            if($check==true){
                $fname=$_POST['fname'];
                unset($_POST['registered']);
                echo "$fname, Thank You for registering!!";
            }
        }
        else if(isset($_POST['login'])){
            $check=$buttons->checkLogin();
            if($check==true){
                $back = $_SERVER['HTTP_REFERER'];
                header("Location: $back");
            }

        }
    }

    /**
     * This function is the logic behind the user input buttons and text field on the main page.
     */
    public function display(){
        $xmlModel = new Xml_Model;
        if(isset($_GET["url"])){

            echo '<table cellpadding="3" cellspacing="5" style="margin:auto">
                  <tr>
                  <th style="font-size: 14px; font-weight: normal;  padding: 10px 8px; border-bottom: 4px solid #039;" scope="col">Display Type</th>
                  <th style="font-size: 14px; font-weight: normal;  padding: 10px 8px; border-bottom: 4px solid #039;" scope="col">URL</th>
                  </tr>';

            $xmlModel->showUrl();


        }
        else if(isset($_GET["logFiles"])){

            $xmlModel->listFiles();
        }
        else if(isset($_GET['product_id']) && is_numeric($_GET['product_id'])){

            $xmlModel->createLog();
            $xmlModel->addToTable();

            echo "<h1>".$xmlModel->viewProduct($_GET['product_id'])."</h1>";

        }
        else if(isset($_GET['logout'])){
            unset($_SESSION['loggedIn']);
            header("Location: http://procedural.dev/index.php?");
        }
        else if (isset($_GET['Submit'])) {

            if(!(isset($_GET['order']) && isset($_GET['sort']))){

                Error_Model::getInstance()->setError(Error_Model::ERROR_300);
                die(Error_Model::getInstance()->getError());


            }
            else{
                $xmlModel->createLog();
                $xmlModel->addToTable();
                $_SESSION['order']=$xmlModel->orderBy();
                $_SESSION['sort']=$xmlModel->sortBy();
                $_SESSION['limit']=$xmlModel->limitTo();


                $s=mysqli_query($xmlModel->getLink(), $xmlModel->sql($_SESSION['order'], $_SESSION['sort'],$_SESSION['limit']));


                echo '<table cellpadding="3" cellspacing="5" style="margin:auto">
                      <tr>
                      <th style="font-size: 14px; font-weight: normal;  padding: 10px 8px; border-bottom: 4px solid #039;" scope="col">Product #</th>
                      <th style="font-size: 14px; font-weight: normal;  padding: 10px 8px; border-bottom: 4px solid #039;" scope="col">Website</th>
                      <th style="font-size: 14px; font-weight: normal;  padding: 10px 8px; border-bottom: 4px solid #039;" scope="col">Product Name</th><th>
                      </tr>';

                while($info = mysqli_fetch_assoc($s)){
                    echo '<tr>
                          <td style="border-bottom: 2px solid #ccc; color: #669; padding: 6px 8px;">'.$info['product_id'].'</td>
                          <td>'. $info['name']. '</td>
                          <td>'.'<a href="http://procedural.dev/index.php?product_id='.$info['product_id'].'">'.$info['value'].'</a></td>
                          </tr>';
                }
                echo '</table><br />';


            }
        }
    }
}
