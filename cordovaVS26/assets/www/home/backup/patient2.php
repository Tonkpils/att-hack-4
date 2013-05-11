<?php
//php spaghetti code goes in here
session_start();

include("../../includes/db.php");
include("../../includes/functions.php");
$user='';
$pass='';

if(isset($_GET['deviceID']))
{

	$pass=$_GET['deviceID'];
	$caseid=$_GET['id'];

}else{
	//header('Location: http://havirtualskindr.com/mobile/home/cases.php');
	echo '
<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript">
window.location = "http://havirtualskindr.com/mobile/home/cases.php";
</script>
</head><body></body>
</html>
	';
	//header('Location: http://havirtualskindr.com/mobile/home/cases.php');
	return;
}

//$sqlp = mysql_query("select * from patient where id=".mysql_real_escape_string($id).""); 
$query = "select * from patient where password='".mysql_real_escape_string($pass)."'"
	. " and id='{$caseid}'";

echo $query;
$sqlp = mysql_query($query);

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
   $sqlult = mysql_query("SELECT  id,comments,reason,onset,duration,progression,suspected,review
   ,recentlabwork,descriptionofskinlesions,distribution,configuration,primarylesion,
secondarychanges,generalizedbody,generalizedtrunk,headneck,extremities,handsfeets,genitalia,
examination,assestments,suggested,comment2,pl,iddoctor 
					FROM cruise_patient
					WHERE idpatient =".mysql_real_escape_string($id)."
order by id desc
limit 0,1
");
		$rowult = mysql_fetch_array($sqlult,MYSQL_ASSOC);
		//print_r($rowult);
		$idult = $rowult["id"];	
		mysql_free_result($sqlult);




?>

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

<script>
	function changeLink(obj){

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
</head>


<body> 
<div data-role="page" id="cases-page">
<script type="text/javascript">
function LoadExamination()
{

	$.get("loadexamination.php",{idp:<?php echo $id; ?>,idu:<?php echo $idult; ?> }, function(data)
		{

			$("#responsedrv").html(data);

			//$("#information-list").listview("refresh");

	$("#responsedrv").listview("refresh");
/*
$( "list-view" ).each(function( index ) {
		$(this).listview("refresh");
  console.log( index + ": " + $(this).text() );
});
*/
		//alert("Loaded content...");
			//LoadVisit();

		});

	//$("#responsedrv").load("loadexamination.php");
}
function LoadVisit()
{
	//alert(<? echo $idult;?>);
	$.get("../../loadvisit.php",{idp:<?php echo $id; ?>,idu:<?php echo $idult; ?> }, function(data)
		{
			//alert(data);
			$("#visit").html(data);
		});
}</script>
    <div id="header" data-role="header" data-theme="a" data-position="fixed">
		<a style="display:none;"></a>
			<h1>Skin Doctor</h1>

		<a data-ajax="false" onclick="changeLink(this)" data-role="button" href="index.php">Home</a>
    </div>
    <div data-role="content">
         <h1>Patient</h1> 
<?php

//
		$sqli = mysql_query("select * from pictures_patient where idcruisepatient=".$idult.
			" ORDER BY codeimg ASC");

/*
$sqli = mysql_query("select * from pictures_patient where idcruisepatient=".$idult." and codeimg=1");
*/
		$rowi='';
		$nrowsi = mysql_num_rows($sqli);
		$ii=0;

/*
        <div>
            <div class="image-selector"> 
                <div class="image-preview-container">
                    <img class="image-preview" src="http://havirtualskindr.com/Uploadify/files/im_1366816551_16590.jpg"/>				
                </div>         
            </div>
        </div>
*/
echo '<div>
            <div class="image-selector"> 
                <div class="image-preview-container">';
                while($nrowsi > $ii) 
		{
			$rowi = mysql_fetch_array($sqli,MYSQL_ASSOC);
			
			//echo '<h1>'. $nrowsi .'</h1>';
			if(($rowi["picture"]!="")//&&
				//(file_exists("/Uploadify/files/".$rowi["picture"]) )
			  )
			{
				echo '<img class="image-preview" src="http://havirtualskindr.com/Uploadify/files/' . $rowi["picture"] . '"'
				. 'width="200" height="200"'	
				.'/>';
				
			}
			++$ii;

		}
echo '
                </div>         
            </div>
        </div>';
 
?>





<!--


        <div>
            <div class="image-selector"> 
                <div class="image-preview-container">
                    <img class="image-preview" src="http://havirtualskindr.com/Uploadify/files/im_1366815975_16588.jpg"/>				
                </div>         
            </div>
        </div>
    -->    
         <script type="text/javascript">
		//LoadExamination(); 
		//LoadVisit(); 
	</script>

<ul id="responsedrv" data-role="listview" id="information-list">
<?php
$_GET = array();
$_GET['idp'] = $id;
$_GET['idu'] = $idult;
        	//include("loadexamination.php");
?>


<?php

//session_start();
//extract($_POST);
//include("../../includes/db.php");
//include("../../includes/functions.php");
$idp= $_GET["idp"];
$idu = $_GET["idu"];
//echo "-----------". $idp . "-----------";
$query = "select examination,assestments,suggested,iddoctor,updated from cruise_patient where
						id=".$idu."";
//echo $query;
$sqlex = mysql_query($query); 
$rowex = mysql_fetch_array($sqlex,MYSQL_ASSOC);
if($rowex["iddoctor"]!="0")
{

$formatreg = ObtenerMes(substr($rowex["updated"],5,2))."/".substr($rowex["updated"],8,2)."/".substr($rowex["updated"],0,4)." at ".substr($rowex["updated"],11,5);				
?>
<!--
  <span class="bglbl">
  <span class="lbl_1">examination:</span>
    <span class="lbl_2"><?php echo $rowex["examination"]; ?></span>
  </span>
    <span class="clear_line">&nbsp;</span>
    
	    <span class="lbl_1">assestments / diagnoses:</span>
        <span class="lbl_2"><?php echo $rowex["assestments"]; ?></span>
    <span class="clear_line">&nbsp;</span>
    

    <span class="bglbl">
    <span class="lbl_1">suggested treatment:</span>
    <span class="lbl_2"><?php echo $rowex["suggested"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
	
    
    <?php //consulto la primera respuesta  
	//echo $idu."czxczxczxczxczxczxczxczx";
		$sqlf = mysql_query("select r.comment from comments_visit c,responses_visit r 
							where c.idvisit=".$idu." and c.type=1 and c.id=r.idcomment");
		$rowf = mysql_fetch_array($sqlf,MYSQL_ASSOC);
		$first = $rowf["comment"];
		mysql_free_result($sqlf);
	?>
    <span class="lbl_1">response to comment #1:</span>
    <span class="lbl_2"><?php echo str_replace("\n","<br>",$first); ?></span>
    <span class="clear_line">&nbsp;</span>
    	 				
    <span class="lbl_1">&nbsp;</span>
    <?
		$sqldoc = mysql_query("select suffix,name,lastname from doctor where id=".$rowex["iddoctor"]."");
		$rowdoc = mysql_fetch_array($sqldoc);
    ?>
    <span class="lbl_2"><img src="imgs/drv.png" border="0" style="vertical-align:text-bottom;"> <strong><?php echo $rowdoc["suffix"].".";?> <?php echo $rowdoc["name"]." ".$rowdoc["lastname"]." - ".$formatreg; ?>
	<?php mysql_free_result($sqldoc); ?>		
    	</strong></span>
    <span class="clear_line">&nbsp;</span>
-->
<?
}
mysql_free_result($sqlex);

?>

<li data-role="list-divider">
	<span>Examination</span>
	</li>
	<li>
	<span><?=$rowex["examination"]?></span>
</li>

<li data-role="list-divider">
	<span>Assessment</span>
</li>
<li>
	<span><?=$rowex["assestments"]?></span> 

</li>    






<li data-role="list-divider">
	<span>Suggested</span>
</li>
<li>
	<span><?=$rowult["suggested"]?></span>

</li>
 






 













</ul>
<!--
	<div id="responsedrv"> 

	</div> 
        
        <ul data-role="listview" id="information-list">
        	<li data-role="list-divider">
            	<span>TEST in patient2.php</span>
            </li>
        	<li>
            	<span>Id:</span>
                <span>78591</span>
            </li>
            <li>
            	<span>Id:</span>
                <span>78591</span>
            </li>
            <li data-role="list-divider">
            	<span>divider</span>
            </li>
            <li>
            	<span>Id:</span>
                <span>78591</span>
            </li>
        </ul>
	-->
    </div>
    <div data-role="footer">
    <h4>DIVOSH</h4>
    </div>

</div>
</body>
</html>
