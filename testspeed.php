<?  

/*** Bandwidth Tester 0.92 ***/ 
/* Please wait for 1.0 patiently! */ 
// How many bytes to test with. Mimimum=70. 128KB=131072. 1MB=1048576 

$testsize = 131072; 

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
                                                      // always modified 
header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1 
header ("Pragma: no-cache");                          // HTTP/1.0 
header ("X-Notice: "); 
header ("X-Notice: Bandwidth-Tester is freeware."); 
header ("X-Notice: You may use it freely on your site."); 
header ("X-Notice: Just don't remove this notice."); 
header ("X-Notice: To get the source code, run this script "); 
header ("X-Notice: with downloadme=1 in the query string."); 
       
  
  
  
/* How does it work? The script generates a variable amount of random data 
 * sends it to the client and measures the time taken for transmission. The 
 * bandwidth is then calculated from the time using a simple algorithm. 
 * 
 * WARNING: This script can bog down your server - as absolutely NO 
 *          optimization was used. 
 * 
 * 
 * This script is best run on the Zend PHP Engine, with Zend Optimizer. 
 * Any improvement in performance is not guaranteed with other 
 * PHP Engines. 
 *  
 * History:  
 *          0.9 - First public release 
 *         0.91 - Reduced the size of the timing code 
 *         0.92 - Reduced the size of the timing code even more 
 * Forecast: 
 *       0.921a - Adding a smaller test before the main to make results more accurate and to adjust test data according to first results 
 *          1.0 - Looking to adding optimization code 
 *          1.1 - Adding template support 
 *          1.2 - Adding web-based administration 
 */ 
  
  
  
  
if($downloadme==1){ 
echo "<html><body>"; 
show_source($SCRIPT_FILENAME); 
echo "</body></html>"; 
} 
else { 

// First, initialize the test comment 


// seed random 
srand ((double) microtime() * 1000000); 

if($testsize<70) {die("<script>alert('The test string size is less than 70. Cannot test.')</script>"); 
} 
$realtestsize = $testsize - 70; 
function GetTestString($drealtestsize){ 
	$duhteststring = "<!"."--"; 
	for($i=0;$i<$drealtestsize; $i++){ 
	$duhteststring .= generatekeycode(); 
	} 
	$duhteststring .= "-"."->"; 
	return $duhteststring; 
} 
function CalculateBandwidth($Ditt,$Dott){ 
	$Datasize=$Dott; 
	$LS=$Datasize/$Ditt; 
	$kbps=(($LS*8)*10*1.02)/10; 
	$mbps=$kbps/1024; 
	if($mbps>=1){$speed=$mbps." Mbps aka ".$kbps." Kbps";} 
	else {$speed=$kbps." Kbps aka ".$mbps." Mbps";} 
	$speed .="<br>Time taken to test connection: ".(($Ditt*1024)/1000)." Seconds <br>A number used to determine your speed: ".$LS."<br>Another number used to determine your speed: ".$Ditt."<br>Tested your connection with ".$Datasize."Bytes/".($Datasize/1024)."KB/".($Datasize/1048576)."MB of random data<br>"; 
	return $speed; 
} 

function generatekeycode(){ 
	// srand ((double) microtime() * 1000000); 
	// Made the randomizer a little more "random"! :) 
	srand ((double) microtime() * rand(100000,1000000) / rand(1,15)); 
	$tester = rand(33,255); 
	if($tester==45)return generatekeycode(); 
	return chr($tester); 
} 
?>
<html> 
<head><title>Bandwidth Tester</title></head> 
<body>
<? 
if($HTTP_SERVER_VARS["REQUEST_METHOD"]=="GET" && $HTTP_GET_VARS["execute"]!="1"){ 
?>
<form action="<?=$HTTP_SERVER_VARS['SCRIPT_NAME']?>" method="GET">
<input type="submit" value="Click Here To Begin Testing" onClick="this.value='Please wait while your request is being processed, it may take a while'"> 
<input type="hidden" name="execute" value="1"> 
<input type="hidden" name="DO.NOT.CACHE" value="<?=rand(255,65536)?>"> 
</form>
<?
}elseif($HTTP_GET_VARS["execute"]=="1"){ 
$teststring=GetTestString($realtestsize);
?>
<form method="POST" action="<?=$HTTP_SERVER_VARS['SCRIPT_NAME']?>"> 
<input type="hidden" name="td" value="No Test"> 
<input type="button" value="Please wait while your request is being processed, it may take a while"> 
</form> 
<script language="JavaScript"> 
var Hi = new Date(); 
</script><?=$teststring?><script language="JavaScript"> 
var Bye = new Date(); 
var NiHao = new Array(Hi.getTime(),Bye.getTime()); 
var Factor=1024; 
if(NiHao[1]==NiHao[0]) 
Ditt=0; 
else 
Ditt=(NiHao[1]-NiHao[0])/Factor; 
document.forms[0].elements[0].value=Ditt; 
document.forms[0].submit(); 
</script>
<p>Tested. Now processing your request....</p>
<?
}elseif($HTTP_SERVER_VARS["REQUEST_METHOD"]=="POST"&&$HTTP_POST_VARS["td"]>0){ 
?>
<p>your Internet connection.<br> 
Speed you connected  is 
  <?=CalculateBandwidth($HTTP_POST_VARS["td"],$testsize)?><br> 
<a href="?downloadme=1">Would you like one of these on your site? Click here.</a> 
</p>
<?
}elseif($HTTP_SERVER_VARS["REQUEST_METHOD"]=="POST"&&$HTTP_POST_VARS["td"]==0){ 
?>
<p>We were unable to test your connection speed.<br>It was too fast to measure.<br> 
<a href="<?=$HTTP_SERVER_VARS['SCRIPT_NAME']?>?execute=1&DO.NOT.CACHE=<?=rand(255,65536)?>" onClick="this.innerText='The system is now generating the random test data to benchmark your connection speed. It will take a while ">If you would like to try testing again, click here.</a></p> 
<p><?=CalculateBandwidth($HTTP_POST_VARS["td"],$testsize)?></p> 
<? } ?> 
</body> 
</html>
<? } ?> 