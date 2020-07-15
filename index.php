<?php
  /*
    Name:   Group 12
    Date:   05th December, 2019
    Purpose: Project 2 - Contacts (index.php)
    Students: Ahmed Elkhafif - 0725778,
              Cicero Raldi da Fonseca - 0898946, 
              Claudio Roberto Alves de Souza Filho - 0907588,
              Helar Duran - 0896897
  */
?>
<?php 
	session_start(); 
	if (!isset($_SESSION['mode'])){
		$_SESSION['mode'] = "Display";
	}
	require_once("./includes/db_connection.php"); 
	require_once("./includes/displayContacts.php"); 
	require_once("./includes/formContactType.php");
	require_once("./includes/formContactName.php");
	require_once("./includes/formContactAddress.php");
	require_once("./includes/formContactPhone.php");
	require_once("./includes/formContactEmail.php");
	require_once("./includes/formContactWeb.php");
	require_once("./includes/formContactNote.php");
	require_once("./includes/formContactSave.php");
	require_once("./includes/clearAddContactFromSession.php");
    require_once("./includes/displayErrors.php");
    require_once("./includes/deleteContact.php");
    require_once("./includes/viewDetails.php");
    require_once("./includes/editContact.php");
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Contact List - Project 2</title>
        <link rel="stylesheet" href="./css/main.css">
	</head>
	<body>
<?php
if (isset($_POST['ct_b_add']) && ($_POST['ct_b_add'] == "Add New Contact")){
	$_SESSION['mode'] = "Add";
	$_SESSION['add_part'] = 0;
} else if ((isset($_POST['ct_b_edit']) && ($_POST['ct_b_edit'] == "Edit"))  || 
                (isset($_POST['save_edit']) && ($_POST['save_edit'] == "Save"))) {
    $_SESSION['mode'] = "Edit";
    $_SESSION['edit_part'] = 0;
} else if ((isset($_POST['ct_b_delete']) && ($_POST['ct_b_delete'] == "Delete")) || 
                (isset($_POST['delete-yes']) && ($_POST['delete-yes'] == "Yes"))){
    $_SESSION['mode'] = "Delete";
} else if (isset($_POST['ct_b_view_details']) && ($_POST['ct_b_view_details'] == "View Details")){
	$_SESSION['mode'] = "View";
} else if (isset($_POST['ct_b_cancel']) && ($_POST['ct_b_cancel'] == "Cancel")){
	if ($_SESSION['mode'] == "Add" || $_SESSION['mode'] == "Edit"){
        $_SESSION['add_part'] = 0;
		clearAddContactFromSession();
	}
	$_SESSION['mode'] = "Display";
}

if(($_SESSION['mode'] == "Add") && ($_SERVER['REQUEST_METHOD'] == "GET")){ 
	switch ($_SESSION['add_part']) {
		case 0:
		case 1:
			formContactType();
			break;
		case 2:
			formContactName();
			break;
		case 3:
			formContactAddress();
			break;
		case 4:
			formContactPhone();
			break;
		case 5:
			formContactEmail();
			break;
		default:
	}
} else if($_SESSION['mode'] == "Add"){ 
	switch ($_SESSION['add_part']) {
		case 0:
			echo "<h1> Add New Contact </h1>\n";
			$_SESSION['add_part'] = 1;
			formContactType();
			break;
		case 1:
			echo "<h1> Add New Contact </h1>\n";
			$err_msgs = validateContactType();
			if (count($err_msgs) > 0){
				displayErrors($err_msgs);
				formContactType();
			} else {
				contactTypePostToSession();
				$_SESSION['add_part'] = 2;
				formContactName();
			}
			break;
		case 2:
			echo "<h1> Add New Contact </h1>\n";
			$err_msgs = validateContactName();
			if (count($err_msgs) > 0){
				displayErrors($err_msgs);
				formContactName();
			} else if ((isset($_POST['ct_b_next']))
					&& ($_POST['ct_b_next'] == "Next")){
				contactNamePostToSession();
				$_SESSION['add_part'] = 3;
				formContactAddress();
			} else if ((isset($_POST['ct_b_back']))
						&& ($_POST['ct_b_back'] == "Back")){
				contactNamePostToSession();
				$_SESSION['add_part'] = 1;
				formContactType();
			}
			break;
		case 3:
			echo "<h1> Add New Contact </h1>\n";
			$err_msgs = validateContactAddress();
			if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
				displayErrors($err_msgs);
				formContactAddress();
			} else if (isset($_POST['ct_b_skip'])){
				$_SESSION['add_part'] = 4;
				formContactPhone();
			} else if ((isset($_POST['ct_b_next']))
					&& ($_POST['ct_b_next'] == "Next")){
				contactAddressPostToSession();
				$_SESSION['add_part'] = 4;
				formContactPhone();
			} else if ((isset($_POST['ct_b_back']))
						&& ($_POST['ct_b_back'] == "Back")){
				contactAddressPostToSession();
				$_SESSION['add_part'] = 2;
				formContactName();
			}
			break;
		case 4:
			echo "<h1> Add New Contact </h1>\n";
			$err_msgs = validateContactPhone();
			if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
				displayErrors($err_msgs);
				formContactPhone();
			} else if (isset($_POST['ct_b_skip'])){
				$_SESSION['add_part'] = 5;
				formContactEmail();
			} else if ((isset($_POST['ct_b_next']))
					&& ($_POST['ct_b_next'] == "Next")){
				contactPhonePostToSession();
				$_SESSION['add_part'] = 5;
				formContactEmail();
			} else if ((isset($_POST['ct_b_back']))
						&& ($_POST['ct_b_back'] == "Back")){
				contactPhonePostToSession();
				$_SESSION['add_part'] = 3;
				formContactAddress();
			}
			break;
		case 5:
			echo "<h1> Add New Contact </h1>\n";
			$err_msgs = validateContactEmail();
			if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
				displayErrors($err_msgs);
				formContactEmail();
			} else if (isset($_POST['ct_b_skip'])){
				$_SESSION['add_part'] = 6;
				formContactWeb();
			} else if ((isset($_POST['ct_b_next']))
					&& ($_POST['ct_b_next'] == "Next")){
				contactEmailPostToSession();
				$_SESSION['add_part'] = 6;
				formContactWeb();
			} else if ((isset($_POST['ct_b_back']))
						&& ($_POST['ct_b_back'] == "Back")){
				contactEmailPostToSession();
				$_SESSION['add_part'] = 4;
				formContactPhone();
			}
			break;
		case 6:
			echo "<h1> Add New Contact </h1>\n";
			$err_msgs = validateContactWeb();
			if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
				displayErrors($err_msgs);
				formContactWeb();
			} else if (isset($_POST['ct_b_skip'])){
				$_SESSION['add_part'] = 7;
				formContactNote();
			} else if ((isset($_POST['ct_b_next']))
					&& ($_POST['ct_b_next'] == "Next")){
				contactWebPostToSession();
				$_SESSION['add_part'] = 7;
				formContactNote();
			} else if ((isset($_POST['ct_b_back']))
						&& ($_POST['ct_b_back'] == "Back")){
				contactWebPostToSession();
				$_SESSION['add_part'] = 5;
				formContactEmail();
			}
			break;
		case 7:
			echo "<h1> Add New Contact </h1>\n";
			$err_msgs = validateContactNote();
			if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
				displayErrors($err_msgs);
				formContactNote();
			} else if (isset($_POST['ct_b_skip'])){
				$_SESSION['add_part'] = 8;
				formContactSave();
			} else if ((isset($_POST['ct_b_next']))
					&& ($_POST['ct_b_next'] == "Next")){
				contactNotePostToSession();
				$_SESSION['add_part'] = 8;
				formContactSave();
			} else if ((isset($_POST['ct_b_back']))
						&& ($_POST['ct_b_back'] == "Back")){
				contactNotePostToSession();
				$_SESSION['add_part'] = 6;
				formContactWeb();
			}
			break;
		case 8:
			if ((isset($_POST['ct_b_next']))
					&& ($_POST['ct_b_next'] == "Save")){
				$db_conn = connectDB();
				saveContact($db_conn);
				$db_conn = NULL;
				$_SESSION['add_part'] = 0;
				clearAddContactFromSession();
				$_SESSION['mode'] = "Display";
				formContactDisplay();
			} else if ((isset($_POST['ct_b_back']))
						&& ($_POST['ct_b_back'] == "Back")){
				echo "<h1> Add New Contact </h1>\n";
				$_SESSION['add_part'] = 7;
				formContactNote();
			}
			break;
		default:
    }
} else if(($_SESSION['mode'] == "Edit") && ($_SERVER['REQUEST_METHOD'] == "GET")){ 
	switch ($_SESSION['edit_part']) {
		case 0:
		case 1:
			formContactType();
			break;
		case 2:
			formContactName();
			break;
		case 3:
			formContactAddress();
			break;
		case 4:
			formContactPhone();
			break;
		case 5:
			formContactEmail();
			break;
		default:
	}
} else if($_SESSION['mode'] == "Edit"){
    
    switch ($_SESSION['edit_part']) {
        case 0:
            // Check if a contact is selected on the list
            $err_msgs = checkSelectedContact();
            if (count($err_msgs) > 0) {
                displayErrors($err_msgs);
                formContactDisplay();
            } else {
                // Get values from DB and fill the $_SESSION
                editContact();
                echo "<h1> Edit Contact </h1>\n";
                $_SESSION['edit_part'] = 1;
                formContactType();
            }
            break;
        case 1:
            echo "<h1> Edit Contact </h1>\n";
            $err_msgs = validateContactType();
            if (count($err_msgs) > 0){
                displayErrors($err_msgs);
                formContactType();
            } else {
                contactTypePostToSession();
                $_SESSION['edit_part'] = 2;
                formContactName();
            }
            break;
        case 2:
            echo "<h1> Edit Contact </h1>\n";
            $err_msgs = validateContactName();
            if (count($err_msgs) > 0){
                displayErrors($err_msgs);
                formContactName();
            } else if ((isset($_POST['ct_b_next']))
                    && ($_POST['ct_b_next'] == "Next")){
                contactNamePostToSession();
                $_SESSION['edit_part'] = 3;
                formContactAddress();
            } else if ((isset($_POST['ct_b_back']))
                        && ($_POST['ct_b_back'] == "Back")){
                contactNamePostToSession();
                $_SESSION['edit_part'] = 1;
                formContactType();
            }
            break;
        case 3:
            echo "<h1> Edit Contact </h1>\n";
            $err_msgs = validateContactAddress();
            if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
                displayErrors($err_msgs);
                formContactAddress();
            } else if (isset($_POST['ct_b_skip'])){
                $_SESSION['edit_part'] = 4;
                formContactPhone();
            } else if ((isset($_POST['ct_b_next']))
                    && ($_POST['ct_b_next'] == "Next")){
                contactAddressPostToSession();
                $_SESSION['edit_part'] = 4;
                formContactPhone();
            } else if ((isset($_POST['ct_b_back']))
                        && ($_POST['ct_b_back'] == "Back")){
                contactAddressPostToSession();
                $_SESSION['edit_part'] = 2;
                formContactName();
            }
            break;
        case 4:
            echo "<h1> Edit Contact </h1>\n";
            $err_msgs = validateContactPhone();
            if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
                displayErrors($err_msgs);
                formContactPhone();
            } else if (isset($_POST['ct_b_skip'])){
                $_SESSION['edit_part'] = 5;
                formContactEmail();
            } else if ((isset($_POST['ct_b_next']))
                    && ($_POST['ct_b_next'] == "Next")){
                contactPhonePostToSession();
                $_SESSION['edit_part'] = 5;
                formContactEmail();
            } else if ((isset($_POST['ct_b_back']))
                        && ($_POST['ct_b_back'] == "Back")){
                contactPhonePostToSession();
                $_SESSION['edit_part'] = 3;
                formContactAddress();
            }
            break;
        case 5:
            echo "<h1> Edit Contact </h1>\n";
            $err_msgs = validateContactEmail();
            if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
                displayErrors($err_msgs);
                formContactEmail();
            } else if (isset($_POST['ct_b_skip'])){
                $_SESSION['edit_part'] = 6;
                formContactWeb();
            } else if ((isset($_POST['ct_b_next']))
                    && ($_POST['ct_b_next'] == "Next")){
                contactEmailPostToSession();
                $_SESSION['edit_part'] = 6;
                formContactWeb();
            } else if ((isset($_POST['ct_b_back']))
                        && ($_POST['ct_b_back'] == "Back")){
                contactEmailPostToSession();
                $_SESSION['edit_part'] = 4;
                formContactPhone();
            }
            break;
        case 6:
            echo "<h1> Edit Contact </h1>\n";
            $err_msgs = validateContactWeb();
            if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
                displayErrors($err_msgs);
                formContactWeb();
            } else if (isset($_POST['ct_b_skip'])){
                $_SESSION['edit_part'] = 7;
                formContactNote();
            } else if ((isset($_POST['ct_b_next']))
                    && ($_POST['ct_b_next'] == "Next")){
                contactWebPostToSession();
                $_SESSION['edit_part'] = 7;
                formContactNote();
            } else if ((isset($_POST['ct_b_back']))
                        && ($_POST['ct_b_back'] == "Back")){
                contactWebPostToSession();
                $_SESSION['edit_part'] = 5;
                formContactEmail();
            }
            break;
        case 7:
            echo "<h1> Edit Contact </h1>\n";
            $err_msgs = validateContactNote();
            if ((!isset($_POST['ct_b_skip'])) && (count($err_msgs) > 0)){
                displayErrors($err_msgs);
                formContactNote();
            } else if (isset($_POST['ct_b_skip'])){
                $_SESSION['edit_part'] = 8;
                formContactSave();
            } else if ((isset($_POST['ct_b_next']))
                    && ($_POST['ct_b_next'] == "Next")){
                contactNotePostToSession();
                $_SESSION['edit_part'] = 8;
                formContactSave();
            } else if ((isset($_POST['ct_b_back']))
                        && ($_POST['ct_b_back'] == "Back")){
                contactNotePostToSession();
                $_SESSION['edit_part'] = 6;
                formContactWeb();
            }
            break;
        case 8:
            if ((isset($_POST['ct_b_next']))
                    && ($_POST['ct_b_next'] == "Save")){
                $db_conn = connectDB();
                updateContact($db_conn);
                $db_conn = NULL;
                $_SESSION['edit_part'] = 0;
                clearAddContactFromSession();
                $_SESSION['mode'] = "Display";
                formContactDisplay();
            } else if ((isset($_POST['ct_b_back']))
                        && ($_POST['ct_b_back'] == "Back")){
                echo "<h1> Edit Contact </h1>\n";
                $_SESSION['edit_part'] = 7;
                formContactNote();
            }
            break;
        default:
        
    }
} else if($_SESSION['mode'] == "Delete"){
    if ((isset($_POST['ct_b_delete'])) && ($_POST['ct_b_delete'] == "Delete")) {        
        $err_msgs = checkSelectedContact();
        if (count($err_msgs) > 0) {
            displayErrors($err_msgs);
            formContactDisplay();
        } else {
            confirmDeleteContact();
        }
    } else if (isset($_POST['delete-yes'])) {
        executeDelete();
        formContactDisplay();
    } else {
        unset($_SESSION['list_select']);
        formContactDisplay();        
    }
    
} else if($_SESSION['mode'] == "View"){ 
		// Check if a contact is selected on the list
		$err_msgs = checkSelectedContact();
		if (count($err_msgs) > 0) {
			displayErrors($err_msgs);
			formContactDisplay();
		} else {
			viewDetails();
		}
} else if($_SESSION['mode'] == "Display"){ 
	formContactDisplay();
} 
?>
	</body>
</html>

<?php
function formContactDisplay(){
	$db_conn = connectDB();
	$fvalue = "";
	if (isset($_POST['ct_b_filter']) && isset($_POST['ct_filter'])){
		$_SESSION['ct_filter'] = trim($_POST['ct_filter']);
		$fvalue = $_SESSION['ct_filter'];
	} else if (isset($_POST['ct_b_filter_clear'])){
		$_SESSION['ct_filter'] = "";
		$fvalue = $_SESSION['ct_filter'];
	} else if (isset($_SESSION['ct_filter'])){
		$fvalue = $_SESSION['ct_filter'];
	}
?>
		<h1> Contacts </h1>
		<div>
		<form method="POST">
		<table>
		<tr>
			<td><label for="ct_filter">Filter Value</label></td>
			<td><input type="text" class="contact-input" name="ct_filter" id="ct_filter" value="<?php echo $fvalue; ?>"></td>
			<td><input type="submit" name="ct_b_filter" value="Filter">
			<td><input type="submit" name="ct_b_filter_clear" value="Clear Filter">
		</tr>
		</table>
		<br>
<?php
	displayContacts($db_conn);
	$db_conn = NULL;
?>
			<br>
			<table>
			<tr>
				<td><input type="submit" name ="ct_b_view_details" value="View Details"></td>
				<td><input type="submit" name ="ct_b_edit" value="Edit"></td>
				<td><input type="submit" name ="ct_b_delete" value="Delete"></td>
			</tr>
			<tr></tr>
			<tr>
				<td><input type="submit" name ="ct_b_add" id="add-new" value="Add New Contact"></td>
			</tr>
			</table>
		</form>
		</div>
<?php } ?>
