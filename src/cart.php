<!DOCTYPE html>
    <head>
        <title>
            GSU Airways - Cart
        </title>
        <script src="jquery-3.5.1.min.js"></script>
        <link rel="stylesheet" href="../css/style.css">
        <script src="../js/cart.js"></script>
    </head>
      <body class="cartB">
        <header>
            <h1 class="logo"><a href="">GSU Airways</a></h1>
            <h1 class="cart">
                <a href="./cart.php">
                    <ion-icon name="basket"></ion-icon>
                </a>
            </h1>
            <nav>
                <ul>
                    <li class=""><a href="./profile.php">Profile</a></li>
                    <li class=""><a href="index.html">Home</a></li>
                    <li class=""><a href="flights.html">Flights</a></li>
                    <li><a href="./both.php">Logout</a></li>
                  </ul>
            </nav>
        </header>
        <div class="shoppingCart">
          <h1>Your Shopping Cart</h1>
          <hr>
          <center>
            <h2><u>Flight:</u></h2>
            <table>
            <tr>
              <th>Flight</th>
              <th>Destination</th>
              <th>Seat</th>
              <th>Price</th>
            </tr>
            <tr>
              <td><div id="result1"></div></td>
              <td><div id="result2"></div></td>
              <td><div id="result3"></div></td>
              <td><div id="result4"></div></td>
            </tr>
          </table>
          <button class="buttonP" type='submit' name='add12'><a style="color: white">Clear Cart</a></button><br>
          <button class="buttonP" type='submit' name='add'><a style="color: white" href="checkout.php">Checkout</a></button>
        </center>
          <script>
            document.getElementById("result1").innerHTML = localStorage.getItem("flight");
            document.getElementById("result2").innerHTML = localStorage.getItem("destination");
            document.getElementById("result3").innerHTML = localStorage.getItem("seat");
            document.getElementById("result4").innerHTML = "$" + localStorage.getItem("price") + ".00";
            document.getElementByName("add12").innerHTML = localStorage.clear();
          </script>
          <script src = "https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
          <script src = "../js/script.js"></script>
        </div>
    </body>
</html>
