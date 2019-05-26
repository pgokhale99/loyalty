<?php
 
if($_POST['submit1'] != '')
{
echo "You hit the button 1";
}
if($_POST['submit2'] != '')
{
echo "You hit the button 2";
}
 
?>
 
<html>
<head><title>Multiple Submit button Solved with PHP!</title></head>
<body>
<form action="" method="post">
 
<h2> Hit the Submit Button</h2>
 
<input type="submit" name="submit1" value="btn1" />
<input type="submit" name="submit2" value="btn2" />
 
</form>
</body>
</html>