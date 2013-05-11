<?php
//print_r($_POST);
header('Location: http://havirtualskindr.com/mobile/home/index.php');
include("../../includes/db.php");
include("../../includes/functions.php");
extract($_POST);


//$sql = mysql_query("select id from patient where name='".$name."' and lastname='".$lastname."'");
//$nrowssql = mysql_num_rows($sql);
$nrowssql = 0;

$targetPath = 'Uploadify/files/';


if(!($name && $lastname)){
	//return;
}
if(!$comment2){
	$comment2= 'No comment.';
}

if($nrowssql <= 0)
{
	if($period=="regular")
	{
		
		$regulardate = substr($dateregular,6,4)."/".substr($dateregular,3,2)."/".substr($dateregular,0,2);
	}
	$birth = "";
	if($birthday!="")
	{
		$birth = substr($birthday,6,4)."/".substr($birthday,3,2)."/".substr($birthday,0,2);
	}
	if($_POST["age"]=="")
	{
		$age = 0;
	}	
	mysql_query("insert into patient(id,password,name,lastname,phone,email,cruseid,comments,doctorid,registered
 				 ,age,sex,race,occupation,pastmedical,pastsurgical,personalfamilycancer,priorbiopsy,
  				rx,nonrx,period,dateperiod,birthdate,additional,ps,pb,ship
	)
	 values (".$idpatient.",'".$deviceID."','".$name."','".$lastname."','".$phone."','".$email."','".$cruseid."','".$comment2."',".'32'.",'".date("Y-m-d h:i:s")."'
	 ,".$age.",'".$sex."','".$race."','".$occupation."','".$pastmedical."','".$pastsurgical."','".$personalfamilycancer."',
	 	'".$priorbiopsy."','".$rx."','".$nonrx."','".$period."','".$regulardate."','".$birth."','".$additional."','".$ps."','".$pb."','".$ship."'
	 )");
	
	$id = $idpatient;
	
	$reviewsym ="";
	$k=0;
	$reviews = $_POST["rewiew"];
	 
	while($k<sizeof($reviews))
	{
		$reviewsym .= $reviews[$k];
		if(($k+1)<sizeof($reviews))
		{
			$reviewsym .= ",";
		}
		$k++;
	}
	
	$distribution = $_POST["distribution"];
	$distributioncom = "";
	$j=0;
	while($j<sizeof($distribution))
	{
		$distributioncom .= $distribution[$j];
		if(($j+1)<sizeof($distribution))
		{
			$distributioncom .= ",";
		}
		$j++;
	}
	
	
	$lesion = $_POST["descriptionofskinlesions"];
	$lesioncom = "";
	$j=0;
	while($j<sizeof($lesion))
	{
		$lesioncom .= $lesion[$j];
		if(($j+1)<sizeof($lesion))
		{
			$lesioncom .= ",";
		}
		$j++;
	}
	
	

	mysql_query("insert into cruise_patient(idcruise,idpatient,registered,status,comments,
	reason,onset,duration,progression,suspected,review,other,recentlabwork,descriptionofskinlesions,distribution,configuration,
	primarylesion,secondarychanges,generalizedbody,generalizedtrunk,headneck,extremities,
  	handsfeets,genitalia,code,examination,assestments,suggested,comment2,pl
	) 
	values('".$cruseid."',".$id.",'".date("Y-m-d")."','1','".$comment2."',
	'".$reason."','".$onset."','".$duration."','".$progression."','".$suspected."',
	'".$reviewsym."','".$other."','".$recentlabwork."','".$lesioncom."','".$distributioncom."',
	'".$configuration."','".$primarylesion."','".$secondarychanges."','".$generalizedbody."',
	'".$generalizedtrunk."','".$headneck."','".$extremities."','".$handsfeets."','".$genitalia."','".$code."'
	,'".$examination."','".$assestments."','".$suggested."','".$comment2."','".$pl."'
	)");

	$idcp = mysql_insert_id();
	
	//insert la visita

	
	mysql_query("insert into comments_visit(idvisit,idpatient,iddoctor,comment,registered,status,type)
	 values(".$idcp.",".$id.",".$_SESSION['doc_virtualskindr_idm'].",'".$comment2."','".date("Y-m-d h:i:s")."','1','1')");
	
	$sessid = session_id();
	$query = "UPDATE pictures_patient SET sessid='', idpatient='{$id}', idcruisepatient='{$idcp}'
		WHERE sessid='{$sessid}'";
	mysql_query($query);
	//echo $sessid;
	
	$To = "info@myvirtualskindr.com";
	$arraymails = array("winicius@gmail.com");
	$Subject = "My Virtual Skin Notification";
	$Header = "MIME-Version: 1.0\r\n";
	$Header .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$Header .= "From: Virtual Skin Dr <no-reply@myvirtualskindr.com>\r\n";
	$Header .= "Reply-To: Virtual Skin Dr <no-reply@myvirtualskindr.com>\n";
	$Header .= "X-Mailer: PHP/" . phpversion() . "\n";
	$Header .= "X-Priority: 3";
	$Message = "<font style='font-family:arial; font-size:12px; color:#000000;'>";
	$Message .= "<hr size='1'>Dr. ".$_SESSION['doc_virtualskindr_lastname']." has posted a new patient.<br><br>The following is the basic information:<br><br>";

			$Message .= "<strong>Date:</strong> " . date("Y-m-d") . "<br>";
			$Message .= "<strong>ID:</strong> " . $idpatient . "<br>";
			$Message .= "<strong>Last Name:</strong> " . $lastname . "<br>";
			$Message .= "<strong>First Name:</strong> " . $name . "<br>";
			$Message .= "<strong>Ship/Cruise ID:</strong> " . $cruseid . "<br>";
			
	$Message .= "<br>Please login at www.myvirtualskindr.com to view more<br><br>Regards,<br><br><Virtual Skin Dr.<br><br>";
	$Message .= "</font>";	
		
	
	$Message .= "</font>";
	//mail($To, $Subject, $Message, $Header);
	
	//consulto virtual skin activos
	$sqle = mysql_query("select email from doctor where type='DR V' and status='1'");
	while($rowe = mysql_fetch_array($sqle,MYSQL_ASSOC))
	//foreach($arraymails as $ca=>$val)
	{
		//mail($rowe["email"], $Subject, $Message, $Header);
	}
	mail('winicius@gmail.com', $Subject, $Message, $Header);
	
	mysql_free_result($sqle);

		//-------------------------------------------------------------------------------------------------
	//echo 1;


}

$data = array("success");
$err = array();
print_r(json_encode($data));


mysql_free_result($sql);	

?>
