<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "flights";

//returns the list of all products offered. the inventory
//did not use
function getProducts() {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);

    $prodListQuery = mysqli_query($link, "SELECT * FROM product");
    $ret = array();
    for ($i = 0; $i < mysqli_num_rows($prodListQuery); $i++) {
        $result = mysqli_fetch_array($prodListQuery, MYSQLI_ASSOC);
        $prod = array();
        $prod['prodType'] = $result['product_type'];
        $prod['desc'] = $result['description'];
        $prod['totalQty'] = $result['total_qty'];
        $ret[] = $prod;
    }
    
    return $ret;
}

//returns the number of parking spots available for VIP and Standard
//did not use
function getAvailParking() {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    $qtySold = "SELECT product_id, SUM(quantity) as sold FROM order_details where product_id in (4, 5) GROUP BY product_id";
    $query = mysqli_query($link, $qtySold);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $sold = array();
    foreach($result as $r) {
        $sold[$r['product_id']] = $r['sold'];
    }
    
    $totalQty = "SELECT id, product_type, total_qty FROM product WHERE id IN (4, 5)";
    $query = mysqli_query($link, $totalQty);
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $avail = array();
    foreach($result as $r) {
        $avail[$r['id']] = $r['total_qty'] - $sold[$r['id']];
    }
    
    if($result) {
        return $avail;
    } else {
        return 0;
    }
}

//returns the list of cities
function getCities() {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);

    $cityQuery = mysqli_query($link, "SELECT * FROM cities");
    $ret = array();
    for ($i = 0; $i < mysqli_num_rows($cityQuery); $i++) {
        $result = mysqli_fetch_array($cityQuery, MYSQLI_ASSOC);
        $city = array();
        $city['city_id'] = $result['id'];
        $city['cityName'] = $result['city_name'];
        $city['state'] = $result['state'];
        $city['airportCode'] = $result['airport_code'];
        $ret[] = $city;
    }
    
    return $ret;
}

//retuns the list of available seats on a choosen destination
function getAvailableSeats($city_id) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    
    $sqlQuery = "SELECT seat FROM boarding_pass_info where arrival_city_id = " . $city_id;
    $query = mysqli_query($link, $sqlQuery);
    
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $seats = array();
    foreach($result as $seat) {
        $seats[] = $seat['seat'];
    }
    $sqlQuery = "SELECT seat FROM seats where seat NOT IN ('" . implode("', '", $seats) . "')";
    $availSeats = mysqli_query($link, $sqlQuery);
    $result = mysqli_fetch_all($availSeats, MYSQLI_ASSOC);
    $availSeats = array();
    foreach($result as $seat) {
        $newSeat['seat'] = $seat['seat'];
        $availSeats[] = $newSeat;
    }
    
    return $availSeats;
}

//returns the qty of seats available 
//did not use
function getNumSeatsAvail($city_id) {
    global $host;
    global $user;
    global $password;
    global $db;
    $link = mysqli_connect($host, $user, $password, $db);
    
    $sqlQuery = "SELECT seat FROM boarding_pass_info where arrival_city_id = " . $city_id;
    $query = mysqli_query($link, $sqlQuery);
    
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $seats = array();
    foreach($result as $seat) {
        $seats[] = $seat['seat'];
    }
    $sqlQuery = "SELECT COUNT(seat_type) FROM seats where seat NOT IN ('" . implode("', '", $seats) . "')";
    $availSeats = mysqli_query($link, $sqlQuery);
    $result = mysqli_fetch_all($availSeats, MYSQLI_ASSOC);
    
    return $result;
}