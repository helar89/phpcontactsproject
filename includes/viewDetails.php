<?php
  /*
    Name:   Group 12
    Date:   18th October, 2019
    Purpose: Project 2 - Contacts (index.php)
    Students: Ahmed Elkhafif - 0725778,
              Cicero Raldi da Fonseca - 0898946, 
              Claudio Roberto Alves de Souza Filho - 0907588,
              Helar Duran - 0896897
  */
?>

<?php 
	require_once("./includes/db_connection.php"); 
?>

<?php function viewDetails() { ?>
<html>
<head>
  <meta charset="utf-8">
  <title>Contact List</title>
</head>
<body>
    <h1>View Contact Details</h1>
<main>
  <?php
  $db_conn = connectDB();
  if (!$db_conn){
    echo "<p>Error connecting to the database</p>\n";
  } else {
    selectContact();
    ?>
    <form method="POST" >
        <input type="submit" name="ct_b_cancel" value="Cancel">
    </form>
    <?php
  }
  ?>
  
</main>
</body>
</html>
<?php } ?>

<?php function selectContact() {
  if (isset($_POST['list_select'])) {
    $_SESSION['list_select'] = $_POST['list_select'];
    $db_conn = connectDB();
    $stmt_contact = $db_conn->prepare("select ct_id, ct_type, ct_first_name, ct_last_name, ct_disp_name, ct_created, ct_modified, ct_deleted from contact where ct_id = :id order by ct_id;");
    $stmt_contact_address = $db_conn->prepare("select ad_id, ad_ct_id, ad_type, ad_line_1, ad_line_2, ad_line_3, ad_city, ad_province, ad_post_code, ad_country, ad_active, ad_created, ad_modified from contact_address where ad_ct_id = :id order by ad_ct_id;");
    $stmt_contact_email = $db_conn->prepare("select em_id, em_ct_id, em_type, em_email, em_active, em_created, em_modified from contact_email where em_ct_id = :id order by em_ct_id;");
    $stmt_contact_note = $db_conn->prepare("select no_id, no_ct_id, no_type, no_note, no_created, no_modified from contact_note where no_ct_id = :id order by no_ct_id;");
    $stmt_contact_phone = $db_conn->prepare("select ph_id, ph_ct_id, ph_type, ph_number, ph_active, ph_created, ph_modified from contact_phone where ph_ct_id = :id order by ph_ct_id;");
    $stmt_contact_web = $db_conn->prepare("select we_id, we_ct_id, we_type, we_url, we_active, we_created, we_modified from contact_web where we_ct_id = :id order by we_ct_id;");
  
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
            echo "<table class=\"users\" width=\"600\">";
            while ($row = $stmt_contact->fetch(PDO::FETCH_ASSOC)){
              echo "<tr><th>";
              echo "<h3>Contact Information:</h3>";
              echo "</th></tr><tr><td>";
              echo "ID: " . $row['ct_id'] . "</td>";
              echo "</tr><tr><td>";
              echo "Type: " . $row['ct_type'] . "</td>";
              echo "</tr><tr><td>";
              echo "First Name: " . $row['ct_first_name'] . "</td>";
              echo "</tr><tr><tr><td>";
              echo "Last Name: " . $row['ct_last_name'] . "</td>";
              echo "</tr><tr><td>";
              echo "Display Name: " . $row['ct_disp_name'] . "</td>";
              echo "</tr><tr><td>";
              echo "Created: " . $row['ct_created'] . "</td>";
              echo "</tr><tr><td>";
              echo "Modified: " . $row['ct_modified'] . "</td>";
              echo "</tr><tr><td>";
              echo "Deleted: " . $row['ct_deleted'] . "</td>";
              echo "</tr>\n";
            }
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
          while ($row = $stmt_contact_address->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><th>";
            echo "<h3>Address Information:</h3>";
            echo "</th></tr><tr><td>";
            echo "Type: " . $row['ad_type'] . "</td>";
            echo "</tr><tr><td>";
            echo "Address Line 1: " . $row['ad_line_1'] . "</td>";
            echo "</tr><tr><td>";
            echo "Address Line 2: " . $row['ad_line_2'] . "</td>";
            echo "</tr><tr><td>";
            echo "Address Line 3: " . $row['ad_line_3'] . "</td>";
            echo "</tr><tr><td>";
            echo "City: " . $row['ad_city'] . "</td>";
            echo "</tr><tr><td>";
            echo "Province: " . $row['ad_province'] . "</td>";
            echo "</tr><tr><td>";
            echo "Postal Code: " . $row['ad_post_code'] . "</td>";
            echo "</tr><tr><td>";
            echo "Country: " . $row['ad_country'] . "</td>";
            echo "</tr><tr><td>";
            echo "Active: " . $row['ad_active'] . "</td>";
            echo "</tr><tr><td>";
            echo "Modified: " . $row['ad_modified'] . "</td>";
            echo "</tr>\n";
          }
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
          while ($row = $stmt_contact_email->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><th>";
            echo "<h3>Email Information:</h3>";
            echo "</th></tr><tr><td>";
            echo "Type: " . $row['em_type'] . "</td>";
            echo "</tr><tr><td>";
            echo "Email: " . $row['em_email'] . "</td>";
            echo "</tr><tr><td>";
            echo "Active: " . $row['em_active'] . "</td>";
            echo "</tr><tr><td>";
            echo "Modified: " . $row['em_modified'] . "</td>";
            echo "</tr>";
          }
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
          while ($row = $stmt_contact_note->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><th>";
            echo "<h3>Note Information:</h3>";
            echo "</th></tr><tr><td>";
            echo "Type: " . $row['no_type'] . "</td>";
            echo "</tr><tr><td>";
            echo "Note: " . $row['no_note'] . "</td>";
            echo "</tr><tr><td>";
            echo "Modified: " . $row['no_modified'] . "</td>";
            echo "</tr>";
          }
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
          while ($row = $stmt_contact_phone->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><th>";
            echo "<h3>Phone Information:</h3>";
            echo "</th></tr><tr><td>";
            echo "Type: " . $row['ph_type'] . "</td>";
            echo "</tr><tr><td>";
            echo "Number: " . $row['ph_number'] . "</td>";
            echo "</tr><tr><td>";
            echo "Active: " . $row['ph_active'] . "</td>";
            echo "</tr><tr><td>";
            echo "Modified: " . $row['ph_modified'] . "</td>";
            echo "</tr>";
          }
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
          while ($row = $stmt_contact_web->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><th>";
            echo "<h3>Web Information:</h3>";
            echo "</th></tr><tr><td>";
            echo "Type: " . $row['we_type'] . "</td>";
            echo "</tr><tr><td>";
            echo "URL: " . $row['we_url'] . "</td>";
            echo "</tr><tr><td>";
            echo "Active: " . $row['we_active'] . "</td>";
            echo "</tr><tr><td>";
            echo "Modified: " . $row['we_modified'] . "</td>";
            echo "</tr>";
          }
          echo "</tbody></table>\n<br/><br/>\n";
        }
      }
    }
  }
}
?>
