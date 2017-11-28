<?
$maxconn = array(100,200,300,400,500,600);
$status_server = 0 ;	
$status_rep = 0 ;
$hostcatti = "192.168.2.2";
$hostcatti2 = "202.129.35.98";
$hostcatti3 = "202.129.0.39";

$smsgetstatus=true;	

$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

$host="localhost";$username="root";$pwd= "SPRD525@sapphire";
$database_sys = "system_monitor";
//========================
$hostsms ="www.sms.in.th";
$method="POST";
$path="/tunnel/sendsms.php";

$Sender="SystemMonitor";
$MsgType="T";
$User="sapphire";
$Password="es53y7h";

//========================

$arr_ip = array(

	"61.19.255.74"=>array(
		"comname"=>"DCY MASTER SERVER",
		"hardware"=>"DL380G6",
		"localIP"=>"61.19.255.74",
		"username"=>"dba",
		"pwd"=>"dba@dcy",
		"functional"=>"DATABASE SERVER",
		"picture"=>"ML350.gif",
		"IPcaption"=>"61.19.255.74",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"DATABASE SERVER"
	),
	
	"61.19.255.79"=>array(
		"comname"=>"DCY SLAVE SERVER",
		"hardware"=>"DL380G6",
		"localIP"=>"61.19.255.79",
		"username"=>"dba",
		"pwd"=>"dba@dcy",
		"functional"=>"MASTER SERVER",
		"picture"=>"ML350.gif",
		"IPcaption"=>"61.19.255.79",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"MASTER SERVER"
	)
);


//*********** Network Circuit Config ************* 
/*
$hostcacti = "192.168.2.2";
$network_con = array( "CAT LEASE LINE"=>array("graph_id"=>"6","ipusage"=>"202.129.35.98","functional"=>"VC South<br>VC Central<br>VC NorthEast#1<br>VC NorthEast#2<br>VC MASTER<br>VC North") );
*/

$hostcacti = "192.168.2.2";
$network_con = array( "SAPPHIRE SERVER"=>array("graph_id"=>"6","ipusage"=>"202.129.35.98","functional"=>"VC South<br>VC Central<br>VC NorthEast#1<br>VC NorthEast#2<br>VC MASTER<br>VC North"),"APP SERVER"=>array("graph_id"=>"120","ipusage"=>"202.129.0.39","functional"=>"61.19.255.75"),"DB SERVER"=>array("graph_id"=>"121","ipusage"=>"202.129.0.39","functional"=>"61.19.255.74"),"SYR SERVER"=>array("graph_id"=>"305","ipusage"=>"202.129.0.39","functional"=>"61.19.255.77"),"SYR GRAPH SERVER"=>array("graph_id"=>"306","ipusage"=>"202.129.0.39","functional"=>"61.19.255.78") );



//*********เช็คว่าอยู่ใน Local **********
/*
if( (substr($_SERVER["REMOTE_ADDR"],0,8) != "192.168.") && ( $_SERVER["REMOTE_ADDR"] != "202.129.35.98" )){

	echo "<SCRIPT language=JavaScript>";
	echo "alert('คุณไม่สามารถใช้งานระบบผ่าน Internet ได้ กรุณาใช้งานผ่าน Intranet');";
	echo "</script>";
	die;

}
*/
?>
