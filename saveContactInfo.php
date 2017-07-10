<?php
$connect=mysqli_connect("192.168.30.20","root","","appdata");

$name=$_POST["userName"];
$email=$_POST["userMail"];
$mobile$_POST["userMobile"];
$address=$_POST["userAddress"];
mysqli_query($connect,"INSERT INTO contact_info(userName,userEmail,userMobile,userAddress) VALUES('$name','$email','$mobile','$address')")
>?
