<!DOCTYPE html>
<html>
    <head>
<title>Insert data to PostgreSQL with php - creating a simple web application</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
li {
list-style: none;
}
</style>
</head>
<body>
<h1>INSERT DATA TO DATABASE</h1>
<h2>Enter data into customer table</h2>
<ul>
    <form name="InsertData" action="InsertData.php" method="POST" >
<li>Customer ID:</li><li><input type="text" name="customerid" /></li>
<li>Customer Name:</li><li><input type="text" name="customername" /></li>
<li>Customer Phone:</li><li><input type="text" name="customerphone" /></li>
<li>Address:</li><li><input type="text" name="address" /></li>
<li><input type="submit" /></li>
</form>
</ul>

<?php

if (empty(getenv("DATABASE_URL"))){
    echo '<p>The DB does not exist</p>';
    $pdo = new PDO('pgsql:host=localhost;port=5432;dbname=mydb', 'postgres', '123456');
}  else {
     
   $db = parse_url(getenv("DATABASE_URL"));
   $pdo = new PDO("pgsql:" . sprintf(
        "host=ec2-52-72-221-20.compute-1.amazonaws.com;port=5432;user=gcayufdyubzmks;password=a855215f5227852e15172c50d72f3e36e7fbf385a79165a95d6e94ae7972e158;dbname=d78qf62q4adjtj",
        $db["host"],
        $db["port"],
        $db["user"],
        $db["pass"],
        ltrim($db["path"], "/")
   ));
}  

if($pdo === false){
     echo "ERROR: Could not connect Database";
}

//Khởi tạo Prepared Statement
//$stmt = $pdo->prepare('INSERT INTO customer (customerid, customername, customerphone, address) values (:id, :name, :phone, :address)');

//$stmt->bindParam(':id','c01');
//$stmt->bindParam(':name','thien');
//$stmt->bindParam(':phone', '7393472389');
//$stmt->bindParam(':address', 'hung vuong');
//$stmt->execute();
//$sql = "INSERT INTO customer(customerid, customername, customerphone, address) VALUES('c01', 'thien','7393472389','hung vuong')";
$sql = "INSERT INTO customer(customerid, customername, customerphone, address)"
        . " VALUES('$_POST[customerid]','$_POST[customername]','$_POST[customerphone]','$_POST[address]')";
$stmt = $pdo->prepare($sql);
//$stmt->execute();
 if (is_null($_POST[customerid])) {
   echo "customerid must be not null";
 }
 else
 {
    if($stmt->execute() == TRUE){
        echo "Record inserted successfully.";
    } else {
        echo "Error inserting record: ";
    }
 }
?>
</body>
</html>
