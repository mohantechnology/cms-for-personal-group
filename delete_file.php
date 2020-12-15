<?php
session_start();
include "user_password.php"; 
if ((!isset($_SESSION["admin_ps"])) ||   $_SESSION["admin_ps"] != $user_password) {
    unset($_POST);
    unset($_FILES);
    unset($_SESSION["admin_ps"]);
    header("Location: ./login.php");
}
$str = '
<!DOCTYPE html>
<html lang="en">

<head>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Delete Documents</title>
    <meta name="description" content="Documents">

</head>
<style>
    body {
        /* background-color: brown; */
        background-color: rgb(234, 230, 241);
        font-size: 20px;
        margin: 0px;
        padding: 0px;
        font-family: "Helvetica";
        word-break: keep-all;

        /* color:white; */
    }


    ol a li {
        padding: 4px;
        font-size: 15px;
        text-align: left;
        /* margin:23px; */


    }

    ol  li:hover {

        background: linear-gradient(to right, red, red, red, whitesmoke);
        color: GREY;
        /* border:0    px solid black; */
        width: 90%;
        cursor:pointer; 
    }


    #form_boundary {
        width: 65%;
        /* width:500px; */
        margin: auto;
        /* background-color:green; */
        /* margin:100px; */
        padding-bottom: 50px;
        padding-top: 20px;

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
        font-size: 30px;
    }

    p {
        font-size: 15px;
        padding-left: 10px;
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


    #head {

        background-color: rgb(15, 15, 168);

        padding: 8px 0px 0px 0px;
    }

    #back_but {
        margin-left: 20px;
    }

#conform_box_content{
 width:500px; 

    margin:auto ;
 

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
        /* font-size:200px; */
        margin:auto;

    }


    #conform_but {
        text-align: right;
    }

    #yes_but:hover {
        background-color: red;
    }

    #no_but:hover {
        background-color: green;
    }


   


    @media screen and (min-width:1200px) {
        #main_box{
          width:1124px; 
          margin:auto; 
        }
  
 }


    @media screen and (max-width:900px) {
        #form_boundary {
            width: 95%;
            /* background-color: blue; */
        }


        header {
            font-size: 25px;
        }

        #back_but {
            margin: 20px;
            width: 94%;

        }
        #conform_box{
            width:60%; 
            left:17%;
         }


    }

    @media screen and (max-width:600px) {
        #form_boundary {
            width: 97%;
            /* background-color: blue; */
        }


        header {
            font-size: 20px;
        }

        #back_but {
            margin: 20px;
            width: 90%;

        }


    }


    @media screen and (max-width:400px) {
        #form_boundary {
            width: 97%;
            /* background-color: blue; */
        }




        header {
            font-size: 15px;
        }

        #back_but {
            margin: 20px;
            width: 84%;

        }

     #yes_but,#no_but{
         padding:10px 20px;
     }

   


    }
</style>

<body>

    <div id="conform_box_content">
        <div id="conform_box">
            <p id="conform_mess"> Are you sure you want to delete permanently this file?</p>

            <div id="conform_but">
                <button id="yes_but"> Yes </button>
                <button id="no_but"> No </button>
            </div>
        </div>

    </div>

    <div id="main_box">
    <div id="form_boundary">

        <form action="" method="GET" enctype="multipart/form-data">
'; ?>



<?php
//  echo "$str";
// echo "start ing sesion"; 
// echo '<pre>';
// print_r($_SESSION); 
// echo '</pre>';

if ((!isset($_SESSION['admin_del'])) ||  $_SESSION['admin_del'] != "admin") {

    // echo "delete is set"; 
    // header("Location: ./login.php");
    header("Location: ./upload_file.php");
}

if (isset($_GET["back"]) && $_GET["back"] == "true") {
    unset($_GET["back"]);

    header("location: select_file.php");
}

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

if (isset($_SESSION['sub']) && isset($_SESSION['unit'])) {

    $sub = trim($_SESSION['sub']);
    $unit = trim($_SESSION['unit']);
    $topic_name = "";
    $table_name = "";

    if ($sub == "0" || $unit == "0" || empty($sub) || empty($unit)) {

        header("location:./ssipmt.php");
    } else {


        echo $str;
        $table_name = $sub . $unit;
        if ($sub == "os") {
            $topic_name = "Operating System";
        } else if ($sub == "math") {
            $topic_name = "Mathamatics";
        } else if ($sub == "ppl") {
            $topic_name = "Principles of Programming Languages";
        } else if ($sub == "de") {
            $topic_name = "Digital Electronics";
        } else if ($sub == "ds") {
            $topic_name = "Data Structure and Algorithms";
        }
        // echo "<br>sub= $topic_name";
        // echo "<br> table name = " . $table_name;



        include "password.php";
        // $conn = new mysqli("localhost", "root", "", "my_db") or die("Not able to connect");
        $temp_str = $unit == "6" ? "practical" : "unit-&nbsp;" . $unit;
        echo ' <div id="head" class="box"> <header> ' . $topic_name . "&nbsp; ($temp_str) <hr></header></div>";

     
        echo "<div id='load'> <p style='text-align:center;'> Loading... </p>  </div>";
    }

    $conn->close();
} else {
    // header("location:ssipmt.php");
}



?>
<button id="back_but" type="submit" name="back" value="true"> Back</button></a>
</div>
</form>


<script>
    var conform_box = document.getElementById("conform_box");
    var conform_mess = document.getElementById("conform_mess");
    var load = document.getElementById("load");
    var yes_but = document.getElementById("yes_but");
    var no_but = document.getElementById("no_but");
    // load.style.display = "none";

    var parameter = "";

    function beforesend() {

    }

    yes_but.addEventListener("click", function() {
        conform_box.style.top = "-200px"; 
        if (parameter != "") {
            document.getElementById("load").innerHTML = "<p style='text-align:center;'> Loading... </p> ";
            send_xhttp_request(parameter);

        }
        parameter = "";
    });

    no_but.addEventListener("click", function() {
        conform_box.style.top = "-200px"
    });


    function send_xhttp_request(param = "") {
        var xhttp = new XMLHttpRequest();

        xhttp.open("post", "delete_request.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("load").innerHTML = xhttp.responseText;
                // console.log("loaded new data");
            }
        };

        <?php if (isset($_SESSION['sub']) && isset($_SESSION['unit'])) {

            $sub = trim($_SESSION['sub']);
            $unit = trim($_SESSION['unit']);
            $topic_name = "";
            $table_name = "";

            if ($sub == "0" || $unit == "0" || empty($sub) || empty($unit)) {

                header("location:./ssipmt.php");
            } else {
                echo "var  data = 'sub=$sub&unit=$unit';";
            }
        }
        echo "xhttp.send(data +param);";
        ?>



    }
    
    // console.log(conform_box.children[0]); 

    document.addEventListener("click", function(e) {
        
      
        // console.log(e.target.tagName);
        if (e.target.tagName == "LI") {
            var param = "&delete=1&cat=" + e.target.getAttribute('name') + "&" + "path_name=" + e.target.getAttribute('value');
            // console.log(e.target.textContent);
            conform_mess.textContent=" Are you sure you want to delete permanently '"+ e.target.textContent+"' file? " ;
            conform_box.style.top = "20%";
            
            parameter = param;
        }
    });



 send_xhttp_request("&delete=0");
</script>
</body>

</html>