<?php
session_start();
extract($_POST);
include("../../includes/db.php");
include("../../includes/functions.php");


$id = $_GET["id"];
if($id=="")
{
	$id=$_POST["id"];
}



$sqlp = mysql_query("select * from patient where id=".mysql_real_escape_string($id).""); 
$rowp = mysql_fetch_array($sqlp,MYSQL_ASSOC);


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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<?php
	function curPageName() {
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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



<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<script type="text/javascript">

	$(document).ready(function() {

		$("a.gallery").fancybox({
			'titleShow'		: true,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		});

	});

</script>

</head>

<body class="inPages">
<?php include("../../inc-main.php"); ?>
<table width="1244" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="450" align="left" valign="top" class="inPage">
    
    <?php include("../../inc-menu.php"); ?>



<?php 
//print_r($_SESSION);
if($_SESSION["doc_virtualskindr_type"]=="DR V")
{
?>
     <p><a href="edit-patient.php?idp=<?php echo $id; ?>">Edit this patient</a>
     <!--| <a href="new-register.php?idp=<?php echo $id; ?>">Add New Record of this patient</a>
	  | <a href="view-history.php?idp=<?php echo $id; ?>">View history</a>-->
      </p>
<?php
}
else
{
	//echo $rowp["doctorid"];echo "zxczxzx";	
	if($rowp["doctorid"]==$_SESSION["doc_virtualskindr_idm"])
	{
?>
    <p><a href="edit-patient.php?idp=<?php echo $id; ?>">Edit this patient</a>
    <!--| <a href="new-register.php?idp=<?php echo $id; ?>">Add New Record of this patient</a>
	  | <a href="view-history.php?idp=<?php echo $id; ?>">View history</a>
      -->
	</p>
<?
	}
}
?>


      <h1>Patient</h1>
      <div id="clear">&nbsp;</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="800" align="left" valign="top" style="width:800px;">

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
	<form action="<?php $_SERVER['PHP_SELF']; ?>" name="formu" id="formu" method="post">
         <span class="bglbl">
        <span class="lbl_1">examination (based on clinical images):</span>
        <span class="lbl_2">
        <div class="inputTA1">
        <textarea name="examination" id="examination"></textarea>
        </div>
        </span>
        </span>
        <span class="clear_line">&nbsp;</span>
        <span class="lbl_1">assessment / diagnoses:</span>
		 <span class="lbl_2">
        <div class="inputTA1">
        <textarea name="assestments" id="assestments"></textarea>
        </div> 
        </span>
        <span class="clear_line">&nbsp;</span>
         <span class="bglbl">
        <span class="lbl_1">suggested treatment:</span>
		 <span class="lbl_2">
        <div class="inputTA1">
        <textarea name="suggested" id="suggested"></textarea>
        </div> 
        </span>
        </span>
        <span class="clear_line">&nbsp;</span>
        <span class="lbl_1">signature/comments:</span>
		 <span class="lbl_2">
        <div class="inputTA1">
        <textarea name="comment3" id="comment3"></textarea>
        </div> 
        </span>
        <span class="clear_line">&nbsp;</span>               

    <span class="lbl_1"><input type="hidden" name="id" id="id" value="<?php echo $id; ?>"><input type="hidden" name="action" value="addvisit"><input type="hidden" name="send" value="Send"></span>
    <span class="lbl_2" id="button1"><a href="javascript:validate();" class="btnNew">Submit &raquo;</a></span>
    <span class="loader" id="loading"><img src="imgs/loading.gif" border="0" style="vertical-align:text-bottom; padding-right:5px;">Processing, please wait...</span>
    <span class="clear_line">&nbsp;</span>
	</span>
        
    </form>
    <span class="clear_line">&nbsp;</span>
    <?
	}
    ?>
   
   
   
    <span id="responsedrv"> 
    </span>
    
    <span id="visit">	
    </span>
    
   
    <span id="responses">
    <span class="lbl_1">response:</span>
    <span class="lbl_2">
    	<form class="frm1">
        	<textarea name="comres" id="comres" class="ta1"></textarea>
        </form>
    </span>
    <span class="clear_line">&nbsp;</span>
    
    <span class="lbl_1">&nbsp;</span>
    <span class="lbl_2" id="button1">
    <a href="javascript:;" class="btnNew submit1">Submit &raquo;</a>
    <a href="javascript:popup('pdf.php?id=<?php echo $id; ?>', 800, 800)" class="btnNew">
    Convert to PDF</a>
    </span>
    <span class="loader" id="loading"><img src="imgs/loading.gif" border="0" style="vertical-align:text-bottom; padding-right:5px;">Processing, please wait...</span>
    <span class="clear_line">&nbsp;</span>
	</span>
        
    
    </td>
    <td width="424" align="left" valign="top" class="pix">
    
    <h1>Be sure to include the following camera shots:</h1>
    
    <h2>Picture #1: Distribution (anatomic location should be obvious)</h2>
    <ul>
        <li>Stand back a few feet from your subject.
        <li>Fill the frame with half of the subject’s body.
    </ul>
    <p>				
                      	<?
                      }
						else
						{
					?>
                    <a href="javascript:;"><img src="imgs/na.gif" width="380" height="380" border="0"></a>
                    <?
						}
					  }
					  else
						{
					?>
                    <a href="javascript:;"><img src="imgs/na.gif" width="380" height="380" border="0"></a>
                    <?
						}
					  mysql_free_result($sqli);
					  ?>
    </p>  
    <span class="clear_line_right">&nbsp;</span>

    <h2>Picture #2: Close-up (anterior-posterior/straight on; include ruler and pt. ID)</h2>
    <ul>
        <li>Move in closer and take a picture of the involved area. (May take additional close ups if necessary.)
    </ul>
    <p>
    <?php 
			$sqli = mysql_query("select * from pictures_patient where idcruisepatient=".$idult." and codeimg=2");
			$nrowsi = mysql_num_rows($sqli);
		   if($nrowsi > 0) 
			  {
					$rowi = mysql_fetch_array($sqli,MYSQL_ASSOC);
					if(($rowi["picture"]!="")&&(file_exists("Uploadify/files/".$rowi["picture"])))
					{
						 ?>
						<a href="imgs_handler/phpThumb.php?src=../Uploadify/files/<?php echo $rowi["picture"]; ?>&w=600&h=600" class="gallery" title="<?php echo $rowi["title"]; ?>"><img src="imgs_handler/phpThumb.php?src=../Uploadify/files/<?php echo $rowi["picture"]; ?>&w=390" border="0"></a>
				<?
			  }
				else
				{
					?>
                    <a href="javascript:;"><img src="imgs/na.gif" width="380" height="380" border="0"></a>
                    <?
				}
			  }
			  else
				{
					?>
                    <a href="javascript:;"><img src="imgs/na.gif" width="380" height="380" border="0"></a>
                    <?
				}
			  mysql_free_result($sqli);
			  ?>
    </p>  
    <span class="clear_line_right">&nbsp;</span>

    <h2>Picture #3: Close-up (oblique/lateral/lesion side view (shows countour); include ruler and pt. ID)</h2>
    <ul>
        <li>Move either the camera or the subject to get a 45-degree angle photo of the lesion.
    </ul>
    <p>
    <?php 
			$sqli = mysql_query("select * from pictures_patient where idcruisepatient=".$idult." and codeimg=3");
			$nrowsi = mysql_num_rows($sqli);
		   if($nrowsi > 0) 
			  {
					$rowi = mysql_fetch_array($sqli,MYSQL_ASSOC);
					if(($rowi["picture"]!="")&&(file_exists("Uploadify/files/".$rowi["picture"])))
					{
						 ?>
						<a href="imgs_handler/phpThumb.php?src=../Uploadify/files/<?php echo $rowi["picture"]; ?>&w=600&h=600" class="gallery" title="<?php echo $rowi["title"]; ?>"><img src="imgs_handler/phpThumb.php?src=../Uploadify/files/<?php echo $rowi["picture"]; ?>&w=390" border="0"></a>
				<?
			  }
				else
				{
					?>
                    <a href="javascript:;"><img src="imgs/na.gif" width="380" height="380" border="0"></a>
                    <?
				}
			  }
			  else
				{
					?>
                    <a href="javascript:;"><img src="imgs/na.gif" width="380" height="380" border="0"></a>
                    <?
				}
			  mysql_free_result($sqli);
			  ?>
    </p>  
    
    <span class="clear_line_right">&nbsp;</span>

    <h2>Picture #4: Additional</h2>
    <p>
    <?php 
			$sqli = mysql_query("select * from pictures_patient where idcruisepatient=".$idult." and codeimg=4");
			$nrowsi = mysql_num_rows($sqli);
		   if($nrowsi > 0) 
			  {
					$rowi = mysql_fetch_array($sqli,MYSQL_ASSOC);
					if(($rowi["picture"]!="")&&(file_exists("Uploadify/files/".$rowi["picture"])))
					{
						 ?>
						<a href="imgs_handler/phpThumb.php?src=../Uploadify/files/<?php echo $rowi["picture"]; ?>&w=600&h=600" class="gallery" title="<?php echo $rowi["title"]; ?>"><img src="imgs_handler/phpThumb.php?src=../Uploadify/files/<?php echo $rowi["picture"]; ?>&w=390" border="0"></a>
				<?
			      }
				else
				{
					?>
                    <a href="javascript:;"><img src="imgs/na.gif" width="380" height="380" border="0"></a>
                    <?
				}
			  }
			  else
				{
					?>
                    <a href="javascript:;"><img src="imgs/na.gif" width="380" height="380" border="0"></a>
                    <?
				}
			  mysql_free_result($sqli);
			  ?>
    </p>  
    
    
    <span class="clear_line_right">&nbsp;</span>
    
    

    
    </td>
  </tr>
</table>

<script type="text/javascript">
$("#loading").css({display:"none"});
<?php 
if($rowult["iddoctor"]=="0")
{
?>
$("#responses").css({display:"none"});
//document.getElementById("responses").style.display = 'none';
<?
}

if($_SESSION["doc_virtualskindr_type"]!="DR V")
{
?>
$("#formu").css({display:"none"});
<?
}


?>
LoadExamination();
//LoadVisit();
</script>


      </td>
  </tr>
</table>

<?php 
mysql_free_result($sqlp);
include("../../inc.foot.php"); ?>
</body>
</html>
