<html>
<body style= "background-color:#deebb0" >

    <form method ="get" action="" >
        <div style="text-align: center; margin: 25px 500px 0px 500px;  ">
            <fieldset style= "border: 4px solid; margin:auto; border-color:#039 ">
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
            <fieldset style= "border: 4px solid; margin:auto; border-color:#039">
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
                <input type = "Submit" Name = "logFiles" VALUE = "Display Log Files" /><br><br>
                <input type = "Submit" Name = "url" VALUE = "Display URL History" /><br><br>
            </fieldset>
        </div>
    </form>
</body>
</html>

<?php
//$buttons = new Button_Model();
//$buttons->display();

//$xmlModel->disconnect();