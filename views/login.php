<html>
    <body style= "background-color:#deebb0" >

        <form id='register' action='' method='post'accept-charset='UTF-8'>
            <div style="text-align: center; margin: 25px 500px 0px 500px;  ">
                <fieldset style= "border: 4px solid; margin:auto; border-color:#039 ">
                    <legend>Register</legend>
                    <input type='hidden' name='registered' id='registered' value='1'/>
                    <label for='fname'>First Name*: </label>
                    <input type='text' name='fname' id='fname' value="<?php if(isset($_POST['fname'])&& isset($_POST['registered']))echo ($_POST['fname'])?$_POST['fname']:null; ?>" maxlength="50"  /><br><br>
                    <label for='lname' >Last Name*:</label>
                    <input type='text' name='lname' id='lname' value="<?php if(isset($_POST['lname'])&& isset($_POST['registered']))echo ($_POST['lname'])?$_POST['lname']:null; ?>"maxlength="50" /><br><br>

                    <label for='email' >Email Address*:</label>
                    <input type='text' name='email' id='email' value="<?php if(isset($_POST['email'])&& isset($_POST['registered']))echo ($_POST['email'])?$_POST['email']:null; ?>"maxlength="50" /><br><br>

                    <label for='password' >Password*:</label>
                    <input type='password' name='regPassword' id='regPassword' maxlength="50" /><br><br>
                    <input type='submit' name='register' value='Register' />

                </fieldset>

                <form id='login' action='login.php' method='post' accept-charset='UTF-8'>
                    <fieldset style= "border: 4px solid; margin:auto; border-color:#039 " >
                        <legend>Login</legend>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>

                        <label for='username' >Email Address*:</label>
                        <input type='text' name='username' id='username'  maxlength="50" />

                        <label for='password' >Password*:</label>
                        <input type='password' name='password' id='password' maxlength="50" /><br><br>

                        <input type='submit' name='login' value='Login' />

                    </fieldset>
                </form>
            </div>
        </form>

    </body>
</html>

<?php
    $buttons = new Admin_Model();

    if(isset($_POST['register'])){
        $check=$buttons->checkRegIn();
        if($check==true){
            $fname=$_POST['fname'];
            unset($_POST['registered']);
            echo "$fname, Thank You for registering!!";
        }
    else if(isset($_POST['login'])){
        $check=$buttons->checkLogin($_POST['$username'],$_POST['$password']);
        if($check==true){
            $name=$_POST['$username'];
            echo "Welcome $name";
        }
    }

    }
//value="<?php if(!empty($_POST['email'])) {echo ($_POST['email'])?$_POST['email']:null;}
?>