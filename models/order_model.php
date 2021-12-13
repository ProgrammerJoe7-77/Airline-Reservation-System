<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "flights";

updateQty(1, 15, 2);

//this function gets all the orders the user has placed
function getOrders($login_id)
{
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);

    $query = mysqli_query($link, "SELECT * FROM order_header AS OH WHERE OH.login_id = " . $login_id);

    $ret = array();
    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $head = array();
        $head['orderNum'] = $result['id'];
        $head['date'] = $result['order_date'];
        $head['total'] = $result['total_amount'];

        $query2 = mysqli_query($link, "SELECT * FROM order_details AS OD JOIN product ON OD.product_id = product.id WHERE OD.order_header_id = " . $result['id']);
        $details = array();
        for ($j = 0; $j < mysqli_num_rows($query2); $j++) {
            $result2 = mysqli_fetch_array($query2, MYSQLI_ASSOC);
            $detail = array();
            $detail['id'] = $result2['id'];
            $detail['qty'] = $result2['quantity'];
            $detail['price'] = $result2['price'];
            $detail['desc'] = $result2['description'];
            $detail['prodType'] = $result2['product_type'];
            
            $details[] = $detail;
        }
        $head['details'] = $details;
        $ret[] = $head;
    }
    
    return $ret;
}
//This functions is used to view a boarding pass of an order.
//did not use
function getBoardingPasses($order_detail_id) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);

    $query = mysqli_query($link, "SELECT * FROM boarding_pass_info AS BPI JOIN cities ON cities.id = BPI.arrival_city_id WHERE BPI.order_details_id = " . $order_detail_id);

    $ret = array();
    for ($i = 0; $i < mysqli_num_rows($query); $i++) {
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $pass = array();
        $pass['passengerName'] = $result['passenger_name'];
        $pass['seat'] = $result['seat'];
        $pass['city'] = $result['city_name'];
        $pass['state'] = $result['state'];
        $pass['airportCode'] = $result['airport_code'];
        $ret[] = $pass;
    }
    
    return $ret;
}

//this function returns the users current shopping cart
function getShoppingCart($login_id) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);

    $query = mysqli_query($link, "SELECT * FROM order_header AS OH WHERE OH.order_type = 'S' AND OH.login_id = " . $login_id);

    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $head = array();
    $head['orderNum'] = $result['id'];
    $head['date'] = $result['order_date'];
    $head['total'] = $result['total_amount'];

    $query2 = mysqli_query($link, "SELECT * FROM order_details AS OD JOIN product ON OD.product_id = product.id WHERE OD.order_header_id = " . $result['id']);
    $details = array();
    for ($j = 0; $j < mysqli_num_rows($query2); $j++) {
        $result2 = mysqli_fetch_array($query2, MYSQLI_ASSOC);
        $detail = array();
        $detail['id'] = $result2['id'];
        $detail['qty'] = $result2['quantity'];
        $detail['price'] = $result2['price'];
        $detail['desc'] = $result2['description'];
        $detail['prodType'] = $result2['product_type'];
        
        $details[] = $detail;
    }
    $head['details'] = $details;
    
    return $head;
}

// adds items to the shopping cart
function addToCart($login_id, $product_id, $quantity, $price) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    
    $orderQuery = mysqli_query($link, "SELECT * FROM order_header WHERE order_type = 'S' AND login_id = " . $login_id);
    
    if(mysqli_num_rows($orderQuery) == 1) {
        $result = mysqli_fetch_array($orderQuery, MYSQLI_ASSOC);
        $sqlQuery = "INSERT INTO order_details(order_header_id, product_id, quantity, price) VALUES (" .
        $result['id'] . ", " . $product_id . ", " . $quantity . ", " . $price . ")";
        $header_id = $result['id'];
        $currentAmount = $result['total_amount'];
    } else {
        $sqlQuery = "INSERT INTO order_header(order_type, login_id) VALUE ('S', " . $login_id . ")";
        $result = mysqli_query($link, $sqlQuery);
        if($result == false) {
            return -1;
        } else {
            $header_id = $link->insert_id; 
            $sqlQuery = "INSERT INTO order_details(order_header_id, product_id, quantity, price) VALUES (" .
            $header_id . ", " . $product_id . ", " . $quantity . ", " . $price . ")";
            mysqli_query($link, $sqlQuery);
        }
        $currentAmount = 0;
    }
    
    $detail_id = $link->insert_id;
    
    $newTotal = $price * $quantity + $currentAmount;
    $update = mysqli_query($link, "UPDATE order_header SET total_amount = " . $newTotal . " WHERE id = " . $header_id);
    if($update == false) {
        return -2;
    } else {
        return $detail_id;
    }
}

//updates the qty while in the shopping cart. can also be used to delete the qty in the cart by setting it to zero.
function updateQty($login_id, $detail_id, $new_quantity) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    
    $orderQuery = mysqli_query($link, "SELECT * FROM order_header WHERE order_type = 'S' AND login_id = " . $login_id);
    $order = mysqli_fetch_array($orderQuery);
    $detailQuery = mysqli_query($link, "SELECT * FROM order_details JOIN product ON product.id = order_details.product_id WHERE order_details.id = " . $detail_id . 
                   " AND order_header_id =" . $order['id']);
    $detail = mysqli_fetch_array($detailQuery);
    $qtyDiff = $new_quantity - $detail['quantity'];
    $price = $detail['price'];
    $newTotal = $order['total_amount'] + $qtyDiff * $price;
    if($new_quantity == 0) {
        $updateDetailQuery = mysqli_query($link, "DELETE FROM order_details where id = " . $detail_id);
    } else {
        $updateDetailQuery = mysqli_query($link, "UPDATE order_details SET quantity = " . $new_quantity . " WHERE id = " . $detail_id);
    }
    if($updateDetailQuery == false) {
        return -1;
    } else {
        $updateOrderQuery = mysqli_query($link, "UPDATE order_header SET total_amount = " . $newTotal . " WHERE id = " . $order['id']);
        if($updateOrderQuery == false) {
            return -2;
        } else {
            return 0;
        }
    }
}

//converts shopping cart to and order after checkout
function convertToOrder($login_id, $payment_method_id) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    
    $date = date("Y-m-d");
    $sqlQuery = "UPDATE order_header SET order_type = 'O', payment_methods_id = " . $payment_method_id . ", order_date = '" . $date . 
                "' WHERE login_id = " . $login_id . " AND order_type = 'S'";
                
    $convertQuery = mysqli_query($link, $sqlQuery);
    if($convertQuery == false) {
        return -1;
    } else {
        return 0;
    }
}

//Adds boarding pass information
function addBoardingPass($order_detail_id, $passenger_name, $seat, $arrival_city_id) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    
    $query = "INSERT INTO boarding_pass_info (order_details_id, passenger_name, seat, arrival_city_id) VALUES ("
    . $order_detail_id . ", '" . $passenger_name . "', '" . $seat . "', " . $arrival_city_id . ")";
    $sqlQuery = mysqli_query($link, $query);
        
    if( $sqlQuery == false){
        return -1;
    }else{
       $boarding_pass_id =  $link->insert_id;
        return $boarding_pass_id;
    }
}