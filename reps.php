<!Doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Sales reps</title>
    <style>
        header, footer{
            background-color: lightblue;
            height: 200px;
            width: 100%;
            padding-top: 70px;
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
            color:lightslategray;
        }
        #headInfo{
            margin: 0 auto;
            text-align: center;
            font-size: 60px;
            color: darkslateblue ;
            width: 350px;
            border-top-style: none;
            border-left-style: none;
            border-right: 5px solid coral;
            border-bottom: 1px solid lightseagreen ;
        }
        #headInfo span{
            font-size: 80px;
            font-family: "American Typewriter";
            color: coral;
        }
        #defaultTable th, #defaultTable td{
            text-align: center;
            font-size: 17px;
            border: 1px solid black;
            padding: 8px;
        }

        #defaultTable{
            display: block;
            width: 90%;
            margin: 30px auto;
            background-color: white;
            border-collapse: collapse;
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
        #thisPage{
            color: lightseagreen;
        }
        #nextPage:hover{
            color: lightseagreen;
        }
        #firstname{
            border: none;
            background-color: white;
        }

        #firstname:hover{
            color:lightseagreen;
        }
        .wripper{
            margin: 50px auto;
            padding: 10px 10px;
            width: 940px;
            background-color: lightblue;
        }
        #info{
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
    <div id = headInfo><span>S</span>ales Reps</div>
</header>
<ul id = "navbar">
    <li><a id = "thisPage" href = "http://localhost/as3/reps.php">Sales Reps </a></li>
    <li>|</li>
    <li><a id = "nextPage" href = "http://localhost/as3/index.php" >Product Line </a></li>
</ul>
<div class = wripper>
<?php
require_once 'config.php';
try{
    $pdo = new PDO("mysql:host = $servername; dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p id = 'info'> Information about the sales reps</p>";
    echo "<table id = 'defaultTable'>";
    echo "<tr><th>first name</th><th>last name</th><th>email</th><th>officeAddress1</th><th>officeAddress2</th><th>manager name</th></tr>";
    $stmt1 = $pdo->query('SELECT e1.employeeNumber, e1.firstName as employeeName, e1.lastname, e1.email, city, addressLine1, e2.firstname as managerName  FROM employees e1, offices o, employees e2 WHERE e1.officeCode = o.officeCode AND e1.reportsTo = e2.employeeNumber AND e1.jobTitle = "Sales Rep" ');
    foreach ($stmt1 as $row){
        $firstName = "<a href='customerInfo.php?id=".$row['employeeNumber']." '>".$row['employeeName']."</a>";
        echo "<tr><td>".$firstName."</td>"."<td>".$row['lastname']."</td>"."<td>".$row['email']."</td>"."<td>".$row['city']."</td>"."<td>".$row['addressLine1']."</td>"."<td>".$row['managerName']."</td></tr>";
    }
    echo "</table>";
} catch(PDOException $e) {
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