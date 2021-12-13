<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "flights";
$salt = "Cl0uDy\$ky";

//getUserInfo function connects to the DB to run a query on all Columns in the login table to get all of User's data.
function getUserInfo($login_id) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    
    $query = mysqli_query($link, "SELECT * FROM login JOIN user_profile ON user_profile.login_id = login.id WHERE login.id = " . $login_id);
    
    if(mysqli_num_rows($query) != 1) {
        return -1;
    } else {
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
        return $result;
    }
}

// updateUserPassword function connects to the DB to update the password data in the DB
//did not use
function updateUserPassword($login_id, $user_pass) {
    global $host;
    global $user;
    global $password;
    global $db;
    global $salt;
    
    $encryptedPassword = md5(md5($user_pass) . $salt);
    $link = mysqli_connect($host, $user, $password, $db);
    $sqlQuery = "UPDATE login SET password = '" . $encryptedPassword . "' WHERE id = " . $login_id;
    $query = mysqli_query($link, $sqlQuery);
    if($query != false) {
        return $login_id;
    } else {
        return -1;
    }
}

//checkUsername function checks to see if the username already exists
function checkUsername($username) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    
    $query = mysqli_query($link, "SELECT * FROM login WHERE login.username = " . $username);
    
    if(mysqli_num_rows($query) == 0) {
        return 0;
    } else {
        return -1;
    }
}

//registerUser functions connects to DB to insert User's data into login table 
function registerUser($username, $user_pass, $email, $phone) {
    global $salt;
    global $host;
    global $user;
    global $password;
    global $db;
    
    $encryptedPassword = md5(md5($user_pass) . $salt);
    $link = mysqli_connect($host, $user, $password, $db);
    $sqlQuery = "INSERT INTO login (username, password) VALUES ('" . $username . "', '" . $encryptedPassword . "')";
    $query = mysqli_query($link, $sqlQuery);
    if($query != false) {
        $login_id = $link->insert_id;
        $sqlQuery = "INSERT INTO user_profile (login_id, email, phone_num) VALUES " .
                    "('" . $login_id . "', '" . $email . "', '" . $phone . "')";
        $query = mysqli_query($link, $sqlQuery);
        return $login_id;
    } else {
        return -1;
    }
}

//updateUserInfo functions updates DB with users new info
//did not use
function updateUserInfo($login_id, $email, $phone) {
    global $host;
    global $user;
    global $password;
    global $db;
    
    $link = mysqli_connect($host, $user, $password, $db);
    $sqlQuery = "UPDATE user_profile SET email = '" . $email . "', phone_num = '" . $phone . "' WHERE login_id = " . $login_id;
    $query = mysqli_query($link, $sqlQuery);
    if($query != false) {
        return $login_id;
    } else {
        return -1;
    }
}

//login function checks if username and password matches to DB 
function login($login, $pass) {
    global $salt;
    global $host;
    global $user;
    global $password;
    global $db;
    
    $encryptedPassword = md5(md5($pass) . $salt);
    $link = mysqli_connect($host, $user, $password, $db);
    $queryToRun = "SELECT id FROM login WHERE login.username = \"" . $login . "\" AND login.password = \"" . $encryptedPassword . "\"";
    $query = mysqli_query($link, $queryToRun);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    if($result) {
        return $result['id'];
    } else {
        return -1;
    }
}

// getPaymentAccounts function gets data from all columns in payment_methods table. 
// This would get all of the payment methods for the user.
//did not use
function getPaymentAccounts($login_id){
    global $host;
    global $user;
    global $password;
    global $db;
    
    $link = mysqli_connect($host, $user, $password, $db);
    $queryToRun = "SELECT * FROM payment_methods WHERE payment_methods.login_id = " . $login_id;
    $query = mysqli_query($link, $queryToRun);
   
    $arr = array();
    for($i=0; $i < mysqli_num_rows($query); $i++){
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $arr[] = $result;
    }
    
    return $arr;
}

//getPaymentsAccount function gets all the columns from payment methods table for 
//one payment method that was selected by the user.
//did not use
function getPaymentAccount($payment_id){
    global $host;
    global $user;
    global $password;
    global $db;
    
    $link = mysqli_connect($host, $user, $password, $db);
    $queryToRun = "SELECT * FROM payment_methods WHERE payment_methods.id = " . $payment_id;
    $query = mysqli_query($link, $queryToRun);
   
    $arr = array();
    for($i=0; $i < mysqli_num_rows($query); $i++){
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $arr[] = $result;
    }
    
    return $arr;
}

//addPaymentAccount function inserts payment method info into payment method table
//did not use
function addPaymentAccount($login_id, $cred_num, $card_holder_name, $exp_date, $bill_addr1, 
                           $bill_addr2, $bill_city, $bill_state, $bill_zip, $bill_country, $bill_phone) {
    global $host;
    global $user;
    global $password;
    global $db;
    
    $link = mysqli_connect($host, $user, $password, $db);
    $sqlQuery = "INSERT INTO payment_methods (login_id, cred_num, card_holder_name, exp_date, bill_addr1, ".
                "bill_addr2, bill_city, bill_state, bill_zip, bill_country, bill_phone) VALUES ('" . 
                $login_id . "', '"  . $cred_num . "', '"  . $card_holder_name . "', '"  . $exp_date . "', '"  . 
                $bill_addr1 . "', '"  . $bill_addr2 . "', '"  . $bill_city . "', '"  . $bill_state . "', '"  . 
                $bill_zip . "', '"  . $bill_country . "', '"  . $bill_phone . "')";
    $query = mysqli_query($link, $sqlQuery);
    if($query != false) {
        $id = $link->insert_id;
        return $id;
    } else {
        return -1;
    }
}

//updatePaymentAccount function is to update the User's payment method info in payment_method table.
//did not use
function updatePaymentAccount($payment_id, $card_holder_name, $exp_date, $bill_addr1, $bill_addr2, 
                              $bill_city, $bill_state, $bill_zip, $bill_country, $bill_phone) {
    global $host;
    global $user;
    global $password;
    global $db;
    
    $link = mysqli_connect($host, $user, $password, $db);
    $sqlQuery = "UPDATE payment_methods SET card_holder_name = '" . $card_holder_name . "', exp_date = '" . $exp_date .
                "', bill_addr1 = '" . $bill_addr1 . "', bill_addr2 = '" . $bill_addr2 . "', bill_city = '" . $bill_city .
                "', bill_state = '" . $bill_state . "', bill_zip = '" . $bill_zip . "', bill_country = '" . $bill_country .
                "', bill_phone = '" . $bill_phone . "' WHERE id = " . $payment_id;
    $query = mysqli_query($link, $sqlQuery);
    if($query != false) {
        return $payment_id;
    } else {
        return -1;
    }
}

//deletePaymentAccount function deletes a row in payment_methods table based on ID.
//This function runs when user deletes one of their payment methods.
//did not use
function deletePaymentAccount($payment_id) {
    global $host;
    global $user;
    global $password;
    global $db;
    
    $link = mysqli_connect($host, $user, $password, $db);
    $sqlQuery = "DELETE FROM payment_methods WHERE id = " . $payment_id;
    $query = mysqli_query($link, $sqlQuery);
    if($query == false) {
        return -1;
    } else {
        return 0;
    }
}