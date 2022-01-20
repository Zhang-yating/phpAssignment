<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Customer Info</title>
    <style>
        header, footer{
            background-color: lightblue;
            height: 200px;
            width: 100%;
            padding-top: 70px;
        }
        #defaultTable th, #defaultTable td{
            text-align: center;
            font-size: 17px;
            border: 1px solid black;
            padding: 10px;
        }
        footer{
            padding-top: 0;
            margin-top: 20px;
            color: coral;
        }
        #copyright,#contact,#location,#follow_us{
            margin-top: 20px;
            display: inline-block;
            float: left;
            text-align: center;
            width: 13%;
        }
        #contact, #location,#follow_us{
            margin-left: 16%;
        }
        footer span{
            color:lightslategray;}
        #headInfo{
            margin: 0 auto;
            text-align: center;
            font-size: 40px;
            color: darkslateblue ;
            width: 350px;
            border-top-style: none;
            border-left-style: none;
            border-right: 5px solid coral;
            border-bottom: 1px solid lightseagreen ;
        }
        #headInfo span{
            font-size: 50px;
            font-family: "American Typewriter";
            color: coral;
        }
        .InfoBoard{
            display: inline-block;
            margin-top: 10px;
            margin-left: 5%;
            padding: 5px;
        }
        #Totalsales, #salesInfo{
            color: coral;
        }
        #defaultTable{
            display: block;
            width: 90%;
            margin: 20px 5%;
            background-color: white;
            border-collapse: collapse;
            overflow: scroll;
        }

        #navbar{
            background-color: lightblue;
            height: 40px;
            margin: 0;
            padding: 0;
        }
        #navbar li{
            display: inline-block;
            color: white;
        }
        #thisPage, #nextPage{
            text-decoration: none;
            color: white;
            font-size: larger;
            text-align: center;
            padding: 10px;
        }
        #thisPage:hover{
            color: lightseagreen;
        }
        #nextPage:hover{
            color: lightseagreen;
        }
        .wripper{
            margin: 50px auto;
            padding: 10px 10px;
            width: 1200px;
            background-color: lightblue;
        }
        #nomatch{
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
            color: black;
            font-size: x-large;
        }

    </style>
</head>
<body>
<header>
    <div id = headInfo><span>C</span>ustomer Information</div>
</header>
<ul id = "navbar">
    <li><a id = "thisPage" href = "http://localhost/as3/index.php">Product Line </a></li>
    <li>|</li>
    <li><a id = "nextPage" href = "http://localhost/as3/reps.php" >Sales Reps </a></li>
</ul>
<div class="wripper">
<?php
require_once 'config.php';
try{
    $pdo = new PDO("mysql:host = $servername; dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $re1 = $re2 = "";
    $str1 = "SELECT c.customerName, c.addressLine1, c.addressLine2, c.creditLimit, group_concat(distinct o.orderNumber) as orderNumbers, sum(distinct amount) as totalPayments FROM customers c, orders o, payments p WHERE c.customerNumber = o.customerNumber AND o.customerNumber = P.customerNumber AND salesRepEmployeeNumber =".$_GET['id']." GROUP BY c.customerName, c.addressLine1, c.addressLine2, c.creditLimit";
    $str2 = "SELECT sum(od.quantityOrdered * od.priceEach ) as sumSale FROM orders o, customers c, orderdetails od  WHERE o.customerNumber = c.customerNumber AND c.salesRepEmployeeNumber =".$_GET['id']." AND o.orderNumber = od.orderNumber";
    $stmt1 = $pdo->query($str1);
    $stmt2 = $pdo->query($str2);
    echo "<div class = 'InfoBoard'> Sales ID Number: <span id = 'salesInfo'>".$_GET['id']."</span></div>";
    foreach ($stmt2 as $row){
        $re2.= "<div class = 'InfoBoard'>Total sales value: <span id ='Totalsales'>".$row['sumSale']."</span></div>";
    }
    foreach ($stmt1 as $row){
        $re1.= "<tr><td>".$row['customerName']."</td><td>".$row['addressLine1']."</td><td>".$row['addressLine2']."</td><td>".$row['creditLimit']."</td><td>".$row['orderNumbers']."</td><td>".$row['totalPayments']."</td></tr>";
    }
    if($re1 === ""){
        echo "<p id = 'nomatch'>nothing returns</p>";
    }
    else{
        echo $re2;
        echo "<table id = 'defaultTable'>";
        echo "<tr><th style='width:10% '>name</th><th style='width:12% '>address1</th><th style='width:12% '>address2</th><th style='width:22% '>credit limit</th><th style='width:24% '>order numbers</th><th style='width:20% '>total payments</th></tr>";
        echo $re1;
        echo "</table>";
    }

}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
</div>
<footer>
    <div class = "wripper">
        <div id = "copyright">
            @COPYRIGHT<br>
            <span>gagaaaa</span>
        </div>

        <div id = "contact">
            CONTACT<br>
            <span> gagagagaga<br>boobobobobob</span>
        </div>
        <div id = "location">
            LOCATION<br><span>
            XXXXXXXXXXX
                XXXXXXXXXXX</span>
        </div>

        <div id="follow_us" >FOLLOW US<br><span>XXXXXXX</span></div>
    </div>
</footer>


</body>
</html>