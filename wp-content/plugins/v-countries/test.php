
<?php
	
  $cc1 = $_GET['cc'];
//exit();
	$corrtime = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $cc1);
print_r($corrtime[0]);
	


?>