
<?php
	
 
	
	
	//error_reporting(0);
	global $wpdb;
	$conn = mysqli_connect("localhost", "root", "", "deskera_2");
	$result = mysqli_query($conn,"SELECT * from wp_countries");
	while($row = mysqli_fetch_array($result)){
		
		echo $row['country']."<br>";
		
		}
	


?>