<?php
	
$username = $password = $err = "";
//if(empty($_POST["username"]) || !filter_var($username, FILTER_VALIDATE_EMAIL) || empty($_POST["password"])){
	
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
	if($err!=""){
			 echo '<script>
			 window.location.href = "both.php";
			 alert("There are some errors: '.$err.'")</script>'; 
	}
	$user=$_POST["username"]." ".$_POST["password"];   
    $users=file_get_contents("users.html");
    if(str_contains($users,$user)){ 
      header("Location:index.html");
		}else{
		include 'both.php';
		$cookie = $_COOKIE[$counter]+1;
        setcookie($counter, $cookie);
		echo '<script>
			 window.location.href = "both.php";
			 alert("Invalid Login. Attempts: '.($_COOKIE[$counter]+1).'")</script>';
	}

         function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
         }
?>
