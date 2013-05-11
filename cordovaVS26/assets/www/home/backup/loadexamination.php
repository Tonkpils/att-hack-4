
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
	<span><?=$rowex["assessment"]?></span> 

</li>    






<li data-role="list-divider">
	<span>Suggested</span>
</li>
<li>
	<span><?=$rowex["suggested"]?></span>

</li>

<li data-role="list-divider">  
	<span>Comment</span>
</li>
<li>
	<span><?=$rowf["comment"]?></span>

</li> 

