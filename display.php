<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Display Documents</title>
    <meta name="description" content="Documents">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">

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

    ol a li:hover {
        /* color:blue; */
        color: rgb(124, 98, 172);
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


    }
</style>

<body>
    <?php
    session_start();

    ?>

  <div id="main_box">
    <div id="form_boundary">


        <form action="" method="GET" enctype="multipart/form-data">
            <?php


            if (isset($_GET["back"]) && $_GET["back"] == "true") {
                unset($_GET["back"]);
                header("location:ssipmt.php");
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
                            echo "<a href='" . $row['path_name'] . "' download ><li>" . $temp_name . "</li></a>";
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
                            echo "<a href='" . $row['path_name'] . "' download ><li>" . $temp_name . "</li></a>";
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
                            echo "<a href='" . $row['path_name'] . "' download ><li>" . $temp_name . "</li></a>";
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
                            $prefix = "--external--";
                            $file_name=$temp_name; 
                            $len1 = strlen($prefix);
                            $len2 = strlen($file_name);
                            $i = 0;
                            for (; $i < $len1 && $len1 < $len2; $i++) {
                                if ($prefix[$i] != $file_name[$i]) {
                                    break;
                                }
                            }
                        
                            if ($i == $len1 && file_exists($row['path_name'])) {
                                //file contain url of youtube
                                $fh = fopen($row['path_name'], "r");
                                if ($fh != false && $line = fgets($fh)) {
                                    echo "<a href='" . $line . "'  ><li>" . $temp_name . "</li></a>";
                                }
                                fclose($fh);
                            } else {
                                echo "<a href='" . $row['path_name'] . "'  ><li>" . $temp_name . "</li></a>";
                            }
                        }
                        echo '</ol>  </div>';
                    }
                }
                $conn->close();
            } else {
                header("location:ssipmt.php");
            }



            ?>
            <button id="back_but" type="submit" name="back" value="true"> Home</button></a>


        </form>




        </div> 
     </body>

</html>