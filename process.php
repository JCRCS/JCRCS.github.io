<?php include 'database.php'; ?>

<?php

// create a variable
$first_name="fun";//$_POST['first_name'];
$last_name="cio";//$_POST['last_name'];
$department="esta";//$_POST['department'];
$email="mierda";//$_POST['email'];

//Execute the query


mysqli_query($connect,"INSERT INTO pruebaxampp(first_name,last_name,department,email)
		        VALUES ('$first_name','$last_name','$department','$email')");
				
	if(mysqli_affected_rows($connect) > 0){
	echo "<p>Employee Added</p>";
	echo "<a href=\"http://localhost/addemp/index.php\">Go Back</a>";
} else {
	echo "Employee NOT Added<br />";
	echo mysqli_error ($connect);
}
