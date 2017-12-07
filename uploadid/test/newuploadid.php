<?php
/*
Template Name: New Upload ID
*/
?>



<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Transitec
 */

?>

<?php get_header() ?>

<div id="demo" style="text-align:center; max-width: 500px; margin: auto;">

	<form action="" method="POST" enctype="multipart/form-data" style='display:inline;'>
<!-- 		<fieldset>
			<legend>上传身份证</legend> -->
	  		<strong><label for="input_demo2" id="label2">输入身份证号码: </label></strong>
			<!-- <br class="rwd-break" /> -->
			<input type="text" name="ID" id='input_demo2'>
			<!-- <br class="rwd-break" /> -->
			<br>
			<!-- <label for="select_demo2" id="label3">身份证：1. </label>
			<br class="rwd-break" /> -->
	  		<!-- <select name="idSide" id='select_demo2'>
	    		<option value = "">请选择</option>
	    		<option value = "A">正面</option>
	    		<option value = "B">反面</option>
	  		</select><br class="rwd-break" /> -->
	    
	    	<label for="fileToUpload" id="label4">上传身份证正面：</label>
	    	<!-- <br class="rwd-break" /> -->
	    	<!--<input type="file" name="fileToUpload" id="fileToUpload" class="hidden" />-->
	    	<input type="file" name="fileToUpload" id="fileToUpload">
	    	<input type="submit" value="提交" name="submit" id='submit_demo2'>
	    	<br>
	    	<!-- <br class="rwd-break" /> -->
	</form>
	<form action="" method="POST" enctype="multipart/form-data" style='display:inline;'>
	    	<label for="fileToUpload2" id="label5">上传身份证背面：</label>
	    	<!-- <br class="rwd-break" /> -->
	    	<input type="file" name="fileToUpload2" id="fileToUpload2" >
	    	<input type="submit" value="提交" name="submit" id='submit_demo3'>
	    	<!-- <br class="rwd-break" /> -->
	    	<br>
<!--     	</fieldset> -->
	</form>
</div>

<?php


if(isset($_FILES['fileToUpload'])) 
{
	if ($_FILES['fileToUpload']['size'] == 0)
	{
		$result = "上传上传身份证正面图片不能为空，请重试。多谢！";
		echo "<p align='center'><font color = black size = '3pt'>" . $result . "</p>";
	}

	else 
	{
		$file_tmp= $_FILES['fileToUpload']['tmp_name'];
		$data = file_get_contents($file_tmp);
		$fileBase64 = base64_encode($data);
		// ID Number
		$idNumber = $_POST['ID'];
		$side = "A";

		if (strlen($idNumber) != 18) 
		{
	    	$result = "您输入的身份证号码不是18位，请重试。多谢！";
	    	echo "<p align='center'><font color = black size = '3pt'>" . $result . "</p>";
		}

		else 
		{
			$fileType = 'jpeg';
			
			//echo $side.PHP_EOL;
			// To Lowercase
			$fileBase64_lo = strtolower($fileBase64);
			$idNumber_lo = strtolower($idNumber);
			$fileType_lo = strtolower($fileType);
			$side_lo = strtolower($side);

			// Prepare for Encryption
			$fileString = '<uploadidfile><idnumber>' . $idNumber_lo . '</idnumber><fileextension>' . $fileType_lo . '</fileextension><filebase64>' . $fileBase64_lo . '</filebase64><idside>' .$side_lo . '</idside></uploadidfile>' . 'sz52FhYVKu';
			
			//Encryption
			$cryptograph = md5("$fileString");

			//To Post
			$data = 'content=<UploadIDFile><IDNumber>' . $idNumber . '</IDNumber><FileExtension>' . $fileType . '</FileExtension><FileBase64>' . $fileBase64 . '</FileBase64><IDSide>' . $side . '</IDSide></UploadIDFile>&messageType=UploadIDFile&partnerName=GTT&cryptograph=' . $cryptograph . '&version=1.0&format=xml';

			//Convert + sign in Base64 code
			$data = str_replace('+', '%2B', $data);

			//curl
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "http://api.gogtt.com/api");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8')); //setting content type header
			// curl_setopt($curl, CURLOPT_POSTFIELDS, urlencode($data));//Setting raw post data as xml
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$result = curl_exec($curl);
			curl_close($curl);

			//$result_sub = substr($result, 21, 23);
			echo "<p align='center'><font color = black size = '3pt'>" . $result . "</p>";
		}
	}
}

elseif (isset($_FILES['fileToUpload2'])) 
{
	if ($_FILES['fileToUpload2']['size'] == 0)
	{
		$result = "上传身份证背面图片不能为空，请重试。多谢！";
		echo "<p align='center'><font color = black size = '3pt'>" . $result . "</p>";
	}

	else 
	{
		$file_tmp= $_FILES['fileToUpload2']['tmp_name'];
		$data = file_get_contents($file_tmp);
		$fileBase64 = base64_encode($data);
		// ID Number
		$idNumber = $_POST['ID'];
		$side = "B";

		if (strlen($idNumber) != 18) 
		{
	    	$result = "您输入的身份证号码不是18位，请重试。多谢！";
	    	echo "<p align='center'><font color = black size = '3pt'>" . $result . "</p>";
		}

		else 
		{
			$fileType = 'jpeg';
			
			//echo $side.PHP_EOL;
			// To Lowercase
			$fileBase64_lo = strtolower($fileBase64);
			$idNumber_lo = strtolower($idNumber);
			$fileType_lo = strtolower($fileType);
			$side_lo = strtolower($side);

			// Prepare for Encryption
			$fileString = '<uploadidfile><idnumber>' . $idNumber_lo . '</idnumber><fileextension>' . $fileType_lo . '</fileextension><filebase64>' . $fileBase64_lo . '</filebase64><idside>' .$side_lo . '</idside></uploadidfile>' . 'sz52FhYVKu';
			
			//Encryption
			$cryptograph = md5("$fileString");

			//To Post
			$data = 'content=<UploadIDFile><IDNumber>' . $idNumber . '</IDNumber><FileExtension>' . $fileType . '</FileExtension><FileBase64>' . $fileBase64 . '</FileBase64><IDSide>' . $side . '</IDSide></UploadIDFile>&messageType=UploadIDFile&partnerName=GTT&cryptograph=' . $cryptograph . '&version=1.0&format=xml';

			//Convert + sign in Base64 code
			$data = str_replace('+', '%2B', $data);

			//curl
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "http://api.gogtt.com/api");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8')); //setting content type header
			// curl_setopt($curl, CURLOPT_POSTFIELDS, urlencode($data));//Setting raw post data as xml
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$result = curl_exec($curl);
			curl_close($curl);

			//$result_sub = substr($result, 21, 23);
			echo "<p align='center'><font color = black size = '3pt'>" . $result . "</p>";
		}
	}
}
		


while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/page/content', 'page' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

endwhile; // End of the loop.

get_footer();