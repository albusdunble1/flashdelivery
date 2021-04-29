<?php
require_once '../../../BusinessServiceLayer/controller/spController.php';
$serviceProvider = new spController();

if(isset($_POST['regs-submit']))
{
	$serviceProvider->regsSP();

}
?>
<!DOCTYPE html>
<html>
<head>
<title> Register Service Provider</title>
<link rel="stylesheet"  href="../../../assets/css/style.css">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>

  <img class="wave" src="../../../uploads/businessman.png">
  <form action="" method="POST" enctype="multipart/form-data">
	<div class="loginboxrunner">
		<h1>REGISTER SERVICE PROVIDER</h1>
		
    <div class="containar">
			<div class="imagefill" rowspan="3">
				<img class="imageborder" src="../../../uploads/white.jpg" id="image" name="SpImage" alt="white" width="70" height="75" border="2" overflow:hidden;>
				
					<div class="buttonSelect"><button type="button" name="button" onclick="document.getElementById('fileName').click()">Select File
					</button>
					<input type="file" name="photoFile" id="fileName" style="display: none">
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                  <button type="button" name="button" onclick="document.getElementById('uploadFile').click()">Upload Photo</button>
                  <input type='button' id="uploadFile" style="display:none" onclick="return readURL();">
				</div>

				
			</div>

			<div class="fillbox1">
				<input type="text" placeholder="Name" name="SpName" required></div>

			<div class="fillbox1"><input type="email" placeholder="Email" name="SpEmail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required></div>

			<div class="fillbox1"><input type="text" placeholder="No. Phone" name="SpPhoneNo" required></div>

			<div class="fillbox1"><input type="Password" placeholder="Password" name="SpPassword" required></div>

      <div class="fillbox1"><input type="text" placeholder="Register ID" name="SpRegID" required></div>

      <div class="fillbox1"><input type="text" placeholder="Address" name="SpAddress" required></div>

      <div class="fillbox1">
        <select name="SpType" required>
                    <option value="">Type of Service Provider</option>
                    <option value="Goods">Goods</option>
                    <option value="Food">Food</option>
                    <option value="Pet">Pet</option>
                    <option value="Medical">Medical</option>
                    
                </select></div>

      <div class="link-register">
      <a href="../../../ApplicationLayer/view/ServiceProvider/loginSP.php">Click to Login</a>
      </div>
			<div class="button2">
			<input class="btn" type="submit"  name="regs-submit" value="Register"></div>




	
	</form>
	</div>
<script>
  
  var fileName,input;
  var input = document.getElementById( 'fileName' );
  input.addEventListener( 'change', showFileName );

  function showFileName( event ) {
    // the change event gives us the input it occurred in
   input = event.srcElement;
  // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
   fileName = input.files[0].name;

  document.getElementById( 'photoImage' ).value = fileName ;
  }


    function readURL() {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

      reader.onload = function(e) {
        $('#image').attr('src', e.target.result);
      }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
          }
      }

      function validate(){
        var nme = document.getElementById("fileName");
          if(nme.value.length < 4) {
              alert('Must Select any of your photo for upload!');
              nme.focus();
              return false;
            }
        }


</script>
</body>
</html>