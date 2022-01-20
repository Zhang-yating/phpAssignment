<!DOCTYPE html>
<html lang = 'en'>
<head>
    <meta charset="utf-8"/>
    <title>Product Information</title>
    <style>
        #errorMessage{
            color: red;
            text-align: center;
            padding: 5px;
        }
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
            width: 600px;
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
        .wripper{
            margin: 50px auto;
            padding: 10px 10px;
            width: 940px;
            background-color: lightblue;
        }

        #defaultTable{
            display: block;
            width: 90%;
            margin: 30px auto;
            background-color: white;
            border-collapse: collapse;
        }
        th{
            height: 35px;
        }
        #defaultTable th, #defaultTable td{
            text-align: center;
            font-size: 17px;
            border: 1px solid black;
            padding: 8px;
        }


        #b1, #b2, #b3{
            display: inline-block;
            width: 15%;
            margin-top: 25px;
            border: none;
            border-bottom: 3px solid lightblue;
            background-color: white;
        }
        #b1{
            margin-left:2% ;
        }
        #b2{
            margin-left: 25%;
            margin-right: 25%;
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
        form{
            display: none;
            margin-top: 20px;
            border: 2px solid coral;
        }
        form input{
            margin-left: 10px;
            margin-top: 15px;
        }
        form label{
            margin-left: 5px;
            display: inline-block;
            width: 200px;
        }
        form button{
            margin-bottom: 10px;
            margin-left: 10px;
            color: black;
            border: 1px solid lightseagreen;
        }
        form button:hover{
            background-color: lightseagreen;
            color: white;
        }
        #filterProductLine label{
           width:180px;

        }

        #filterquantity label{
            width: auto;
            margin-bottom: 20px;
        }
        .errormessage {
            font-size: 15px;
            color: red;
            margin-left: 10px;
        }
        #info, #nomatch{
            text-align: center;
            padding-top: 20px;
            padding-bottom: 20px;
            color: black;
            font-size: x-large;
        }
    </style>
    <script>
        function showUpDisapear(formId, buttonId){
            let formTable = ['filterProductLine', 'sortquantity', 'filterquantity'];
            let dict = {'filterProductLine': 'b1', 'sortquantity': 'b2', 'filterquantity': 'b3'};
            for(let i = 0; i < formTable.length; i++){
                if (formTable[i] !== formId){
                    document.getElementById(formTable[i]).style.display = "none";
                    document.getElementById(dict[formTable[i]]).style.color = 'black';
                }
            }
            let ele = document.getElementById(formId);
            let button = document.getElementById(buttonId);
            let DisplayValue = window.getComputedStyle(ele, null).getPropertyValue("display")
            if (DisplayValue === "none" ){
                ele.style.display = "block";
                button.style.color = "coral"
            }else{
                ele.style.display = "none";
                button.style.color = "black"
            }
        }
    </script>
</head>
<body>
<?php
try{
    require_once 'config.php';
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo "<h1 id = 'errorMessage'>Database connection error! ".$e->getMessage().'</h1>';
}
$sql = "SELECT productName, productCode, productDescription, quantityInStock, MSRP FROM products";
$stockErr = $stockV = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST["filterPL"])) {
        $length = count($_POST["filterPL"]);
        $str = " WHERE ";
        for ($x = 0; $x < $length ; $x++){
            if ($x < $length-1){
                $str .= "productLine = ".($_POST['filterPL'])[$x]. "OR ";
            }
            else {
                $str .= "productLine = ".($_POST['filterPL'])[$x];
            }
        }
        $sql .= $str;
    }
    else if(isset($_POST["sortQ"])){
        $str = "";
        if($_POST["sortQ"] === 'descend'){
            $str = " ORDER BY quantityInStock DESC";
        }
        else if($_POST["sortQ"] === 'ascend'){
            $str = " ORDER BY quantityInStock ASC";
        }
        $sql .= $str;
    }
    else if(isset($_POST["filterQ"])){
        $stockErr = "";
        if(empty($_POST['filterQ'])){
            $stockErr = "Error: Quantity number is required!";
            $stockV = $_POST['filterQ'];
        }
        else if(filter_var($_POST['filterQ'], FILTER_VALIDATE_INT) !== 0 && !filter_var($_POST['filterQ'], FILTER_VALIDATE_INT)){
            $stockErr = "Error: Only integer allowed!";
            $stockV = $_POST['filterQ'];
        }

        else {
            $str = " WHERE quantityInStock <= " . $_POST["filterQ"];
            $sql .= $str;
        }
    }
}
?>
<header>
    <div id = headInfo><span>P</span>roduct Information</div>
</header>
<ul id = "navbar">
    <li><a id = "thisPage" href = "http://localhost/as3/index.php">Product Line </a></li>
    <li>|</li>
    <li><a id = "nextPage" href = "http://localhost/as3/reps.php" >Sales Reps </a></li>
</ul>
<div  class = "filter" id = "filterProduct">
    <button id = "b1" onclick ="showUpDisapear('filterProductLine', 'b1')">Filter by product line</button>
    <button id = "b2" onclick="showUpDisapear('sortquantity', 'b2')">Sort by quantity in stock</button>
    <button id = "b3" onclick="showUpDisapear('filterquantity', 'b3')">Filter by quantity in stock</button>
    <form action = " " method = "post" id = "filterProductLine">
        <?php
        $stmt = $conn->query("SELECT productLine FROM productlines");
        foreach ($stmt as $row){
            echo "<input type = 'checkbox' name = 'filterPL[]' value = ".'"'."'". $row['productLine']."'".'"'."><label for = 'classic'>".$row['productLine']."</label>";
        }
        echo "<br><br><button type = 'submit'>Apply</button>"
        ?>
    </form>
    <form action = " " method = "post" id = "sortquantity">
        <input type = "radio" name = "sortQ" value = "descend"><label for = "descend">Sorted in decreasing </label><br>
        <input type = "radio" name = "sortQ" value = "ascend"><label for = "ascend">Sorted in increasing</label><br><br>
        <button type = 'submit'>Apply</button>
    </form>
    <form action = " " method = "post" id = "filterquantity">
        <label>Show the product information for those with a quantity less than: </label>
        <input type = "text" name = "filterQ" value = "<?php echo $stockV;?>"><span class = "errormessage"><?php echo $stockErr; ?></span><br>
        <button type = 'submit'>Apply</button>
    </form>
</div>
<div class ="wripper">
<?php
try {
    $stmt = $conn->query($sql);
    $result = "";
    foreach($stmt as $row) {
        $result.= "<tr><td>".$row['productName']."</td><td>".$row['productCode']."</td><td>".$row['productDescription']."</td><td>".$row['quantityInStock']."</td><td>".$row['MSRP']."</td></tr>";
    }
    if($result === ""){
        echo "<p id = 'nomatch'>nothing returned</p>";
    }
    else{
        echo "<p id = 'info'> Information about the product line</p>";
        echo "<table id = 'defaultTable'>";
        echo "<tr><th>Name</th><th>Code</th><th>Description</th><th>QuantityInStock</th><th>MSRP</th></tr>";
        echo $result;
        echo "</table>";
    }

    // check if user entered a valid value for the stock or not, if not then display the zone with a error message.
    if($stockErr !== ""){
        echo "<script>document.getElementById('filterquantity').style.display = 'block';</script>";
    }
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