				<html>
				<head><title> Administrator Login </title>
				<style>
				.btn{
					  width: 100%;
					  background: #0000a0;
					  border: 2px solid #4caf50;
					  color: white;
					  padding: 5px;
					  font-size: 18px;
					  cursor: pointer;
					  margin: 12px 0;
					}
				</style>
				</head>
				<body style="background: linear-gradient(rgba(255, 200, 200, 0.8),rgba(200, 255, 255, 0.8)), url(images/unom1.jpg) no-repeat; background-size: cover;">
				<a href="index.html" class="btn">HOME</a>
				</body>
				</html>
				
				<?php
				$userid = $_POST['username'];
				$userpass = $_POST['password']; 

				if($userid=="")
					echo "<script type='text/javascript'>alert('Please fill the username');</script>";
				elseif($userpass=="")
					echo "<script type='text/javascript'>alert('Please fill the password');</script>";
				else{
					if ($userid=="administrator" && $userpass== "admin" ) { 
							echo "<h3>Registered Students</h3>";
							$servername = "localhost";
							$username = "root";
							$password = "";
							$dbname = "ICACSEM";

							// Create connection
							$conn = mysql_connect($servername, $username, $password);

							mysql_select_db("ICACSEM", $conn);

							mysql_set_charset('UTF-8', $conn);
							// Check connection
							if (!$conn) {
								die("Connection failed:" . mysql_error());
							}

							$sql = "SELECT id,username,designation,des,institution,email,mobile,address,receiptname,presenter,topic,event,filename FROM files";
							$result = mysql_query($sql, $conn);
							
							echo "<table>". "<tr>"."<th>"."Id". "</th>"."<th>"."Username". "</th>"."<th>"."Status". "</th>" ."<th>"."Designation". "</th>" ."<th>". "Institution". "</th>" ."<th>"."Email". "</th>" ."<th>"."Mobile". "</th>" ."<th>". "Address"."</th>" ."<th>". "Receiptname"."</th>" ."<th>". "Presenter"."</th>"."<th>". "Topic"."</th>" ."<th>". "Event"."</th>" ."<th>". "Filename"."</th>"."<br>";
							if (mysql_num_rows($result) > 0) {
								// output data of each row
								while($row = mysql_fetch_assoc($result)) {
									$files = "<a href=\"uploads/".$row["topic"]."/".$row["email"].$row["filename"]."\">". $row["filename"]."</a>";
									$bills = "<a href=\"Receipt/".$row["email"].$row["username"].$row["receiptname"]."\">". $row["receiptname"]."</a>";
									echo "<tr>"."<td>".$row["id"]. "</td>" ."<td>".$row["username"]. "</td>" ."<td>". $row["designation"]."</td>"."<td>". $row["des"]."</td>"."<td style=\"width:200px\">".$row["institution"]. "</td>" ."<td style=\"width:200px\">".$row["email"]. "</td>" ."<td>". $row["mobile"]."</td>" ."<td style=\"width:200px\">". $row["address"]."</td>" ."<td>". $bills."</td>" ."<td>". $row["presenter"]."</td>" ."<td>". $row["topic"]."</td>" ."<td>". $row["event"]."</td>" ."<td style=\"width:200px\">". $files."</td>". "</tr>";

								}
								echo "</table>";
							} else {
								echo "0 results";
							}
							mysql_close($conn);
						}
						else{ 
							echo "<script type='text/javascript'>alert('The username and password is incorrect');</script>";
							echo "Please provide correct username and password...";
							echo "<br> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
							&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <a href=admin.html>Go Back </a>";
						}
				}
				?>