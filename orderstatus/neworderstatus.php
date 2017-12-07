<?php
/*
Template Name: New Order Status
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
	<form action='<?php the_permalink(); ?>' method='post' style='display:inline;' id='demo1'>	  
		<fieldset>
			<legend>查询订单编号</legend>  
			<label for="orderID" id="label1">查询订单编号: </label>
			<br class="rwd-break" />
			<input type='text' name='orderID' id = 'input_demo1'>
			<input type='submit' value = '提交' id = 'submit_demo1'>
			<br class="rwd-break" />
		</fieldset>
	</form>
</div>

<?php

if (isset($_POST['orderID'])) 
{
    $orderNumber = $_POST['orderID'];
	$orderString = '<getordertracking><ordernumber>' . $orderNumber . '</ordernumber></getordertracking>' . 'sz52FhYVKu';

	//print $orderString;
	$cryptograph = md5($orderString);
	//print $cryptograph;
	$data = 'content=<GetOrderTracking><OrderNumber>' . $orderNumber . '</OrderNumber></GetOrderTracking>&messageType=GetOrderTracking&partnerName=GTT&cryptograph=' . $cryptograph . '&version=1.0&format=xml';

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "http://api.gogtt.com/api");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8')); //setting content type header
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//Setting raw post data as xml
	$result = curl_exec($curl);
	curl_close($curl);

	//$result_sub = substr($result, 34, -11);
	echo "<p align='center'><font color = black size = '3pt'><br>";

	for ($i=0; $i < strlen($result); $i++)
	{
		if (substr($result, $i, 4) == "true") 
		{
		    $i = $i+3;
		}

		elseif (substr($result, $i-6, 6) == "<Time>") 
		{
			echo $result[$i]."<strong>";
		}
		
		elseif (substr($result, $i-7, 7) == "</Time>") 
		{
			echo $result[$i]."</strong>";
		}
		
		elseif ($i>1 && substr($result, $i-16, 16) == "</TrackingEvent>") 
		{
			echo $result[$i]."<br><br>";
		}

		else 
		{
			echo $result[$i];
		}
	}

	echo "</p>";

}


while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/page/content', 'page' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

endwhile; // End of the loop.

get_footer();