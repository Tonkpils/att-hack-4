<?php
session_start();



//extract($_POST);
include("../../includes/db.php");
include("../../includes/functions.php");
$user='';
$pass='';
//print_r($_POST);

if(isset($_GET['deviceID']))
{

	$pass=$_GET['deviceID'];
	$caseid=$_GET['id'];

}else{
	//header('Location: http://havirtualskindr.com/mobile/home/cases.php');
	echo '
			<html><head>
	<script type="text/javascript">
		window.location = "http://havirtualskindr.com/mobile/home/cases.php";
	</script></head>
			<body></body>
			</html>
	';
	//header('Location: http://havirtualskindr.com/mobile/home/cases.php');
	return;
}


//$sqlp = mysql_query("select * from patient where id=".mysql_real_escape_string($id).""); 
$query = "select * from patient where password='".mysql_real_escape_string($pass)."'"
	. " and id='{$caseid}'";
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

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Virtual Skin Dr.</title>
<link href="../../inc.styles.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../iepngfix_tilebg.js"></script>
<script type="text/javascript">

function LoadExamination()
{
	$.get("../../loadexamination.php",{idp:<?php echo $id; ?>,idu:<?php echo $idult; ?> }, function(data)
		{
			$("#responsedrv").html(data);
			LoadVisit();
			
		});
}
function LoadVisit()
{
	//alert(<? echo $idult;?>);
	$.get("loadvisit.php",{idp:<?php echo $id; ?>,idu:<?php echo $idult; ?> }, function(data)
		{
			//alert(data);
			$("#visit").html(data);
		});
}</script>

<link rel="stylesheet" href="../css/ui-darkness/jquery-ui-1.10.2.custom.min.css" />
<link rel="stylesheet" href="../css/jquery.mobile-1.3.0.min.css" />
<link rel="stylesheet" href="../css/main.css" />


<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.mobile-1.3.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.2.custom.min.js"></script>
<script type="text/javascript" src="../js/basic.js"></script>


</head>

<body class="inPages">
<div data-role="page" id="cases-page">
        <div id="header" data-role="header" data-theme="a" data-position="fixed">
            <h1>Skin Doctor</h1>
        </div>
        <div data-role="content">


<?php //include("../../inc-main.php"); ?>
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="450" align="left" valign="top" class="inPage">
    
    <?php //include("../../inc-menu.php"); ?>






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
                while($nrowsi > $ii) 
		{
			$rowi = mysql_fetch_array($sqli,MYSQL_ASSOC);
			
			//echo '<h1>'. $nrowsi .'</h1>';
			if(($rowi["picture"]!="")//&&
				//(file_exists("/Uploadify/files/".$rowi["picture"]) )
			  )
			{
				echo '<img src="http://havirtualskindr.com/Uploadify/files/' . $rowi["picture"] . '"'
				. 'width="200" height="200"'	
				.'/>';
				
			}
			++$ii;

		}





//echo '<img src="http://havirtualskindr.com/Uploadify/files/' . $rowi["picture"] . '"/>';
//echo '<img src="http://havirtualskindr.com/Uploadify/files/' . $rowi["picture"] . '"/>';
//echo '<h1>havirtualskindr.com/Uploadify/files/' . $rowi["picture"] . '</h1>';
?>





      <div id="clear">&nbsp;</div>

<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">

	<span class="lbl_1">Id:</span>
	<span class="lbl_2"><?php echo $rowp["id"]; ?></span>
    <span class="clear_line">&nbsp;</span>

    <span class="bglbl">
        <span class="lbl_1">Last Name:</span>
        <span class="lbl_2"><?php echo $rowp["lastname"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>

	<span class="lbl_1">First Name:</span>
	<span class="lbl_2"><?php echo $rowp["name"]; ?></span>
    <span class="clear_line">&nbsp;</span>

<?php	
		$formatbir = ObtenerMes(substr($rowp["birthdate"],5,2))."/".substr($rowp["birthdate"],8,2)."/".substr($rowp["birthdate"],0,4);
		
		
 ?>

	<span class="bglbl">
        <span class="lbl_1">date of birth:</span>
        <span class="lbl_2"><?php echo $formatbir;?></span>
    </span>
    <span class="clear_line">&nbsp;</span>

	<span class="lbl_1">Age:</span>
	<span class="lbl_2"><?php echo $rowp["age"]; ?></span>
    <span class="clear_line">&nbsp;</span>

	<span class="bglbl">
        <span class="lbl_1">Sex:</span>
        <span class="lbl_2"><?php echo $rowp["sex"]; ?></span>
	</span>
    <span class="clear_line">&nbsp;</span>

	<span class="lbl_1">Race/Nationality:</span>
	<span class="lbl_2"><?php echo $rowp["race"]; ?></span>
    <span class="clear_line">&nbsp;</span>

	<span class="bglbl">
	    <span class="lbl_1">Ship:</span>
		<span class="lbl_2"><?php 
		  $namecruise = "no assigned"; 
		  $namecruise = $rowp["ship"];
		  echo $namecruise;
		  ?></span>
	</span>
    
    <span class="lbl_1">Cruise ID:</span>
	<span class="lbl_2"><?php echo $rowp["cruseid"]; ?></span>
    <span class="clear_line">&nbsp;</span>

	<span class="clear_space">&nbsp;</span>
    <h2 class="t">Medical History</h2>
    <span class="clear_space">&nbsp;</span>
    

	<span class="bglbl">
        <span class="lbl_1">past medical history:</span>
        <span class="lbl_2"><?php echo $rowp["pastmedical"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    
    
	<span class="lbl_1">past surgical history:</span>
	<span class="lbl_2"><?php echo $rowp["pastsurgical"]; ?></span>
    <span class="clear_line">&nbsp;</span>
    

	<span class="bglbl">
        <span class="lbl_1">personal/family history<br>(ex skin cancer Y/N):</span>
        <span class="lbl_2"><strong><?php echo $rowp["ps"]; ?>.</strong> <?php echo $rowp["personalfamilycancer"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    
    
    <span class="lbl_1">if female : last menstrual period:</span>
    <span class="lbl_2">
	    <?
             if($rowp["sex"]=="female")
             {
 				echo "<strong>".$rowp["period"].". </strong>";
				$formatdate = ObtenerMes(substr($rowp["dateperiod"],5,2))."/".substr($rowp["dateperiod"],8,2)."/".substr($rowp["dateperiod"],0,4);
				if($rowp["period"]=="regular")
				{
					echo $formatdate;
				}	
             }
		 ?>
    </span>
    <span class="clear_line">&nbsp;</span>
    
	<span class="bglbl">
        <span class="lbl_1">medications:</span>
        <span class="lbl_2"><?php echo $rowp["rx"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    
    
    <span class="lbl_1">otc herbal/supplements:</span>
    <span class="lbl_2"><?php echo $rowp["nonrx"]; ?></span>
    <span class="clear_line">&nbsp;</span>
    
	<span class="bglbl">
        <span class="lbl_1">additional comments/information:</span>
        <span class="lbl_2"><?php echo $rowp["additional"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    
	<span class="clear_space">&nbsp;</span>
    <h2 class="t">Additional Information</h2>
    <span class="clear_space">&nbsp;</span>




	<span class="bglbl">
        <span class="lbl_1">reason for consult/ history of present illness:</span>
        <span class="lbl_2"><?php echo $rowult["reason"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    
    
	<span class="lbl_1">onset<br>(first incident or recurrent problem):</span>
	<span class="lbl_2"><?php echo $rowult["onset"]; ?></span>
    <span class="clear_line">&nbsp;</span>
    

	<span class="bglbl">
        <span class="lbl_1">recurring  duration:</span>
        <span class="lbl_2"><?php echo $rowult["duration"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    
    
    <span class="lbl_1">progression or course:</span>
    <span class="lbl_2"><?php echo $rowult["progression"]; ?></span>
    <span class="clear_line">&nbsp;</span>
    
	<span class="bglbl">
        <span class="lbl_1">previous biopsy Y/N / results:</span>
        <span class="lbl_2"><strong><?php echo $rowp["pb"];?>.</strong> <? echo $rowp["priorbiopsy"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    
    
    <span class="lbl_1">recent laboratory work/cultures Y/N (suspected):</span>
    <span class="lbl_2"><strong><?php echo $rowult["pl"];?>.</strong> <?php echo $rowult["recentlabwork"]; ?></span>
    <span class="clear_line">&nbsp;</span>
    
	<span class="bglbl">
        <span class="lbl_1">recent symptoms:<br> (rash, itch, pain, fever, chills, nausea)</span>
        <span class="lbl_2"><?php echo $rowult["review"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    

    <span class="lbl_1">description of skin lesion:</span>
    <span class="lbl_2"><?php echo $rowult["descriptionofskinlesions"]; ?></span>
    <span class="clear_line">&nbsp;</span>
    
	<span class="bglbl">
        <span class="lbl_1">distribution:<br> (total body/diffuse, scalp, head-neck, trunk, extremities, hands and/or feet, genitalia/mucous membranes)</span>
        <span class="lbl_2"><?php echo $rowult["distribution"]; ?></span>
    </span>
    <span class="clear_line">&nbsp;</span>
    <?php //datos de doctor 
		$sqldoc = mysql_query("select suffix,name,lastname from doctor where id=".$rowp["doctorid"]."");
		$rowdoc = mysql_fetch_array($sqldoc);
		$formatreg = ObtenerMes(substr($rowp["registered"],5,2))."/".substr($rowp["registered"],8,2)."/".substr($rowp["registered"],0,4)." at ".substr($rowp["registered"],11,5);
		mysql_free_result($sqldoc);	
	 ?>
     
     
    <span class="lbl_1">comment on ship #1:</span>
    <span class="lbl_2"><?php echo str_replace("\n","<br>",$rowult["comment2"]); ?></span>
    <span class="clear_line">&nbsp;</span>
     
    <span class="lbl_1">&nbsp;</span>
    <span class="lbl_2"><img src="imgs/dr.png" border="0" style="vertical-align:text-bottom;"> <strong><?php echo $rowdoc["suffix"]; ?>. <?php echo $rowdoc["name"]." ".$rowdoc["lastname"]; ?>  - <?php echo $formatreg; ?></strong></span>
    <span class="clear_line">&nbsp;</span>

	
    
  
    
      <span class="clear_space">&nbsp;</span>
    <h2 class="t">Comments</h2>
    <span class="clear_space">&nbsp;</span>  
     <?
    	if($rowult["iddoctor"]=="0")
		{
	?>

    <span class="clear_line">&nbsp;</span>
    <?
	}
    ?>
   

    <span id="responsedrv"> 
    </span>
    
    <span id="visit">	
    </span>
   
    </td>
  
  </tr>
</table>

<script type="text/javascript">
LoadExamination();
//LoadVisit();
</script>


      </td>
  </tr>
</table>

<?php 
include("../../inc.foot.php"); ?>
		</div>
        <div data-role="footer">
            <h4>DIVOSH</h4>
        </div>

    </div>
</body>
</html>
