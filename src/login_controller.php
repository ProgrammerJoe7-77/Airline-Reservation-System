<?php
include 'user_model.php';
$username = $password = $err = "";
//checks if fields are empty or in proper format
	
	 if (empty($_POST["username"])) {
               $err.="Username empty ";
     }else {
	   $username = test_input($_POST["username"]);

	 }
	if (empty($_POST["password"])) {
              $err.="Password empty";
    }else {
		 	 $password = test_input($_POST["password"]);
            }
//alert box displaying errors
	if($err!=""){
			 echo '<script>
			 window.location.href = "both.php";
			 alert("There are some errors: '.$err.'")</script>'; 
//if no errors goes to index
	}else{
		login($username,$password);
		window.location.href = "index.html";
	}
         function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
         }
?>