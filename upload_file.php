<?php

session_start();

include "user_password.php";
if ((!isset($_SESSION["admin_ps"])) ||   $_SESSION["admin_ps"] != $user_password) {
    unset($_POST);
    unset($_FILES);
    unset($_SESSION["admin_ps"]);
    header("Location: ./login.php");
}
$error = "";
$sucess = "";

if (isset($_POST['delete']) &&  $_POST['delete'] == "true") {
    $_SESSION['admin_del'] = "admin";
    // echo "delete is set";
    header("Location:./select_file.php");
}
if (isset($_POST['logout']) &&  $_POST['logout'] == "true") {
    unset($_POST);
    unset($_FILES);
    unset($_SESSION["admin_ps"]);
    unset($_SESSION["admin_del"]);
    session_destroy();
    header("Location:./login.php");
}
function seo_friendly_url($string)
{
    $string = trim($string);
    $len = strlen($string);
    $i = 0;

    for ($i = 0; $i < $len; $i++) {
        if ($string[$i] == '#' || $string[$i] == '$' || $string[$i] == '%' || $string[$i] == '=' || $string[$i] == '"' || $string[$i] == "'" || $string[$i] == '@' || $string[$i] == '!' || $string[$i] == '^' || $string[$i] == '&' || $string[$i] == '*' || $string[$i] == '+' || $string[$i] == '`' || $string[$i] == '~' || $string[$i] == '?' || $string[$i] == ',' || $string[$i] == '<' || $string[$i] == '>' || $string[$i] == '?' || $string[$i] == ':' || $string[$i] == ';' || $string[$i] == '{' || $string[$i] == '[' || $string[$i] == ']' || $string[$i] == '}' || $string[$i] == '|') {
            $string[$i] = '-';
        }
    }

    return (($string));
}
function split_with_extension_name($str, &$real_name, &$exten)
{


    $len = strlen($str);
    while ($len > 0 && $str[$len - 1] != ".") {
        $exten = $str[$len - 1] . $exten;
        $len--;
    }
    $len--;
    while ($len > 0) {
        $real_name = $str[$len - 1] . $real_name;
        $len--;
    }

    $exten = strtolower($exten);
    return 0;
}

// echo '<pre>';
// print_r($_POST);
// printf("<br> count is %d ", count($_FILES['up_file'], 1));

// echo "<br> size of file = " . sizeof($_FILES) . " post - " . sizeof($_POST);
// echo '</pre>';


if (isset($_FILES['up_file']) && $_FILES['up_file']['size']  && isset($_POST['submit']) && $_POST['submit'] == "true") {

    // echo '<pre>';
    // print_r($_FILES);
    // echo "error is<br>";
    // echo $_FILES['up_file']['error'];
    // echo "error is<br>";
    // echo print_r(error_get_last());
    // echo '</pre>';
    $no_of_file = count($_FILES["up_file"]["name"]);
    // echo "<br> Totoal no of ifle is: " . $no_of_file;
    $no_of_file_uploaded = 0;
    $file_extension_arr["php"]= 1; 
    $file_extension_arr["js"]= 1;
    include "password.php";
    for ($i = 0; $i < $no_of_file; $i++) {

        $f_name = seo_friendly_url($_FILES["up_file"]["name"][$i]);
        $f_temp_name = $_FILES["up_file"]["tmp_name"][$i];
        $sub = trim($_POST['subject']);
        $unit  = trim($_POST['unit']);
        $cat = trim($_POST['cat']);

        if ($sub == "0" || $unit == "0" || $cat == "0") {
            $error = "All Fields are Required";
            break;
        } else if (empty(trim($_FILES['up_file']['name'][$i]))) {
            $error = "Please upload a valid file";
            break;
        } else if ($_FILES['up_file']['size'][$i] > 40000000 || $_FILES['up_file']['size'][$i] <= 0) {

            $error  .=  "File name : " . $_FILES['up_file']['name'][$i] . " <br>";
        } else {


            $file_name = "";
            $path_name = "./upload/" . $sub . "/unit-" . $unit . "/" . $cat;
            $real_name = "";
            $exten = "";
            split_with_extension_name($f_name, $real_name, $exten);
            // echo "<br> realname =$real_name";
            // echo" <br> fanem = ".$f_name; 
            // echo "<br> exten = " . $exten;
            // echo "<br>"; 
            //check if file  file extension  is valid 
        
            //    echo "arr is set " .$file_extension_arr[$exten] ;
            //    echo "<br> is set return ".isset($file_extension_arr[$exten])."<br>"; 
            if (isset($file_extension_arr[$exten])  ) {
                // echo "file extesn set " . $file_extension_arr[$exten];
                $error .= "Not able to upload  File name = '$f_name'<br>";
            } else {
                // echo "file exten not set ";
        

                // $conn = new mysqli("localhost", "root", "", "my_db") or die("Not able to connect");

                $table_name = "topic";
                $sql = "SElECT count(*) FROM " . $table_name;
                $result = $conn->query($sql);

                //create table  topic if not exists 
                // echo '<pre>'.print_r($result).'</pre>'; 
                // echo  '<br>connection error is:'.$conn->error."end";
                if ($result == "") {
                    // echo "<br>creating table table not existt ";
                    $sql = "CREATE table  $table_name ( topic_name varchar(100) ,unit varchar(10))";
                    $result = $conn->query($sql);
                    // if ($result != "") {
                    //     echo "<br>created table " . $table_name . " successfulll<br>";
                    // } else {
                    //     echo "<br>not created table<br>";
                    // }
                }
                $table_name = $sub . $unit;
                //create table sub+unit if not exist
                $sql = "SElECT count(*) FROM " . $table_name;
                $result = $conn->query($sql);
                // if ($result == "" && $conn->error == "Table 'my_db." . $table_name . "' doesn't exist") {
                if ($result == "") {
                    $sql = "CREATE table  $table_name ( cat varchar(100) , path_name varchar(300))";
                    $result = $conn->query($sql);
                    // if ($result != "") {
                    //     // echo "created table " . $table_name . " successfulll<br>";
                    // } else {
                    //     // echo "not created table<br>";
                    // }
                }


                //insert into table topic
                $sql = "SELECT * FROM  topic where (topic_name='$sub' and unit='$unit')";

                $result = $conn->query($sql);
                // echo '<pre>';
                // echo "<br><br>$sql";
                // print_r($result);
                // echo '</pre>';
                if ($result->num_rows === 0) {
                    $sql = "INSERT into topic values( '$sub','$unit')";
                    $result = $conn->query($sql);
                    // echo "<br>result of insert new in topic ";
                    // print($result);
                }
                // insert into sub 

                $sql = "SELECT * FROM  $table_name where (cat='" . $cat . "' AND path_name='" . $path_name . "/$real_name.$exten" . "')";
                $result = $conn->query($sql);
                $file_name  = "$real_name.$exten";

                if ($result->num_rows != 0) {

                    $count = 0;
                    while ($result->num_rows != 0) {
                        $count++;
                        $sql = "SELECT * FROM  $table_name where (cat='" . $cat . "' AND path_name='" . $path_name . "/$real_name(" . $count . ").$exten')";
                        // echo "<br>$sql";
                        $result = $conn->query($sql);
                        // echo "<br> count = " . $count;
                        // echo "--";
                        // print_r($result);
                        // echo "--";
                    }
                    $file_name  = $real_name . "(" . $count . ").$exten";
                    // echo "<br>----->$file_name";
                }

                $sql = "INSERT into $table_name values( '" . $cat . "','" . $path_name . "/$file_name')";

                // echo "<br>$sql";
                $result = $conn->query($sql);
                // if ($result != "") {
                //     echo "<br>result of insert new in topic ";
                // }
                // print_r($result);
                if (file_exists($path_name) == false || is_dir($path_name) == false) {
                    mkdir($path_name, 0777, true);
                    // if (is_dir($path_name)) {
                    //     // echo  "this is directoryu ";
                    // } else {
                    //     echo "<br>this is not directory";
                    // }
                    // echo "<br> created new path ";
                }

                // echo "<br>file name si: " . $file_name;
                if (move_uploaded_file($f_temp_name, $path_name . "/" . $file_name)) {
                    $sucess .=  "File name : '$file_name' <br>";;
                    $no_of_file_uploaded++;

                    // unset($_FILES);
                } else {
                    $error .= "Not able to upload  File name = $file_name<br>";
                    $error .= "because " . $conn->error;
                }
            }
        }
    }
    $conn->close();
    // echo "result is"; 
    // print_r($result); 
    // echo "<br>conect error = " . $conn->error;
    if ($sucess != "") {
        $sucess  = "Uploaded $no_of_file_uploaded  Files Successfully<hr>" . $sucess;
    }
    if ($error != "") {

        if ($error != "All Fields are Required" && $error != "Please upload a valid file") {
            $error = "Error uploading " . ($no_of_file - $no_of_file_uploaded) . " Files <hr> " . $error;
        }
    }
}
// else {
//     echo "<h1>not set nay files </h1>";
// }



?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">

    <title>Upload Document</title>
</head>
<style>
    body {
        /* background-color: brown; */
        background-color: rgb(234, 230, 241);
        font-size: 20px;
        margin: 0px;
        padding: 0px;
        font-family: "Helvetica";

        /* color:white; */
    }

    input {
        background-color: rgb(114, 14, 14);
        color: white;
    }

    #form_boundary {
        width: 65%;
        /* width:500px; */
        margin: auto;
        /* background-color:green; */
        /* margin:100px; */
        padding-bottom: 50px;
        padding-top: 20px;
        word-break: break-all;

    }


    .box {
        border: rgb(212, 199, 199) solid 1px;
        border-radius: 5px;
        background-color: white;
        margin: 20px;
        padding: 12px;
        /* height: 100px; */

    }

    header {
        padding: 20px;
        margin-top: 0px;
        border-radius: 5px;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;

        background-color: #fff;
        /* font-weight: 700; */
        font-size: 30px;
        /* text-align: center; */



    }

    p {
        font-size: 15px;
        /* font-weight: bo; */
    }

    select {
        width: 50%;
        padding: 2px;
        /* border-radius:2px; */
        /* font-size: 10px; */
        /* background-color: rgb(223, 223, 247); */
    }

    #head {
        /* padding-top:10px; */
        background-color: rgb(15, 15, 168);
        /* margin-top:38px; */
        /* font-size:20px; */
        padding: 8px 0px 0px 0px;
    }

    button {
        border: 0px solid transparent;
        border-radius: 4px;
        /* width:40%; */
        padding: 8px 40px;
        font-weight: 500px;
        color: white;
        background-color: rgb(45, 45, 197);

    }

    button:hover {
        background-color: rgb(86, 86, 219);

    }

    #sub_but,
    #logout_but,
    #del_but {
        margin: 0px 20px;
    }

    #logout_box {
        display: inline-block;

    }

    input {
        font-size: 20px;
        /* color:black; */
    }

    .file_name {
        /* background-color: blue; */

        background-color: rgb(212, 212, 230);
        padding: 2px 10px;
    }

    #message {
        padding: 23px;
    }


    #conform_box_content {
        width: 500px;
        /* border:2px solid yellow;  */
        margin: auto;



    }

    #conform_box {
        word-break: keep-all;
        border: 1px solid black;
        position: fixed;
        width: 500px;
        /* z-index: 1;; */
        padding: 20px 10px;

        top: -200px;

        color: white;
        background-color: rgba(0, 0, 0, 0.8);
        transition: 0.5s;

        margin: auto;

    }

    @media screen and (min-width:1200px) {
        #main_box {
            width: 1124px;
            margin: auto;
        }

    }


    @media screen and (max-width:900px) {
        #form_boundary {
            width: 95%;
            /* background-color: blue; */
        }

        select {
            width: 80%;
            padding: 2px;
            /* border-radius:2px; */
            /* font-size: 10px; */
            /* background-color: rgb(223, 223, 247); */
        }



        header {
            font-size: 25px;
        }

        #button_box {
            text-align: center;
        }

        #sub_but,
        #logout_but,
        #del_but {
            width: 92%;
            margin: 10px;
            /* position: relative; */

        }

        #inp_but {
            width: 100%;
        }

    }

    @media screen and (max-width:600px) {
        #form_boundary {
            width: 97%;
            /* background-color: blue; */
        }

        select {
            width: 90%;
            padding: 2px;
            /* border-radius:2px; */
            /* font-size: 10px; */
            /* background-color: rgb(223, 223, 247); */
        }

        header {
            font-size: 20px;
        }

        #button_box {
            text-align: center;
        }

        #sub_but,
        #logout_but,
        #del_but {
            width: 92%;
            margin: 10px;
            /* position: relative; */

        }

        #inp_but {
            width: 100%;
        }
    }

    @media screen and (max-width:400px) {
        #form_boundary {
            width: 97%;
            /* background-color: blue; */
        }

        select {
            width: 96%;
            padding: 2px;
            /* border-radius:2px; */
            /* font-size: 10px; */
            /* background-color: rgb(223, 223, 247); */
        }

        header {
            font-size: 15px;
        }

        #button_box {
            text-align: center;

        }

        #sub_but,
        #logout_but,
        #del_but {
            width: 83%;
            margin: 10px;
            /* position: relative; */

        }

        #inp_but {
            width: 100%;
        }
    }
</style>

<body>


    <div id="conform_box_content">
        <div id="conform_box">
            <p id="conform_mess"> Uploading...</p>

        </div>

    </div>

    <div id="main_box">

        <div id="form_boundary">

            <form id="form" action="" method="POST" enctype="multipart/form-data">


                <div id="head" class="box">
                    <header> Upload Documents
                        <hr>
                    </header>
                </div>
                <div id="message" class="box" <?php
                                                if ($error != "") {
                                                    echo '  >  <p style="color:red ;font-size:20px;">' . $error . '</p>';
                                                }
                                                if ($error == "" && $sucess != "") {
                                                    echo ">";
                                                }
                                                if ($sucess != "") {
                                                    echo '    <p style="color:green ;font-size:20px;">' . $sucess . '</p>';
                                                } else if ($error == "" && $sucess == "") {
                                                    echo 'style="display:none;">';
                                                }

                                                ?> </div> <div class="box">
                    <p>Topic *</p>

                    <select name="subject" id="subject">
                        <option selected hidden value="0"> Select </option>
                        <option value="ds">Data Structure and Algorithms</option>
                        <option value="de">Digital Electronics</option>
                        <option value="ppl">Principles of Programming Languages</option>
                        <option value="math">Mathamatics</option>
                        <option value="os">Operating System</option>

                    </select>
                </div>
                <div class="box">
                    <p>Unit *</p>

                    <select name="unit" id="unit">
                        <option value="0" hidden selected>Select </option>
                        <option value="1">UNIT-1</option>
                        <option value="2">UNIT-2</option>
                        <option value="3">UNIT-3</option>
                        <option value="4">UNIT-4</option>
                        <option value="5">UNIT-5</option>
                        <option value="6">PRACTICAL</option>
                    </select>
                </div>
                <div class="box">

                    <p>Category * </p>
                    <select name="cat" id="cat">
                        <option value="0" hidden> Select </option>
                        <option value="note">Notes</option>
                        <option value="book">Books</option>
                        <option value="qp">Question </option>
                        <option value="vd">Videos </option>
                    </select>

                </div>
                <div class="box">

                    <p>Select Files *</p>

                    <br>
                    <button type="button" id="inp_but" onclick="test_fun()"> Add Files</button>


                    <input type="file" name="up_file[]" id="up_file_but" multiple onchange="show_name()" hidden>
                    <div id="file_name">
                        <p class="file_name">No File Selected</p>

                    </div>


                </div>



                <div id="button_box">
                    <button id="sub_but" type="submit" name="submit" value="true"> Submit</button>
                    <button id="del_but" type="submit" name="delete" value="true"> Delete</button>
                    <button id="logout_but" type="submit" name="logout" value="true"> Logout</button>
                </div>


            </form>


        </div>

    </div>
    <script>
        var inp_but = document.getElementById("inp_but");
        var upfile_but = document.getElementById("up_file_but");
        var file_name = document.getElementById("file_name");
        var message = document.getElementById("message");
        var sub_but = document.getElementById("sub_but");
        var del_but = document.getElementById("del_but");
        var conform_box = document.getElementById("conform_box");
        var conform_mess = document.getElementById("conform_mess");
        var form = document.getElementById("form");





        function test_fun() {



            upfile_but.click();
            // file_name.textContent = "No File Selected<hr>No File Selected";
            file_name.innerHTML = "<p class='file_name' >  No Files Selected  <p>";
        }

        del_but.addEventListener("click", function() {
            //   console.log(up_file_but.files.length);
            upfile_but.files.value = null;
            //   console.log(up_file_but.files.length);
        });
        sub_but.addEventListener("click", function() {
            document.body.style.cursor = "progress";
            conform_box.style.top = "20%";
            form.style.display = "none";

        })

        // conform_box.style.top = "20%";
        function show_name() {


            if (up_file_but.files != null) {

                var count = up_file_but.files.length;
                var str_name = "";
                var total_size = 0;
                for (var i = 0; i < count; i++) {

                    if (up_file_but.files.item(i) != null && up_file_but.files.item(i).name != null) {
                        if (up_file_but.files.item(i).size > 40000000) {
                            str_name += "<p class='file_name' style='background-color:red; color:white'>" + up_file_but.files.item(i).name + " -- Too large file  <p>";
                        } else if (up_file_but.files.item(i).size <= 0) {
                            str_name += "<p class='file_name' style='background-color:red ;color:white'>" + up_file_but.files.item(i).name + " --Too small file  <p>";
                        } else {
                            str_name += "<p class='file_name' >" + up_file_but.files.item(i).name + " <p>";
                        }
                        total_size += up_file_but.files.item(i).size;
                    }

                }
                if (total_size > 40000000) {
                    str_name += "<p class='file_name' style='background-color:red ;color:white' >Warning: Total File size : " + total_size + "Bytes. Sum of file size must   be smaller than 40000000Bytes or 40MB for Succesfull upload. <p>";
                }
                file_name.innerHTML = str_name;
                conform_mess.textContent = " Uploading " + count + " Files. Please wait ....";
                //  console.log(upfile_but.value);
            }

        }

        setTimeout(() => {
            message.style.display = "none";

        }, 30000);
    </script>
</body>

</html>