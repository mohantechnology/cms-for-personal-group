<?php

session_start();


include "user_password.php"; 
if ((!isset($_SESSION["admin_ps"])) ||   $_SESSION["admin_ps"] != $user_password) {
     unset($_POST);
     unset($_FILES);
     unset($_SESSION["admin_ps"]);
     header("Location: ./login.php");
} else  if ((!isset($_SESSION['admin_del'])) ||  $_SESSION['admin_del'] != "admin") {

     // echo "delete is set"; 

     header("Location:./login.php");
} else   if (isset($_POST['submit']) && $_POST['submit'] == "back") {

     $_SESSION['message'] = "admin";
     header("Location: ./upload_file.php");
} else    if (isset($_GET['sub']) && isset($_GET['unit'])) {

     $_SESSION['sub'] = $_GET['sub'];
     $_SESSION['unit'] =  $_GET['unit'];
     header("Location: ./delete_file.php");
}


echo'<!DOCTYPE html>
<html>

<head>
     <title>Select File</title>
     <meta name="description" content="Notes of 3rd Semester">



</head>
<style>
     body {
          /* background-color: white; rgb(234, 230, 241)*/
          background: linear-gradient(135deg, rgb(234, 230, 241), rgb(234, 230, 241) 40%, rgb(230, 250, 241)20%, blue);
          /* background-color: rgb(66, 42, 42);; */
          margin: 0px;
          text-align: center;
          padding: 0px;


     }



     .box {
          display: inline-table;
          margin: 10px;

          box-sizing: border-box;
          height: 200px;

          width: 25%;
          border: 2px solid rgb(0, 8, 14);
          /* border-radius: 4px;; */
          /* box-shadow: 10px 10px 10px 1px  rgb(17, 17, 24); */
          background-color: whitesmoke;

     }


     .box:hover {

          border-color: blue;


     }

     .head {
          background-color: blue;
          border-bottom: 2px solid black;
          color: white;
          padding: 20px 0px;
          text-align: center;

          font-size: 20px;

     }

     #header {
          text-align: center;

     }

     ol a li {
          padding: 4px;
          font-size: 15px;
          text-align: left;

          /* margin:23px; */

     }

     ol a li:hover {
          /* color:blue; */
          /* color: rgb(124, 98, 172); */
          /* background-color: rgba(255,0,0,1); */
          background: linear-gradient(to right, red, red, red, whitesmoke);
          color: GREY;
          ;

          width: 90%;
     }

     hr {
          width: 95%;
     }

     .box a {
          color: rgb(49, 49, 105);

          font-size: 8px;
     }

     #admin {
          height: 30px;
     }

     button {
          border: 0px solid transparent;
          border-radius: 4px;
          /* width:40%; */
          padding: 8px 40px;
          font-weight: 500px;
          color: white;
          /* margin-bottom:10px;       */
          background-color: rgb(45, 45, 197);
          /* margin-bottom:200px; */

     }

     form {

          margin: 10px;
          padding: 30px;


     }

     button:hover {
          background-color: rgb(86, 86, 219);

     }



     @media screen and (max-width:1000px) {
          .box {
               display: block;
               height: unset;
               width: 90%;
               margin: 50px auto;
          }


          ol a li {
               font-size: 30px;

          }

          ol {
               margin: 70px;
          }

          button {
               width: 90%;
               font-size: 20px;

          }

          form div {
               height: 20px;;
          }
          #admin_but {
               padding: 20px; 
              font-size: 30px;
               margin:20px auto ;
               width:95%;  
         }


          .head {
               font-size: 30px;
          }

     }
</style>


<body>

     <div style="height:40px;background:linear-gradient(to bottom right ,blue ,white);margin:0px;padding:0px ;display:fixed"></div>
     <h1 id="header">Select File To Delete </h1>
     <hr>

';

$flag = 1;
//  echo $_GET['sub'] ."and ".$_GET['unit'];

// $conn = new mysqli("localhost", "root", "", "my_db") or die("Not able to connect");
include "password.php";

$sql = "SELECT * FROM topic where topic_name='os' order by unit asc";
$result = $conn->query($sql);
// print_r($result); 
if ($result != "" &&  $result->num_rows > 0) {
     $flag = 0;
     echo ' <div id="id" class="box">
   <div class="head">
   Operating System
   </div><div class="box_content">

   <ol>';
     while ($row = $result->fetch_assoc()) {
          $temp_str = $row['unit'] == "6" ? "PRACTICAL" : "UNIT-&nbsp;" . $row['unit'];
          echo '<a href="./select_file.php?sub=' . $row['topic_name'] . '&unit=' . $row['unit'] . '"><li >'  . $temp_str . "</li></a>";
     }
     echo ' </ol> </div>  </div>';
}



$sql = "SELECT * FROM topic where topic_name='ds' order by unit asc";
$result = $conn->query($sql);
// print_r($result); 
if ($result != "" &&  $result->num_rows > 0) {
     $flag = 0;
     echo ' <div id="id" class="box">
   <div class="head">
   Data Structures and Agorithms
   </div><div class="box_content">

   <ol>';
     while ($row = $result->fetch_assoc()) {
          $temp_str = $row['unit'] == "6" ? "PRACTICAL" : "UNIT-&nbsp;" . $row['unit'];
          echo '<a href="./select_file.php?sub=' . $row['topic_name'] . '&unit=' . $row['unit'] . '"><li >'  . $temp_str . "</li> </a>";
     }
     echo ' </ol> </div>  </div>';
}


$sql = "SELECT * FROM topic where topic_name='ppl' order by unit asc";
$result = $conn->query($sql);
// print_r($result); 
if ($result != "" && $result->num_rows > 0) {
     $flag = 0;
     echo ' <div id="id" class="box">
   <div class="head">
   Principles of Programming Languages
   </div><div  class="box_content">

   <ol>';
     while ($row = $result->fetch_assoc()) {
          $temp_str = $row['unit'] == "6" ? "PRACTICAL" : "UNIT-&nbsp;" . $row['unit'];
          echo '<a href="./select_file.php?sub=' . $row['topic_name'] . '&unit=' . $row['unit'] . '"><li >'  . $temp_str . "</li> </a>";
     }
     echo ' </ol> </div>  </div>';
}

$sql = "SELECT * FROM topic where topic_name='math' order by unit asc";
$result = $conn->query($sql);
// print_r($result); 
if ($result != "" && $result->num_rows > 0) {
     $flag = 0;
     echo ' <div id="id" class="box">
   <div class="head">
        Mathamatics
        </div><div  class="box_content">

   <ol>';
     while ($row = $result->fetch_assoc()) {
          $temp_str = $row['unit'] == "6" ? "PRACTICAL" : "UNIT-&nbsp;" . $row['unit'];
          echo '<a href="./select_file.php?sub=' . $row['topic_name'] . '&unit=' . $row['unit'] . '"><li >'  . $temp_str . "</li> </a>";
     }
     echo ' </ol> </div>  </div>';
}


$sql = "SELECT * FROM topic where topic_name='de' order by unit asc";
$result = $conn->query($sql);
// print_r($result); 
if ($result != "" && $result->num_rows > 0) {
     $flag = 0;
     echo ' <div id="id" class="box">
   <div class="head">
   Digital Electronics
   </div><div  class="box_content">

   <ol>';
     while ($row = $result->fetch_assoc()) {
          $temp_str = $row['unit'] == "6" ? "PRACTICAL" : "UNIT-&nbsp;" . $row['unit'];
          echo '<a href="./select_file.php?sub=' . $row['topic_name'] . '&unit=' . $row['unit'] . '"><li >'  . $temp_str . "</li> </a>";
     }
     echo ' </ol> </div>  </div> ';
}


//  echo"$flag"; 
if ($flag) {
     echo "<h1> NO RECORDS FOUND </h1>";
}

$conn->close();
?>

<hr>
<!-- <div id="admin">Administrator</div> -->
<form action="" method="post" id="admin" id="form_box">
     <button type="submit" name="submit" value="back" id="admin_but">Back </button>
     <div></div>
</form </body> </html>