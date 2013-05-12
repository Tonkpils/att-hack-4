 <?php
// require the Harvest API core class 
require_once( "HaPi" . '/HarvestAPI.php' );
require_once( "HaPi" . '/HarvestReports.php' );

// register the class auto loader 
spl_autoload_register( array('HarvestAPI', 'autoload') );

// instantiate the api object 
$api = new HarvestAPI(); 
$api->setUser( "lcorr005@gmail.com" ); 
$api->setPassword( "Lince98" ); 
$api->setAccount( "awesomefirm" ); 


$allClientsReq = $api->getClients();
if( $allClientsReq->isSuccess() ) {
	$clients = $allClientsReq->data;
	print("<table>");
	foreach ($clients as $key => $value) {
		print("<tr>");
		echo "<td>Client ID: $key </td><td>Client name: ".$value->get( 'name' )."</td>";
		print("</tr>");
	}
	print("</table>");

}