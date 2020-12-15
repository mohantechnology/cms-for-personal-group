<?php

// $message = ""; 

session_start();


//
//  echo "<pre>".print_r($_POST)."</pre>-----";
if ((!isset( $_SESSION['admin_del'] ))||  $_SESSION['admin_del']!="admin" ) {
        
    // echo "delete is set"; 
    // header("Location:./login.php");
    echo "<h1> Blocked </h1>";
}
else if (isset($_POST['sub']) && isset($_POST['unit'])) {
//    echo  "<hr> iside delte function"; 
    function split_with_file_name($str, &$file_name)
    {
        $len = strlen($str);
        while ($len > 0 && $str[$len - 1] != "/") {
            $file_name = $str[$len - 1] . $file_name;
            $len--;
        }
        $len--;

        return 0;
    }

    function split_it($string, $patt)
    {
        $arr = [];
        $len = strlen($string);
        $str = "";
        $i = 0;
        $j = 0;

        $count = 0;
        while ($i < $len) {
            if ($string[$i] == $patt) {
                $arr[$count++] = $str;
                $str = "";
                $j = 0;
            } else {
                $str[$j++] = $string[$i];
            }
            $i++;
        }
        if ($len > 0)
            $arr[$count++] = $str;
        print_r($arr);
        return $arr;
    }

    include "password.php";
    // $conn = new mysqli("localhost", "root", "", "my_db") or die("Not able to connect");



    $sub = trim($_POST['sub']);
    $unit = trim($_POST['unit']);

    $table_name = $sub . $unit;


    if (isset($_POST['cat']) && isset($_POST['delete']) && ($_POST['delete'] == "1") && isset($_POST['path_name'])) {
        // echo "<br>inside delte method"; 
        $cat = trim($_POST['cat']);
        $path_name = trim($_POST['path_name']);
        if ($cat != "" && $path_name != "") {
            $sql = "DELETE  FroM $table_name where path_name='$path_name'";
            $conn->query($sql);
            // echo "<br>delted--**-- path "; 
          //check if table is empty 
            // $message = $message. "<br>$sql"; 
            $sql = "SELECT * FroM $table_name ";
           // echo "<br>$sql";
            $result  = $conn->query($sql);
            // echo "<hr> checking the table to delte ";
            // echo "</pre>".print_r($result)."</pre>-----";
            
            // echo "<br> topic delte-----------------<br>";
            // echo "</pre>".print_r($result)."</pre>-----";
            if ($result != "" && $result->num_rows == 0) {
                $sql = "DELETE  FroM topic where topic_name='$sub' AND unit='$unit' ";
                $conn->query($sql);
                $sql = "DROP  table  $table_name";
                $conn->query($sql);
                
                // echo "<br>deleting the topic name and table "; 
            }
            if(file_exists($path_name) && (is_dir("$path_name") == false )){
                // echo "<hr>delting the file "; 
                unlink($path_name); 
            }
        }

        ///continue
    }

    //notes box
    $sql = "SELECT * FroM $table_name where cat='note'";
    // echo "<br>$sql";
    $result = $conn->query($sql);
    if ($result != "" && $result->num_rows > 0) {
        echo ' <div class="box">
                  <p> Notes: </p><hr> <ol>';



        while ($row = $result->fetch_assoc()) {
            $temp_name = "";
            split_with_file_name($row['path_name'], $temp_name);
            echo     "<li  name='note' value='" . $row['path_name'] . "'>" . $temp_name . "</li>";
        }
        echo '</ol>  </div>';
    }







    //qp box 
    $sql = "SELECT * FroM $table_name where cat='qp'";
    // echo "<br>$sql";
    $result = $conn->query($sql);
    if ($result != "" && $result->num_rows > 0) {
        echo ' <div class="box">
    <p> Question Papers:  </p> <hr><ol>';



        while ($row = $result->fetch_assoc()) {
            $temp_name = "";
            split_with_file_name($row['path_name'], $temp_name);
            echo     "<li  name='qp' value='" . $row['path_name'] . "'>" . $temp_name . "</li>";
        }
        echo '</ol>  </div>';
    }

    //books 
    $sql = "SELECT * FroM $table_name where cat='book'";
    // echo "<br>$sql";
    $result = $conn->query($sql);
    if ($result != "" && $result->num_rows > 0) {
        echo ' <div class="box">
    <p> Books:  </p><hr> <ol>';



        while ($row = $result->fetch_assoc()) {
            $temp_name = "";
            split_with_file_name($row['path_name'], $temp_name);
            echo     "<li  name='book' value='" . $row['path_name'] . "'>" . $temp_name . "</li>";
        }
        echo '</ol>  </div>';
    }

    //video 
    $sql = "SELECT * FroM $table_name where cat='vd'";
    // echo "<br>$sql";
    $result = $conn->query($sql);
    if ($result != "" && $result->num_rows > 0) {
        echo ' <div class="box">
    <p> Video Lectures:  </p><hr> <ol>';



        while ($row = $result->fetch_assoc()) {
            $temp_name = "";
            split_with_file_name($row['path_name'], $temp_name);

            $file_name = $temp_name;
            echo     "<li  name='vd' value='" . $row['path_name'] . "'>" . $temp_name . "</li>";
      
        }
        echo '</ol>  </div>';
    }

    $conn->close();
} 
else{
    echo "<h1> Unexpectedly Ended </h1>";
}



