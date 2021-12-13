<?php

         // define variables and set to empty values
         $name = $email = $password = $phone = $err = "";
//         if (empty($_POST["name"]) || empty($_POST["email"]) ||!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($_POST["password"]) ||empty($_POST["phone"]) ||!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST["phone"])){
			if (empty($_POST["username"])) {
               $err.="Username empty ";
            }else {
               $username = test_input($_POST["username"]);
            }
            if (empty($_POST["fname"])) {
               $err.="First Name empty ";
            }else {
               $firstname = test_input($_POST["firstname"]);
            }
			if (empty($_POST["lname"])) {
               $err.="Last Name empty ";
            }else {
               $lastname = test_input($_POST["lastname"]);
            }
            
            if (empty($_POST["email"])) {
               $err.="Email empty ";
            }else {
               $email = test_input($_POST["email"]);
               
               // check if e-mail address is well-formed
               if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $err.="Invalid email format ";
               }
            }
            
            if (empty($_POST["password"])) {
                $err.="Password empty ";
            }else {
               $password = test_input($_POST["password"]);
            }
			 
		if (empty($_POST["phone"])) {
           $err.="Phone empty";
        }else if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST["phone"])) {
        $phone = test_input($_POST["phone"]);
        } 
		else {           
			  $err.="Phone is not in proper format 000-000-0000 ";
          
        }
//			 header("Location:both.php");
//			 exit();
		if ($err!=""){
			 echo '<script>
			 window.location.href = "both.php";
			 alert("There are some errors: '.$err.'")</script>'; 
        }
		else{
			$file= 'users.html';
			$input=file_get_contents($file);
			$input .= $username . " " . $password . "\n";
			file_put_contents($file, $input);
			header("Location:index.html");
			exit();
		}
         
         
         function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
         }

 
?>
