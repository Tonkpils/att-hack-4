<?php
session_start();
include("../../includes/db.php");
include("../../includes/functions.php");
//include("security.php");
?>

<!DOCTYPE html> 
<html> 
	<head> 
	<title>New Claim</title> 
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../css/ui-darkness/jquery-ui-1.10.2.custom.min.css" />
<link rel="stylesheet" href="../css/jquery.mobile-1.3.0.min.css" />
<link rel="stylesheet" href="../css/main.css" />
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.2.custom.min.js"></script>
<script type="text/javascript" src="../js/basic.js"></script>
  

<!--
<script type="text/javascript" charset="utf-8" src="http://server.divosh.com/dev/js/cordova-2.5.0.js"></script>
<script type="text/javascript" charset="utf-8" src="http://server.divosh.com/dev/js/scarlet-services.js"></script>
  -->
  
<?php

//Detect special conditions devices
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

//do something with this information
if( $iPod || $iPhone ){
	echo '<script type="text/javascript" charset="utf-8" src="../js/cordova.ios.js"></script>';
	//browser reported as an iPhone/iPod touch -- do something here
}else if($iPad){
	echo '<script type="text/javascript" charset="utf-8" src="../js/cordova.ios.js"></script>';
	//browser reported as an iPad -- do something here
}else if($Android){
	echo '<script type="text/javascript" charset="utf-8" src="../js/cordova-2.5.0.js"></script>';
	//browser reported as an Android device -- do something here
}else if($webOS){
	echo '<script type="text/javascript" charset="utf-8" src="../js/cordova-2.5.0.js"></script>';
	//browser reported as a webOS device -- do something here
}else{
	echo '<script type="text/javascript" charset="utf-8" src="../js/cordova-2.5.0.js"></script>';
}


?>
  <script type="text/javascript" charset="utf-8">var time=<?php echo time(); ?></script>
  <script type="text/javascript" charset="utf-8">var sessid=<?php echo session_id(); ?></script>
  <script type="text/javascript" charset="utf-8" src="../js/scarlet-services.js"></script>

 
</head> 

<body>

    <div data-role="page" id="cases-page">
<script>
	function changeLink(obj){
		//alert('aa'); 
		//alert(device.uuid);
		//$(this).attr('href');

		document.location.href = obj.getAttribute('href')
					+'?deviceID='+device.uuid;
		alert(obj.getAttribute('href')
					+'?deviceID='+device.uuid);

		<?php
/*
		if(isset($_GET['deviceID'])) {
		echo "alert('avf')
		var jj = obj.getAttribute('href')+'?deviceID='+{$_GET['deviceID']};
console.log(jj);";
		}else{
		echo "
		var jj = obj.getAttribute('href')+'?deviceID='+deviceID;
console.log(jj);";
		}
*/
echo "
		var jj = obj.getAttribute('href')+'?deviceID='+deviceID;
			console.log(jj);";

?>
		/*
		document.location.href = 'cases.php?deviceID='+device.uuid;
		var jj = 'cases.php?deviceID='+device.uuid;
		*/
		
		return false;
	}
</script>
        <div id="header" data-role="header" data-theme="a" data-position="fixed">
		<a style="display:none;"></a>
			<h1>Skin Doctor</h1>

		<a data-ajax="false" onclick="changeLink(this)" data-role="button" href="index.php">Home</a>
        </div>
        <div data-role="content">
        	<div class="add-a-case-container" >
               <h3>View a Case<?=$_GET['deviceID']?></h3>
               <p>You can add existing case numbers that you have submitted to Skin Doctor.</p> 
	<form data-ajax="false" method="get" action="patient.php">
               	<input name="email" type="text" placeholder="Email">
		<input name="password" type="password" placeholder="Password">
		<input onclick="alert(deviceID)" type="submit" value="View Case">
	</form>
            </div>

	<?php
		//show cases
		
		$user='';
		$pass='';
		//print_r($_POST);


		//$sqlp = mysql_query("select * from patient where id=".mysql_real_escape_string($id).""); 
	//get patient from a certain deviceID
	$query = "select * from patient where password='".mysql_real_escape_string($_GET['deviceID'])."'";
	$sqlp = mysql_query($query);

	$nrowsp = mysql_num_rows($sqlp);
	$ii=0;


	echo '<ul data-role="listview" data-inset="true">';
	//get all the cases 
	while($nrowsp > $ii && isset($_GET['deviceID']) && $_GET['deviceID'] != '') 
	{
		echo '<li>';
		$rowp = mysql_fetch_array($sqlp,MYSQL_ASSOC);

		//get idcruisepatient that is used in the next mysql query
		//which grabs the first image to display
		$sqlult = mysql_query("SELECT  id
					FROM cruise_patient
					WHERE idpatient =".mysql_real_escape_string($rowp['id'])."
					order by id desc
					limit 0,1
					");
		$rowult = mysql_fetch_array($sqlult,MYSQL_ASSOC);
		//print_r($rowult);
		$idult = $rowult["id"];	
		mysql_free_result($sqlult);



		$query = "select * from pictures_patient where idcruisepatient=".$idult.
			" ORDER BY codeimg ASC limit 0,1";
		$sqli = mysql_query($query);
		$rowi = mysql_fetch_array($sqli,MYSQL_ASSOC);
		if($rowi == FALSE){ echo "{$query}</li>"; break;}
		//echo '<h1>'. $nrowsi .'</h1>';
		if(($rowi["picture"]!="")//&&
			//(file_exists("/Uploadify/files/".$rowi["picture"]) )
		  )
		{
			echo "<a href='patient2.php?id={$rowp['id']}&deviceID={$_GET['deviceID']}'>";
			echo '<img src="http://havirtualskindr.com/Uploadify/files/' . $rowi["picture"] . '"'
			. 'width="200" height="200"'	
			.'/>';
			$tt = $ii+1;
			echo "<h2>Case #{$tt} -- {$rowp['id']}</h2>";
			//echo "<p>Broken Bells</p>";
			echo "</a>";
	
		}
		echo '</li>';
		++$ii;

	}
	echo '</ul>';






/*

		$rowp = mysql_fetch_array($sqlp,MYSQL_ASSOC);
		$id='';
		if($rowp == FALSE){
			//header('Location: http://havirtualskindr.com/mobile/home/cases.php');
	
			//echo "Sorry you do not have the correct credentials.";
			echo '
			<script type="text/javascript">
				window.location = "http://havirtualskindr.com/mobile/home/cases.php"
			</script>
			';
			return;
		}else{
			$id = $rowp['id'];
		}


	//echo 


	echo "<br /><a data-role='button' data-ajax='false' href='patient.php?id={$id}&deviceID={$_GET['deviceID']}'>Click Here to View Case</a>";
//echo "<a href='www.google.com'>Google</a>";
*/	
	?>
        
        </div>
        <div data-role="footer">
            <h4>DIVOSH</h4>
        </div>
    
    </div>

</body>
</html>
