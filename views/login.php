<html>
    <body style= "background-color:#deebb0" >

        <form id='register' action='' method='post'accept-charset='UTF-8'>
            <div style="text-align: center; margin: 25px 500px 0px 500px;  ">
                <fieldset style= "border: 4px solid; margin:auto; border-color:#039 ">
                    <legend>Register</legend>
                    <input type='hidden' name='submitted' id='submitted' value='1'/>
                    <label for='name' >Your Full Name*: </label>
                    <input type='text' name='name' id='name' maxlength="50" /><br><br>
                    <label for='email' >Email Address*:</label>
                    <input type='text' name='email' id='email' maxlength="50" /><br><br>

                    <label for='username' >UserName*:</label>
                    <input type='text' name='username' id='username' maxlength="50" /><br><br>

                    <label for='password' >Password*:</label>
                    <input type='password' name='password' id='password' maxlength="50" /><br><br>
                    <input type='submit' name='register' value='Submit' />

                </fieldset>

                <form id='login' action='login.php' method='post' accept-charset='UTF-8'>
                    <fieldset style= "border: 4px solid; margin:auto; border-color:#039 " >
                        <legend>Login</legend>
                        <input type='hidden' name='submitted' id='submitted' value='1'/>

                        <label for='username' >UserName*:</label>
                        <input type='text' name='username' id='username'  maxlength="50" />

                        <label for='password' >Password*:</label>
                        <input type='password' name='password' id='password' maxlength="50" /><br><br>

                        <input type='submit' name='login' value='Submit' />

                    </fieldset>
                </form>
            </div>
        </form>

    </body>
</html>
