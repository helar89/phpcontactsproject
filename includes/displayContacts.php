<?php 
function displayContacts($db_conn){

	$qry = "select ct_id, ct_disp_name, ad_city from contact left join contact_address on ct_id = ad_ct_id where ct_deleted = 'N'";
	if (isset($_SESSION['ct_filter'])){ 
		if((strlen($_SESSION['ct_filter']) > 0)){
            $qry .= " and ct_disp_name like CONCAT( '%', :filter, '%')"; // Item (2) => Protection against SQL injection
		}
	}
    $qry .= " order by ct_disp_name;";
    $stmt = $db_conn->prepare($qry);
	if (!$stmt){
		echo "<p>Error in display prepare: ".$db_conn->errorCode()."</p>\n<p>Message ".implode($db_conn->errorInfo())."</p>\n";
		exit(1);
    }

    if (isset($_SESSION['ct_filter'])){ 
		if((strlen($_SESSION['ct_filter']) > 0)){ 
            $filter = $_SESSION['ct_filter'];
            $data = array(":filter" => $filter); // Item (2) => Protection against SQL injection
            $status = $stmt->execute($data);
        } else {
            $status = $stmt->execute();
        }
    } else {
        $status = $stmt->execute();
    }   
	
	if ($status){
		if ($stmt->rowCount() > 0){
?>
			<table border="1" class="users">
			<tr><th>Select</th><th>Name</th><th>Location</th></tr>
<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
			<tr>
			<td><input type="radio" name="list_select[]" id="contacts" value="<?php echo $row['ct_id']; ?>"></td>
			<td><?php echo $row['ct_disp_name']; ?></td>
			<td><?php echo $row['ad_city']; ?></td>
			</tr>
<?php } ?>
			</table>
<?php
		} else {
			echo "<div>\n";
			echo "<p>No contacts to display</p>\n";
			echo "</div>\n";
		}
	} else {
		echo "<p>Error in display execute ".$stmt->errorCode()."</p>\n<p>Message ".implode($stmt->errorInfo())."</p>\n";
		exit(1);
	}
}
?>
