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


</head>


<body>

    <div data-role="page" id="cases-page">
    
        <div id="header" data-role="header" data-theme="a" data-position="fixed">
            <h1>Skin Doctor</h1>
        </div>
        <div data-role="content">
        	<div class="add-a-case-container" >
		       <?php
			
			print_r($_POST);
			?>
            </div>
        
        </div>
        <div data-role="footer">
            <h4>DIVOSH</h4>
        </div>
    
    </div>

</body>
</html>
