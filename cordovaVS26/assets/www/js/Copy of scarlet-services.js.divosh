
function initDevice(){
	//alert("sssssCordova Initialized" + ii);
	onLoad();

}
function onLoad(){
	//change the href
	var go = 'http://havirtualskindr.com/mobile/home/cases.php?deviceID='+device.uuid+'&';
	$("#ddd").attr('href', go);
	var go = 'http://havirtualskindr.com/mobile/home/mobilehtml.php?deviceID='+device.uuid+'&';
	$("#mobilehtml").attr('href', go);
	alert("go=="+go);
}
//document.addEventListener("onload",onLoad,false);
document.addEventListener("deviceready",initDevice,false);
var codeimg=0;

function changeLink(obj){
	
	var go = obj.getAttribute('href');// + '?deviceID='+device.uuid+'&';
	document.location.href = go;
	alert('find a replacement for this changelink.');

	return false;

}
    // Wait for Cordova to load
    //
    
    $(document).ready(function() {
    	//initDevice();
      //onGPSDeviceReady();
	});
    //document.addEventListener("onload", onGPSDeviceReady, false);
    var watchID = null;

    function onGPSDeviceReady() {
        // Get the most accurate position updates available on the
        // device.
        var options = { enableHighAccuracy: true };
        
        
        if (navigator.geolocation){

        	watchID = navigator.geolocation.watchPosition(onGPSSuccess, onGPSError, options);
        	//navigator.geolocation.getCurrentPosition(onGPSSuccess, onGPSError);
        }else{
        	//var x = document.getElementById("geolocation");
        	//x.innerHTML="Geolocation is not supported by this browser.";
     	}
        
        
        
        //alert(watchID);
    }

    // onGPSSuccess Geolocation
    //
    
    function onGPSSuccess(position) {
        /*
    	alert("WATCHID");
        var element = document.getElementById('geolocation');
        element.innerHTML = 'Latitude: '  + position.coords.latitude      + '<br />' +
                            'Longitude: ' + position.coords.longitude     + '<br />' +
                            '<hr />'      + element.innerHTML;
                            */
	   	//$.get("test.php", { name: "John", time: "2pm" } );
	   	//PHPSESSID=744b1feecbb9fadaa56453b902a244cf      
        $.get("../../mobile.php", { PHPSESSID:sid, action: "addGPSData", lat: position.coords.latitude, lng: position.coords.longitude } );
                            
    }

    // clear the watch that was started earlier
    //
    function clearWatch() {

        if (watchID != null) {
            navigator.geolocation.clearWatch(watchID);
            watchID = null;
        }
        
        //alert("executed");
    }

    // onGPSError Callback receives a PositionGPSError object
    //
    function onGPSError(error) {
      alert('code: '    + error.code    + '\n' +
            'message: ' + error.message + '\n');
    }






    


 // Wait for Cordova to load
    //
    //document.addEventListener("deviceready", onDeviceReady, false);

    function uploadPhoto(imageURI) {
    	//display image so user can see it
    	// Uncomment to view the image file URI 
    	console.log('HELLOIMAGEURI');
		console.log(imageURI);
		/*
		// Get image handle
		//
		var smallImage = document.getElementById('smallImage');
		
		// Unhide image elements
		//
		smallImage.style.display = 'block';
		
		// Show the captured photo
		// The inline CSS rules are used to resize the image
		//
		smallImage.src = imageURI;
    	*/
    	
    	
    	
    	//upload image to server
        var options = new FileUploadOptions();

        options.fileKey="file";
        options.fileName=imageURI.substr(imageURI.lastIndexOf('/')+1);
        options.mimeType="image/jpeg";

        var params = {};
        params.time = time;
	params.codeimg=codeimg;
        options.params = params;

        var ft = new FileTransfer();
        ft.upload(imageURI, encodeURI("http://havirtualskindr.com/upload.php"), win, fail, options);
    }

    function win(r) {
        console.log("Code = " + r.responseCode);
        console.log("Response = " + r.response);
        console.log("Sent = " + r.bytesSent);


	$("#smallImage_"+codeimg).attr('src', 'http://havirtualskindr.com/Uploadify/files/' + r.response.trim() );

	$("#smallImage_"+codeimg).show();
	$("#ajax-loader_"+codeimg).hide();
    }

    function fail(error) {
        alert("An error has occurred: Code = " + error.code);
        console.log("upload error source " + error.source);
        console.log("upload error target " + error.target);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    var pictureSource;   // picture source
    var destinationType; // sets the format of returned value 


// Wait for Cordova to connect with the device
    //
    document.addEventListener("deviceready",onCameraReady,false);

    // Cordova is ready to be used!
    //
    function onCameraReady() {
        pictureSource=navigator.camera.PictureSourceType;
        destinationType=navigator.camera.DestinationType;
    }
    


    // Called when a photo is successfully retrieved
    //
    function onPhotoDataSuccess(imageData) {
      // Uncomment to view the base64 encoded image data
      // console.log(imageData);

      // Get image handle
      var smallImage = document.getElementById('smallImage');

      // Unhide image elements
      smallImage.style.display = 'block';

      // Show the captured photo
      // The inline CSS rules are used to resize the image
      smallImage.src = "data:image/jpeg;base64," + imageData;
    }

    // Called when a photo is successfully retrieved
    function onPhotoURISuccess(imageURI) {
      // Uncomment to view the image file URI 
      // console.log(imageURI);

      // Get image handle
      //
      var largeImage = document.getElementById('largeImage');

      // Unhide image elements
      //
      largeImage.style.display = 'block';

      // Show the captured photo
      // The inline CSS rules are used to resize the image
      //
      largeImage.src = imageURI;
    }
    
    //Get picture
    function aaa(){
        // Retrieve image file location from specified source
        navigator.camera.getPicture(uploadPhoto,
                                    function(message) { alert('get picture failed'); },
                                    { quality: 50, 
                                    destinationType: destinationType.FILE_URI,
                                    saveToPhotoAlbum: true
                                     }
                                    );

    }

    function aaa(a){
	codeimg = a;
	//alert(a);
        // Retrieve image file location from specified source

        navigator.camera.getPicture(uploadPhoto,
                                    onFail,
                                    { quality: 50, 
                                    destinationType: destinationType.FILE_URI,
                                    saveToPhotoAlbum: true
                                     }
                                    );

	$("#smallImage_"+codeimg).hide();
	$("#ajax-loader_"+codeimg).show();

    }

    // A button will call this function
    function capturePhoto() {
      // Take picture using device camera and retrieve image as base64-encoded string
      navigator.camera.getPicture(onPhotoDataSuccess, onFail, { quality: 50,
        destinationType: destinationType.DATA_URL });
    }
    
    /*
    function capturePhoto() {
        // Take picture using device camera and retrieve image as base64-encoded string
        navigator.camera.getPicture(onPhotoDataSuccess, onFail, { quality: 50,
          destinationType: destinationType.DATA_URL });
      }
*/
    // A button will call this function
    //
    function capturePhotoEdit() {
      // Take picture using device camera, allow edit, and retrieve image as base64-encoded string  
      navigator.camera.getPicture(onPhotoDataSuccess, onFail, { quality: 20, allowEdit: true,
        destinationType: destinationType.DATA_URL });
    }

    // A button will call this function
    //
/*
    function getPhoto(source) {
      // Retrieve image file location from specified source
      navigator.camera.getPicture(onPhotoURISuccess, onFail, { quality: 50, 
        destinationType: destinationType.FILE_URI,
        sourceType: source });
    }
*/

    function getPhoto(a) {
	codeimg = a;
      // Retrieve image file location from specified source
      navigator.camera.getPicture(uploadPhoto, onFail, { quality: 50, 
        destinationType: destinationType.FILE_URI,
        sourceType: pictureSource.PHOTOLIBRARY });

	$("#smallImage_"+codeimg).hide();
	$("#ajax-loader_"+codeimg).show();
    }
    // Called if something bad happens.
    // 
    function onFail(message) {
      alert('Failed because: ' + message);
	$("#smallImage_"+codeimg).show();
	$("#ajax-loader_"+codeimg).hide();
    }
