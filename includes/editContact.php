<?php
  /*
    Name:   Group 12
    Date:   05th December, 2019
    Purpose: Project 2 - Contacts (editContact.php)
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

    function editContact() {
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
                            $_SESSION['contact_table'] = true;
                        }
                    }
                }
            }
        }

        if(isset($_SESSION['list_select']) && $_SESSION['contact_table'] == true) {

            $db_conn = connectDB();
            if (!$db_conn){
                echo "<p>Error connecting to the database</p>\n";
            } else {
            
                $db_conn = connectDB();
                $stmt_contact = $db_conn->prepare("select ct_id, ct_type, ct_first_name, ct_last_name, ct_disp_name, ct_created, ct_modified, ct_deleted from contact where ct_id = :id;");
                $stmt_contact_address = $db_conn->prepare("select ad_id, ad_ct_id, ad_type, ad_line_1, ad_line_2, ad_line_3, ad_city, ad_province, ad_post_code, ad_country, ad_active, ad_created, ad_modified from contact_address where ad_ct_id = :id;");
                $stmt_contact_email = $db_conn->prepare("select em_id, em_ct_id, em_type, em_email, em_active, em_created, em_modified from contact_email where em_ct_id = :id;");
                $stmt_contact_note = $db_conn->prepare("select no_id, no_ct_id, no_type, no_note, no_created, no_modified from contact_note where no_ct_id = :id;");
                $stmt_contact_phone = $db_conn->prepare("select ph_id, ph_ct_id, ph_type, ph_number, ph_active, ph_created, ph_modified from contact_phone where ph_ct_id = :id;");
                $stmt_contact_web = $db_conn->prepare("select we_id, we_ct_id, we_type, we_url, we_active, we_created, we_modified from contact_web where we_ct_id = :id;");
                
                //CONTACT TABLE
                if (!$stmt_contact){
                    echo "<p>Error preparing to read data from the database</p>\n";
                } else {
                    $data = array(":id" => $_SESSION['list_select'][0]); // => Protection against SQL injection
                    $status = $stmt_contact->execute($data);
                    if(!$status){
                        echo "<p>Error reading data from the database</p>\n";
                    } else {
                        if ($stmt_contact->rowCount() > 0){
                            //CONTACT TABLE
                            $row = $stmt_contact->fetch(PDO::FETCH_ASSOC);
                            $_SESSION['ct_type'] = $row['ct_type'];
                            $_SESSION['ct_first_name'] = $row['ct_first_name'];
                            $_SESSION['ct_last_name'] = $row['ct_last_name'];
                            $_SESSION['ct_disp_name'] = $row['ct_disp_name'];
                        }
                    }
                }

                //CONTACT_ADDRESS TABLE
                if (!$stmt_contact_address){
                    echo "<p>Error preparing to read data from the database</p>\n";
                } else {
                    $data = array(":id" => $_SESSION['list_select'][0]); // => Protection against SQL injection
                    $status = $stmt_contact_address->execute($data);
                    if(!$status){
                        echo "<p>Error reading data from the database</p>\n";
                    } else {
                        if ($stmt_contact_address->rowCount() > 0){
                            $_SESSION['contact_address_table'] = true;
                            $row = $stmt_contact_address->fetch(PDO::FETCH_ASSOC);
                            $_SESSION['ad_type'] = $row['ad_type'];
                            $_SESSION['ad_line_1'] = $row['ad_line_1'];
                            $_SESSION['ad_type_2'] = $row['ad_line_2'];
                            $_SESSION['ad_type_3'] = $row['ad_line_3'];
                            $_SESSION['ad_city'] = $row['ad_city'];
                            $_SESSION['ad_province'] = $row['ad_province'];
                            $_SESSION['ad_post_code'] = $row['ad_post_code'];
                            $_SESSION['ad_country'] = $row['ad_country'];
                        }
                    }
                }

                //CONTACT PHONE TABLE
                if (!$stmt_contact_phone){
                    echo "<p>Error preparing to read data from the database</p>\n";
                } else {
                    $data = array(":id" => $_SESSION['list_select'][0]); // => Protection against SQL injection
                    $status = $stmt_contact_phone->execute($data);
                    if(!$status){
                        echo "<p>Error reading data from the database</p>\n";
                    } else {
                        if ($stmt_contact_phone->rowCount() > 0){
                            $_SESSION['contact_phone_table'] = true;
                            $row = $stmt_contact_phone->fetch(PDO::FETCH_ASSOC);

                            $_SESSION['ph_type'] = $row['ph_type'];
                            $_SESSION['ph_number'] = $row['ph_number'];
                        
                        }
                    }
                }

                //CONTACT EMAIL TABLE
                if (!$stmt_contact_email){
                    echo "<p>Error preparing to read data from the database</p>\n";
                } else {
                    $data = array(":id" => $_SESSION['list_select'][0]); // => Protection against SQL injection
                    $status = $stmt_contact_email->execute($data);
                    if(!$status){
                        echo "<p>Error reading data from the database</p>\n";
                    } else {
                        if ($stmt_contact_email->rowCount() > 0){
                            $_SESSION['contact_contact_email'] = true;
                            $row = $stmt_contact_email->fetch(PDO::FETCH_ASSOC);

                            $_SESSION['em_type'] = $row['em_type'];
                            $_SESSION['em_email'] = $row['em_email'];
                        
                        }
                    }
                }

                    

                //CONTACT WEB TABLE
                if (!$stmt_contact_web){
                echo "<p>Error preparing to read data from the database</p>\n";
                } else {
                    $data = array(":id" => $_SESSION['list_select'][0]); // => Protection against SQL injection
                    $status = $stmt_contact_web->execute($data);
                    if(!$status){
                        echo "<p>Error reading data from the database</p>\n";
                    } else {
                        if ($stmt_contact_web->rowCount() > 0){
                            $_SESSION['contact_contact_web'] = true;
                            $row = $stmt_contact_web->fetch(PDO::FETCH_ASSOC);

                            $_SESSION['we_type'] = $row['we_type'];
                            $_SESSION['we_url'] = $row['we_url'];

                            
                        }
                    }
                }

                //CONTACT NOTE TABLE
                if (!$stmt_contact_note){
                    echo "<p>Error preparing to read data from the database</p>\n";
                } else {
                    $data = array(":id" => $_SESSION['list_select'][0]); // => Protection against SQL injection
                    $status = $stmt_contact_note->execute($data);
                    if(!$status){
                        echo "<p>Error reading data from the database</p>\n";
                    } else {
                        if ($stmt_contact_note->rowCount() > 0){
                            $_SESSION['contact_contact_note'] = true;
                            $row = $stmt_contact_note->fetch(PDO::FETCH_ASSOC);

                            $_SESSION['no_note'] = $row['no_note'];
                            
                        
                        }
                    }
                }
            }
        }
    }

    function updateContact() {
        
        $db_conn = connectDB();
        if (!$db_conn){
            echo "<p>Error connecting to the database</p>\n";
        } else {
        
            $db_conn = connectDB();
            
            // Update 'contact' Table
            $stmt_upd_contact = $db_conn->prepare('UPDATE contact SET ct_type = ?, ct_first_name = ?, ct_last_name = ?, ct_disp_name = ? WHERE ct_id = ?');
            if (!$stmt_upd_contact){
                echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                exit(1);
            }
            $data = array($_SESSION['ct_type'], $_SESSION['ct_first_name'],  $_SESSION['ct_last_name'], $_SESSION['ct_disp_name'], $_SESSION['list_select'][0]);
            $status = $stmt_upd_contact->execute($data);
            if(!$status){
                echo "<p>Error ".$stmt_upd_contact->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact->errorInfo())."</p>\n";
                exit(1);
            }

            if (isset($_SESSION['contact_address_table']) && $_SESSION['contact_address_table'] == true) {
                // Update 'contact_address' Table
                $stmt_upd_contact_address = $db_conn->prepare('UPDATE contact_address SET ad_type = ?, ad_line_1 = ?, ad_line_2 = ?, ad_line_3 = ?, ad_city = ?, ad_province = ?, ad_post_code = ?, ad_country = ? WHERE ad_ct_id = ?;');
                if (!$stmt_upd_contact_address){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['ad_type'], $_SESSION['ad_line_1'],  $_SESSION['ad_line_2'], $_SESSION['ad_line_3'], $_SESSION['ad_city'], $_SESSION['ad_province'], $_SESSION['ad_post_code'], $_SESSION['ad_country'], $_SESSION['list_select'][0]);
                $status = $stmt_upd_contact_address->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_address->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_address->errorInfo())."</p>\n";
                    exit(1);
                }
            } else {
                // Add register to 'contact_address' Table
                $stmt_upd_contact_address = $db_conn->prepare('INSERT INTO contact_address (ad_ct_id, ad_type, ad_line_1, ad_line_2, ad_line_3, ad_city, ad_province, ad_post_code, ad_country, ad_active) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                if (!$stmt_upd_contact_address){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['list_select'][0], $_SESSION['ad_type'], $_SESSION['ad_line_1'],  $_SESSION['ad_line_2'], $_SESSION['ad_line_3'], $_SESSION['ad_city'], $_SESSION['ad_province'], $_SESSION['ad_post_code'], $_SESSION['ad_country'], 'Y');
                $status = $stmt_upd_contact_address->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_address->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_address->errorInfo())."</p>\n";
                    exit(1);
                }
            }
            
            
            
            if (isset($_SESSION['contact_phone_table']) && $_SESSION['contact_phone_table'] == true) {
                // Update 'contact_phone' Table
                $stmt_upd_contact_phone = $db_conn->prepare('UPDATE contact_phone SET ph_type = ?, ph_number = ? WHERE ph_ct_id = ?');
                if (!$stmt_upd_contact_phone){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['ph_type'], $_SESSION['ph_number'], $_SESSION['list_select'][0]);
                $status = $stmt_upd_contact_phone->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_phone->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_phone->errorInfo())."</p>\n";
                    exit(1);
                }
            } else {
                // Add register to 'contact_phone' Table
                $stmt_upd_contact_phone = $db_conn->prepare('INSERT INTO contact_phone (ph_ct_id, ph_type, ph_number, ph_active) values (?, ?, ?, ?)');
                if (!$stmt_upd_contact_phone){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['list_select'][0], $_SESSION['ph_type'],  $_SESSION['ph_number'], 'Y');
                $status = $stmt_upd_contact_phone->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_phone->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_phone->errorInfo())."</p>\n";
                    exit(1);
                }
            }

            if (isset($_SESSION['contact_contact_email']) && $_SESSION['contact_contact_email'] == true) {
                // Update 'contact_email' Table
                $stmt_upd_contact_email = $db_conn->prepare('UPDATE contact_email SET em_type = ?, em_email = ? WHERE em_ct_id = ?');            
                if (!$stmt_upd_contact_email){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['em_type'], $_SESSION['em_email'], $_SESSION['list_select'][0]);
                $status = $stmt_upd_contact_email->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_email->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_email->errorInfo())."</p>\n";
                    exit(1);
                }
            } else {
                // Add register to 'contact_email' Table
                $stmt_upd_contact_email = $db_conn->prepare('INSERT INTO contact_email (em_ct_id, em_type, em_email, em_active) values (?, ?, ?, ?)');
                if (!$stmt_upd_contact_email){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['list_select'][0], $_SESSION['em_type'],  $_SESSION['em_email'], 'Y');
                $status = $stmt_upd_contact_email->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_email->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_email->errorInfo())."</p>\n";
                    exit(1);
                }
            }

            if (isset($_SESSION['contact_contact_web']) && $_SESSION['contact_contact_web'] == true) {
                // Update 'contact_web' Table
                $stmt_upd_contact_web = $db_conn->prepare('UPDATE contact_web SET we_type = ?, we_url = ? WHERE we_ct_id = ?');
                if (!$stmt_upd_contact_web){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['we_type'], $_SESSION['we_url'], $_SESSION['list_select'][0]);
                $status = $stmt_upd_contact_web->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_web->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_web->errorInfo())."</p>\n";
                    exit(1);
                }
            } else {
                // Add register to 'contact_web' Table
                $stmt_upd_contact_web = $db_conn->prepare('INSERT INTO contact_web (we_ct_id, we_type, we_url, we_active) values (?, ?, ?, ?)');
                if (!$stmt_upd_contact_web){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['list_select'][0], $_SESSION['we_type'],  $_SESSION['we_url'], 'Y');
                $status = $stmt_upd_contact_web->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_web->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_web->errorInfo())."</p>\n";
                    exit(1);
                }
            }

            if (isset($_SESSION['contact_contact_note']) && $_SESSION['contact_contact_note'] == true) {
                // Update 'contact_note' Table
                $stmt_upd_contact_note = $db_conn->prepare('UPDATE contact_note SET no_note = ? WHERE no_ct_id = ?');
                if (!$stmt_upd_contact_note){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['no_note'], $_SESSION['list_select'][0]);
                $status = $stmt_upd_contact_note->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_note->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_note->errorInfo())."</p>\n";
                    exit(1);
                }
            } else {
                // Add register to 'contact_note' Table
                $stmt_upd_contact_note = $db_conn->prepare('INSERT INTO contact_note (no_ct_id, no_type, no_note) values (?, ?, ?)');
                if (!$stmt_upd_contact_note){
                    echo "<p>Error ".$db_conn->errorCode()."<br/>\nMessage ".implode($db_conn->errorInfo())."</p>\n";
                    exit(1);
                }
                $data = array($_SESSION['list_select'][0], "",  $_SESSION['no_note']);
                $status = $stmt_upd_contact_note->execute($data);
                if(!$status){
                    echo "<p>Error ".$stmt_upd_contact_note->errorCode()."<br/>\nMessage ".implode($stmt_upd_contact_note->errorInfo())."</p>\n";
                    exit(1);
                }
            }

            session_unset();
        }
    }


    
?>