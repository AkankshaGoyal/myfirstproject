<?php
$username = $_POST['username'];
$password = $_POST['password'];
$gender =  $_POST['gender'];
$email =   $_POST['email'];
$phoneCode=$_POST['phoneCode'];
$phone=$_POST['phone'];
$city=$_POST['city'];
$Areaofinterest=$_POST['Areaofinterest'];
$qualification=$_POST['qualification'];
$f=$_FILES['file'];
// echo "File Name: $f['name']";
// echo "File Type: $f['type']";
// echo "File Size: $f['size']";
move_uploaded_file($f['tmp_name'],"uploads/".$f['name']);
if (!empty($username) || !empty($password)  || !empty($email) || !empty($phoneCode) || !empty($phone)  || !empty($gender) || !empty($city) ||
!empty($Areaofinterest) || !empty($qualification)){
	 $host="localhost";
     $dbUsername="root";
     $dbPassword="";
     $dbname="mydb";

     
     //create connection
     $conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);

 if(mysqli_connect_error()){
 	die('Connect Error('. mysqli_connect_error().')'.mysqli_connect_error());
 } else{
 	$SELECT ="SELECT email From  register Where email = ? Limit 1";
 	$INSERT ="INSERT Into register ( username,password,email,phoneCode,phone,gender,city,Areaofinterest,qualification) values(?,?,?,?,?,?,?,?,?)";
 	//prepare statement

 	$stmt = $conn->prepare($SELECT);
 	$stmt->bind_param("s",$email);
 	$stmt->execute();
 	$stmt->bind_result($email);
 	$stmt->store_result();
 	$rnum = $stmt->num_rows;
 if($rnum==0){
 	$stmt->close();

 	$stmt = $conn->prepare($INSERT);
 	$stmt ->bind_param("sssiissss",$username,$password,$email,$phoneCode,$phone,$gender,$city,$Areaofinterest,$qualification);
 	$stmt ->execute();
 	echo "New record inserted succesfully";
 
}else{
 	echo"Someone already registered using this email";
 }
 $stmt->close();
 $conn->close();

 }
}else {
	echo "All fields are required";
	die();
}
?>