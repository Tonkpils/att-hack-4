<!DOCTYPE HTML>
<html>
<head>
<title>index</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/ui-darkness/jquery-ui-1.10.2.custom.min.css" />
<link rel="stylesheet" href="../css/jquery.mobile-1.3.0.min.css" />
<link rel="stylesheet" href="../css/main.css" />
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.2.custom.min.js"></script>
<script type="text/javascript" src="../js/basic.js"></script>
<script type="text/javascript">var deviceID= device.uuid;console.log(deviceID);</script>

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

<script>
	function changeLink(obj){
		//alert('aa'); 
		//alert(device.uuid);
		//$(this).attr('href');
		var go = 'http://havirtualskindr.com/mobile/home/' + obj.getAttribute('href') +'?deviceID='+device.uuid+'&';
		document.location.href = go;
		alert(go);

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
		//var jj = obj.getAttribute('href')+'?deviceID='+deviceID;
			console.log(go);";

?>
		/*
		document.location.href = 'cases.php?deviceID='+device.uuid;
		var jj = 'cases.php?deviceID='+device.uuid;
		*/
		
		//return false;
	}
</script>


</head>
<body>
<div data-role="page" id="index-page">
	<div id="header" data-role="header" data-theme="a" data-position="fixed">
        <a style="display:none;"></a>
<h1>Skin Doctor</h1>
<a data-ajax="false" onclick="changeLink(this); return false;" id="home-button" data-theme="c" href="http://havirtualskindr.com/mobile/home/" data-role="button"></a>
    </div>
	<div data-role="content">
        <div id="body-container">            
			<a data-ajax="false" onclick="changeLink(this); return false;" href="mobilehtml.php" data-role="button">Send a Case</a>
            <a href="http://skindoc.divosh.com/home/information.html" data-role="button">STD Information</a>
            <a data-ajax="false" onclick="changeLink(this);return false;" href="cases.php" data-role="button">Cases</a>
        </div>
    </div>
    <div data-role="footer">
        <h4>DIVOSH</h4>
    </div>
</div>
</body>
</html>
