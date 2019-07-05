
<?php
	
	//$url = rest_url( 'https://restcountries.eu/rest/v2/all' );
	//echo"<pre>";
	//print_r($url);
	//exit();  
	
	
	error_reporting(0);
	global $wpdb;
	$conn = mysqli_connect("localhost", "root", "", "deskera_2");
	/* if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully"; */
	
$link = "https://restcountries.eu/rest/v2/all";

// $data = json_decode($link,true);
 $data = json_decode(file_get_contents($link), true);
//echo "<pre>";
//print_r($data);  
 //exit();

foreach($data as $row)
{
	
	$country_list = array();
	/* echo"<pre>";
	print_r($country_list);
	exit(); */
	$select = mysqli_query($conn,"SELECT country from wp_countries");
	//  echo"<pre>";
	//print_r($select);
	//exit(); */
	while($record = mysqli_fetch_assoc($select))
	{
		$country = $record['country'];
		
		array_push($country_list,$country);
		 
    }
	//   echo"<pre>";
	//print_r($country_list);
	//exit(); 
			if(!in_array($row['name'], $country_list, true))
			{
				$sql ="INSERT INTO wp_countries(country,topLevelDomain,alpha2Code,alpha3Code,callingCodes,timezones, currencies,country_flag) values('".$row[name]."','".$row[topLevelDomain][0]."','".$row[alpha2Code]."','".$row[alpha3Code]."','".$row[callingCodes][0]."','".$row[timezones][0]."','".$row[currencies][0]['code']."','".$row[flag]."')";
				
				mysqli_query($conn, $sql);
				//echo"Data insert Succesfully";
			}
}
//

//echo "<pre>";
//print_r($data);


?>