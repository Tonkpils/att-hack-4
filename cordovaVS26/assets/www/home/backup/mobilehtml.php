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



<div data-role="page" id="send-page">
    	<script>
			function submitMainForm()
			{
				alert("submitting form");
				formData = $("#main-form").serialize();
				$.getJSON( "/mobilesavepatient.php", formData).done(
					function( data ){
						alert(data);
						console.log(data);
						
					}
				)
			}

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
	    <a onclick="changeLink(this)" data-role="button" href="index.php">Home</a>
        </div>
        <div data-role="content">
        	<span>Snapshot <?=$_GET['deviceID']?>
		<?php //print_r($_HEADER);?>
		</span>

<form id="form1" method="post" action="mobilesavepatient.php">
<!--
            <form id="main-form">
-->
            <div>
                <div class="image-selector"> 
                    <div class="image-preview-container">
                        <img id="smallImage" class="image-preview" src="../css/image-selector-placeholder.png"/>				
                    </div>
                    <input class="image-field" type="hidden" id="snapshot-field" name="snapshot" />
                    <div class="image-footer">
                        <!--icons-->
                        <a onclick="aaa()" class="image-icon-link camera-icon"><span class="image-icon camera-icon"></span></a>
                        <a onclick="getPhoto(pictureSource.PHOTOLIBRARY);" class="image-icon-link browse-icon"><span class="image-icon browse-icon"></span></a>
                        <a class="image-icon-link delete-icon"><span class="image-icon delete-icon"></span></a>
                    </div>
                </div>
            </div>
        	<span>Close-up</span>
            <div>
                <div class="image-selector"> 
                    <div class="image-preview-container">
                        <img class="image-preview" src="../css/image-selector-placeholder.png"/>				
                    </div>
                    <input class="image-field" type="hidden" id="close-up-field" name="close-up" />
                    <div class="image-footer">
                        <!--icons-->
                        <a onclick="aaa(2)" class="image-icon-link camera-icon"><span class="image-icon camera-icon"></span></a>
                        <a onclick="getPhoto(pictureSource.PHOTOLIBRARY, 2);" class="image-icon-link browse-icon"><span class="image-icon browse-icon"></span></a>
                        <a class="image-icon-link delete-icon"><span class="image-icon delete-icon"></span></a>
                    </div>
                </div>
            </div>

<?php $sqlmax = mysql_query("select max(id) as 'max' from patient");
	$rowmax = mysql_fetch_array($sqlmax,MYSQL_ASSOC);
	$sec = $rowmax["max"]+1;
	mysql_free_result($sqlmax); 

?>
<input type="text" placeholder="Case ID" id="age-field" name="nonameinput" value="<?=$sec ?>"/>

<input type="hidden" placeholder="Case ID" id="age-field" name="idpatient" value="<?=$sec ?>"/>
	<input id="name" name="name" type="text" placeholder="First Name"/>
	<input id="last" name="lastname" type="text" placeholder="Last Name" />

		<input type="text" name="deviceID" value="<?=$_GET['deviceID']?>"/>
        	<input type="text" placeholder="Age" id="age-field" name="age"/>
            <input type="text" placeholder="Gender" id="gender-field" name="gender"/>
            <input type="text" placeholder="Description" id="description-field" name="description"/>
            <input type="text" placeholder="Duration" id="duration-field" name="duration"/>
            <input type="text" placeholder="Symptoms" id="symptoms-field" name="symptoms"/>
            <input type="text" placeholder="Unprotected sex?" id="unprotected-sex-field" name="unprotected-sex"/>
            <input type="text" placeholder="Other Diseases" id="age-field" name="age"/>

		<input data-role="button" type="submit" value="Submit Claim" data-inline="true"/>
            </form>

	<!--
            <div data-role="button" onclick="submitMainForm();">Submit</div>
            -->
        </div>
        <div data-role="footer">
            <h4>DIVOSH</h4>
        </div>
    
    </div>













<!--
<div data-role="page" data-theme="b" id="page1">




	<div data-role="header" id="hdrMain" name="hdrMain" data-nobackbtn="true">
		<h1>New Claim</h1>
	</div>
	
	
	
<img onclick="aaa();" style="width:200px;height:200px;" id="smallImage" src="http://divosh.com/appimages/nophoto.jpg" />
	    <img style="display:none;" id="largeImage" src="" />
	
	
	

	<div data-role="content" id="contentMain" name="contentMain">	
	
	<form id="form1" method="post" action="mobilesavepatient.php">
	
	<div id="shipDiv" data-role="fieldcontain">
		<label for="sec">Case ID*</label>	
				<?php $sqlmax = mysql_query("select max(id) as 'max' from patient");
						  $rowmax = mysql_fetch_array($sqlmax,MYSQL_ASSOC);
						  $sec = $rowmax["max"]+1;
						  mysql_free_result($sqlmax); 
					?>
		
		
		<input type="text" name="sec" id="sec" disabled value="<?php echo $sec; ?>">
		<input type="hidden" name="idpatient" id="idpatient" value="<?php echo $sec; ?>">	
	</div>
	
	
    <img style="display:none;width:60px;height:60px;" id="smallImage" src="" />
    <img style="display:none;" id="largeImage" src="" />
	
		
		<input id="name" name="name" type="text" placeholder="first name"/>
	<div id="lastDiv" data-role="fieldcontain">
		<label for="last">Last name*</label>		
		<input id="last" name="lastname" type="text" />
	</div>
		
  <div id="emailDiv" data-role="fieldcontain">
		<label for="email">Email*</label>		
		<input id="email" name="email_r" type="text" />
	</div>
	
	


	
	
	<div id="ageDiv" data-role="fieldcontain">
  		<label for="age">Age*</label>		
  		<input id="age" name="age_r" type="text" />
  	</div>
  	
  	<div id="sexDiv" data-role="fieldcontain">
  		<label for="sex">Sex*</label>		
  		<input id="sex" name="sex_r" type="text" />
  	</div>
	
	
	<div id="cityDiv" data-role="fieldcontain">
  		<label for="city">City*</label>		
  		<input id="city" name="city_r" type="text" />
  	</div>
  	
  	
  	<label for="slider1">Gender:</label>
		<select name="slider1" id="slider1" data-role="slider">
	    <option value="off">Male</option>
	    <option value="on">Female</option>
	</select>


	<label for="slider2">Have you had unprotected sex:</label>
		<select name="slider2" id="slider2" data-role="slider">
	    <option value="No">No</option>
	    <option value="Yes">Yes</option>
	</select>
	
	
	
	
	
	
	
	
	
	
	<fieldset data-role="controlgroup">
	    <legend>Recent symptoms:</legend>
	    
	    <input type="checkbox" name="rewiew[]" id="rewiew6">
	    <label for="rewiew6">Rash</label>
	    
	    <input type="checkbox" name="rewiew[]" id="rewiew1">
	    <label for="rewiew1">Itch</label>
	    
	    <input type="checkbox" name="rewiew[]" id="rewiew2">
	    <label for="rewiew2">Pain</label>
	    
	    <input type="checkbox" name="rewiew[]" id="rewiew3">
	    <label for="rewiew3">Fever</label>
	    
	    <input type="checkbox" name="rewiew[]" id="rewiew4">
	    <label for="rewiew4">Chills</label>
	    
	    <input type="checkbox" name="rewiew[]" id="rewiew5">
	    <label for="rewiew5">Nausea</label>
	    
	</fieldset>
	
	
	
	
	
	
	
		<fieldset data-role="controlgroup">
	    <legend>Description:</legend>
	    
	    <?php 
	    
	    $arrdis = explode(",",$rowult["descriptionofskinlesions"]);
						$k=0;
						while($k < sizeof($arraylesions))
						{
						?>
                        <input type="checkbox" name="descriptionofskinlesions[]" id="descriptionofskinlesions<?php echo $k; ?>">
                        <label for="descriptionofskinlesions<?php echo $k; ?>"><?php echo $arraylesions[$k]; ?></label>

                        <?
							$k++;
						}
					?> 
	    
	</fieldset>
	
	
	
		<fieldset data-role="controlgroup">
	    <legend>Distribution:</legend>

                    <?
                    	$k=0;
						while($k < sizeof($arraydistribution))
						{
						?>
                        <input type="checkbox" name="distribution[]" id="distribution<?php echo $k; ?>" >
                        <label for="distribution<?php echo $k; ?>"><?php echo $arraydistribution[$k]; ?></label>
                        
                        <?
							$k++;
						}
					?> 
	</fieldset>
	
	
	
	<div id="relDiv" data-role="fieldcontain">
  		<label for="rel">Other Relevant Information:*</label>		
  		<input id="rel" name="rel_r" type="text" />
  	</div>
	
	
	
	

  	
  
  	<div id="submitDiv" data-role="fieldcontain">    
  	 <input type="submit" value="Submit Claim" data-inline="true"/>
    </div>
    </form>
	</div>
  
	<div data-role="footer" id="ftrMain" name="ftrMain"></div>

	
	
<script>
  function hideMain(){
    hdrMainVar.hide();
    contentMainVar.hide();
    ftrMainVar.hide();   
   }
   
  function showMain(){
    hdrMainVar.show();
    contentMainVar.show();
    ftrMainVar.show();
   }
   
   function hideContentTransition(){
    contentTransitionVar.hide();
   }      
   
   function showContentTransition(){
    contentTransitionVar.show();
   }  
   
  function hideContentDialog(){
    contentDialogVar.hide();
   }   
   
   function showContentDialog(){
    contentDialogVar.show();
   }
   
   function hideConfirmation(){
    hdrConfirmationVar.hide();
    contentConfirmationVar.hide();
    ftrConfirmationVar.hide();
   }  
   
   function showConfirmation(){
    hdrConfirmationVar.show();
    contentConfirmationVar.show();
    ftrConfirmationVar.show();
   } 

    
  </script>
</div> 
-->
</body>
</html>
