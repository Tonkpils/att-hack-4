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

    <div data-role="page" id="send-page">
    	<script>
			function submitMainForm()
			{
				
				formData = $("#main-form").serialize();
				$.getJSON( "../api/submitMainForm.php", formData).done(
					function( data ){
						console.log(data);
						success= Boolean(parseInt(data['data'][0]['success']));
						msg = String(data['error']['message']);
						alert(success);
						if(success)
						{
							alert(msg);
						}
						else
						{
							alert(msg);
						}
					}
				)
			}
		</script>
        <div id="header" data-role="header" data-theme="a" data-position="fixed">
            <h1>Skin Doctor</h1>
        </div>
        <div data-role="content">
        	<span>Snapshot</span>
            <form id="main-form">
            <div>
                <div class="image-selector"> 
                    <div class="image-preview-container">
                        <img class="image-preview" src="../css/image-selector-placeholder.png"/>				
                    </div>
                    <input class="image-field" type="hidden" id="snapshot-field" name="snapshot" />
                    <div class="image-footer">
                        <!--icons-->
                        <a class="image-icon-link camera-icon"><span class="image-icon camera-icon"></span></a>
                        <a class="image-icon-link browse-icon"><span class="image-icon browse-icon"></span></a>
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
                        <a class="image-icon-link camera-icon"><span class="image-icon camera-icon"></span></a>
                        <a class="image-icon-link browse-icon"><span class="image-icon browse-icon"></span></a>
                        <a class="image-icon-link delete-icon"><span class="image-icon delete-icon"></span></a>
                    </div>
                </div>
            </div>
        	<input type="text" placeholder="Age" id="age-field" name="age"/>
            <input type="text" placeholder="Gender" id="gender-field" name="gender"/>
            <input type="text" placeholder="Description" id="description-field" name="description"/>
            <input type="text" placeholder="Duration" id="duration-field" name="duration"/>
            <input type="text" placeholder="Symptoms" id="symptoms-field" name="symptoms"/>
            <input type="text" placeholder="Unprotected sex?" id="unprotected-sex-field" name="unprotected-sex"/>
            <input type="text" placeholder="Other Diseases" id="age-field" name="age"/>
            </form>
            
            <div data-role="button" onclick="submitMainForm();">Submit</div>
            
        </div>
        <div data-role="footer">
            <h4>DIVOSH</h4>
        </div>
    
    </div>

</body>
</html>