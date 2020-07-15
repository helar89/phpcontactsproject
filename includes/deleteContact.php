<?php
  /*
    Name:   Group 12
    Date:   05th December, 2019
    Purpose: Project 2 - Contacts (deleteContact.php)
    Students: Ahmed Elkhafif - 0725778,
              Cicero Raldi da Fonseca - 0898946, 
              Claudio Roberto Alves de Souza Filho - 0907588,
              Helar Duran - 0896897
  */
?>

<?php
    require_once("./includes/db_connection.php");    
?>

<?php

    function confirmDeleteContact() {
        
        if (isset($_POST['list_select'])) {
            $_SESSION['list_select'] = $_POST['list_select'];
            
            $db_conn = connectDB();
            if (!$db_conn){
                echo "<p>Error connecting to the database</p>\n";
            } else {
                $stmt = $db_conn->prepare("select ct_id, ct_disp_name from contact where ct_id = :id;");
                if (!$stmt){
                    echo "<p>Error preparing to read data from the database</p>\n";
                } else {
                    $data = array(":id" => $_SESSION['list_select'][0]); // => Protection against SQL injection
                    $status = $stmt->execute($data);
                    if(!$status){
                    echo "<p>Error reading data from the database</p>\n";
                    } else {
                        if ($stmt->rowCount() > 0){
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            
                            echo "<form method=\"POST\">";
                            echo "<h1>Delete Contact</h1>";
                            echo "<p>Are you sure you want to delete the contact below?</p>";
                            echo "<table border=\"1\" class=\"users\">";
                            echo "<tr><th>ID</th><th>Name</th></tr>\n";
                            echo "<tr><td>";
                            echo $row['ct_id'];
                            echo "</td><td>";
                            echo $row['ct_disp_name'];
                            echo "</td>";
                            echo "</tr>\n";
                            echo "</table><br/>";
                            ?>

                            <form method="POST">
                                <input type="submit" value="Yes" name="delete-yes" />
                                <input type="submit" value="No" name="delete-no"/>
                            </form>
                            
                            <?php
                        }
                    }
                }
            }
        }
    }

    function executeDelete() {
        if (isset($_POST['delete-yes']) && isset($_SESSION['list_select'])) {
            $db_conn = connectDB();
            if (!$db_conn){
                echo "<p>Error connecting to the database</p>\n";
            } else {
                $stmt = $db_conn->prepare("update contact set ct_deleted = 'Y' where ct_id = :id;");
                if (!$stmt){
                    echo "<p>Error preparing to read data from the database</p>\n";
                } else {
                    $data = array(":id" => $_SESSION['list_select'][0]); // => Protection against SQL injection
                    $status = $stmt->execute($data);
                    if($status) {
                        session_unset();
                    }
                }
            }
        }
    }

    
?>