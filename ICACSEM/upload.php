 <?php
// connect to the database

$conn = mysql_connect('localhost', 'root', '');

mysql_select_db("ICACSEM", $conn);

mysql_set_charset('UTF-8', $conn);


if(!$conn)
{
	echo "Not Connected To Server";
}
if(!mysql_select_db('ICACSEM', $conn))
{
	echo "Database Not Selected";
}


$sql = "SELECT * FROM files";

$result = mysql_query("SELECT * FROM files", $conn);

if(!$result)
	echo 'No result';

// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
	if ($_FILES['myfile']['name'] != ""){
		$filename = $_FILES['myfile']['name'];
		$topics=$_POST['topics'];
		$events=$_POST['events'];
		$presenter=$_POST['presenter'];
	}else{
		$filename = "";
		$topics="";
		$events="";
		$presenter="";
	}
	
	$institution=$_POST['institution'];
	$designation=$_POST['designation'];
	$des=$_POST['des'];
	$receiptname = $_FILES['receipt']['name'];
	$username=$_POST['username'];
	$address=$_POST['address'];
	$email=$_POST['email'];
	$mobile=$_POST['mobile'];
    // destination of the file on the server
    $destination = "uploads/".$topics."/".$email.$filename;
    $receiptbill = "receipt/".$email.$username.$receiptname;
	
	if (file_exists($destination)) {
		echo "<script type='text/javascript'>alert('Sorry, file already exists.');</script>";
	}
	elseif (file_exists($receiptbill)) {
		echo "<script type='text/javascript'>alert('Sorry, your bill name already exists.');</script>";
	}
	else{
		// get the file extension
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$extenfee = pathinfo($receiptname, PATHINFO_EXTENSION);

		// the physical file on a temporary uploads directory on the server

		$file = $_FILES['myfile']['tmp_name'];
		$size = $_FILES['myfile']['size'];

		
		$files = $_FILES['receipt']['tmp_name'];
		$sizes = $_FILES['receipt']['size'];

		if ($filename!=""){
			$fileext = array('txt', 'doc', 'docx');
			if (in_array($extension, $fileext)==false) {
				echo "<script type='text/javascript'>alert('Your file extension must be .txt, .doc or .docx');</script>";
			}
			elseif ($_FILES['myfile']['size'] > 8500000) { // file shouldn't be larger than 8Megabyte
				echo "<script type='text/javascript'>alert('File too large! Need to be below 8MB');</script>";
			}
		}
		
		$proofext=array('pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg');
		if (!in_array($extenfee, $proofext)) {
		echo "<script type='text/javascript'>alert('Your file extension must be .pdf, .doc, .docx, .png, .jpg or .jpeg');</script>";
		} 
		elseif ($_FILES['receipt']['size'] > 8000000) { // file shouldn't be larger than 8Megabyte
			echo "<script type='text/javascript'>alert('File too large! Need to be below 8MB');</script>";
		} 
		else {
			// move the uploaded (temporary) file to the specified destination
			if (move_uploaded_file($file, $destination)){
				if (move_uploaded_file($files, $receiptbill)){
					$sql="INSERT INTO files(username, designation, des, institution, email, mobile, address, receiptname, presenter, topic, event, filename) VALUES ('$username', '$designation', '$des','$institution', '$email', '$mobile', '$address', '$receiptname', '$presenter', '$topics', '$events', '$filename')";
					if (mysql_query($sql,$conn)) {
						$success=  "Welcome ".$username.", your Abstract and Proof of Bank Transaction was uploaded successfully";
						echo "<script type='text/javascript'>alert('$success');</script>";
					}
				}
				else{
					echo "<script type='text/javascript'>alert('failed to upload');</script>";
				}
			}
			elseif (move_uploaded_file($files, $receiptbill)) {
				
				$sql="INSERT INTO files(username, designation, des, institution, email, mobile, address, receiptname) VALUES ('$username', '$designation', '$des','$institution', '$email', '$mobile', '$address', '$receiptname')";
				if (mysql_query($sql,$conn)) {
					
					$success=  "Welcome ".$username.", your Proof of Bank Transaction was uploaded successfully";
					echo "<script type='text/javascript'>alert('$success');</script>";
					
				}
			} else {
				echo "Failed to upload file.";
			}
		}
	}
}
?>