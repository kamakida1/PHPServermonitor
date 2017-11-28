<?
$maxconn = array(100,200,300,400,500,600);
$status_server = 0 ;	
$status_rep = 0 ;
$hostcatti = "192.168.2.2";
$hostcatti2 = "202.129.35.98";

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
		"comname"=>"DATABASE SERVER",
		"hardware"=>"DL380G6",
		"localIP"=>"61.19.255.74",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"DATABASE SERVER",
		"picture"=>"ML350.gif",
		"IPcaption"=>"61.19.255.74",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"DATABASE SERVER"
	),
	
	"61.19.255.75"=>array(
		"comname"=>"MASTER SERVER",
		"hardware"=>"DL380G6",
		"localIP"=>"61.19.255.75",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"MASTER SERVER",
		"picture"=>"ML350.gif",
		"IPcaption"=>"61.19.255.75",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"MASTER SERVER"
	),

	"202.129.35.104"=>array(
		"comname"=>"INTRANET",
		"hardware"=>"HP DL380 G5",
		"localIP"=>"192.168.2.12",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"INTRA_SERVER",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.104",
		"gid_net"=>"1",
		"gid_mem"=>"1",
		"local_th"=>"CMSS,ALL APP"
	),
	
	"61.19.255.194"=>array(
		"comname"=>"File Master",
		"hardware"=>"HP DL380 G6",
		"localIP"=>"61.19.255.194",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"FILEMASTER",
		"picture"=>"ML350.gif",
		"IPcaption"=>"61.19.255.194",
		"gid_net"=>"1",
		"gid_mem"=>"1",
		"local_th"=>"โครงการภายใต้สังกัด กองประสานโครงการสายใยรักแห่งครอบครัว"
	),
	
	"123.242.173.130"=>array(
		"comname"=>"PTN",
		"hardware"=>"HP ML350 G5",
		"localIP"=>"123.242.173.130",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"CMSS",
		"picture"=>"IBM_XSERIES226.gif",
		"IPcaption"=>"123.242.173.130",
		"gid_net"=>"30",
		"gid_mem"=>"12",
		"local_th"=>"MASTER26"
	),
	
/*	"202.129.35.103"=>array(
		"comname"=>"VC NorthEastern#2",
		"hardware"=>"IBM X 3200",
		"localIP"=>"192.168.2.16",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"VC,CMSS NorthEastern#2",
		"picture"=>"IBM_XSERIES226.gif",
		"IPcaption"=>"202.129.35.103",
		"gid_net"=>"30",
		"gid_mem"=>"1",
		"local_th"=>"ภาคตะวันออกเฉียงเหนือ 2"
	),*/
	
	"202.129.35.98"=>array(
		"comname"=>"FireWall",
		"hardware"=>"IBM X SERVER",
		"localIP"=>"192.168.2.2",
		"username"=>"root",
		"pwd"=>"0832008007",
		"functional"=>"FireWall",
		"picture"=>"ACER_ALTOS350.gif",
		"IPcaption"=>"202.129.35.98",
		"gid_net"=>"63",
		"gid_mem"=>"1",
		"local_th"=>"FireWall
	"),
	
	"202.129.35.101"=>array(
		"comname"=>"FaceAccess",
		"hardware"=>"ML350",
		"localIP"=>"192.168.2.101",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"FaceAccess",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.101",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"FaceAccess"
	),
	
/*	"202.129.35.105"=>array(
		"comname"=>"SDOC",
		"hardware"=>"IBM X226",
		"localIP"=>"192.168.2.103",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"SDOC",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.105",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"SDOC"
	),*/
	
/*	"202.129.35.107"=>array(
		"comname"=>"VC NorthEastern#1",
		"hardware"=>"DUO CORE ",
		"localIP"=>"192.168.2.107",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"VC,CMSS NorthEastern#1",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.107",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"ภาคตะวันออกเฉียงเหนือ1"
	),*/
	
/*	"202.129.35.108"=>array(
		"comname"=>"VC North#1",
		"hardware"=>"DUO CORE ",
		"localIP"=>"192.168.2.108",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"VC North#1",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.108",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"ภาคเหนือ 1"
	),*/
	
	"202.129.35.109"=>array(
		"comname"=>"Ubon IMMIGRATION",
		"hardware"=>"DUO CORE ",
		"localIP"=>"192.168.2.109",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"Ubon IMMIGRATION",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.109",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"ตม.ช่องเม็ก"
	),
	
	"202.129.35.102"=>array(
		"comname"=>"TEST SERVER",
		"hardware"=>"DUO CORE ",
		"localIP"=>"192.168.2.102",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"TEST SERVER",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.102",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>" *** "
	),
	
/*	"61.19.117.195"=>array(
		"comname"=>"MUK IMMIGRATION",
		"hardware"=>"DL180",
		"localIP"=>"61.19.117.195",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"MUK IMMIGRATION",
		"picture"=>"ML350.gif",
		"IPcaption"=>"61.19.117.195",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"ระบบตรวจคนเข้าเมือง"
	),*/
	

/*	"202.129.35.113"=>array(
		"comname"=>"VC NorthEastern#4",
		"hardware"=>"DUO CORE ",
		"localIP"=>"192.168.2.113",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"VC NorthEastern#4",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.113",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"ภาคตะวันออกเฉียงเหนือ 4"
	),*/
	
/*	"202.129.35.114"=>array(
		"comname"=>"VC NORTH#2",
		"hardware"=>"DUO CORE ",
		"localIP"=>"192.168.2.114",
		"username"=>"root",
		"pwd"=>"SPRD525@sapphire",
		"functional"=>"VC North#2",
		"picture"=>"ML350.gif",
		"IPcaption"=>"202.129.35.114",
		"gid_net"=>"34",
		"gid_mem"=>"1",
		"local_th"=>"ภาคเหนือ 2"
	)*/
);


//*********** Network Circuit Config ************* 
$hostcacti = "192.168.2.2";
$network_con = array( "CAT LEASE LINE"=>array("graph_id"=>"6","ipusage"=>"202.129.35.98","functional"=>"VC South<br>VC Central<br>VC NorthEast#1<br>VC NorthEast#2<br>VC MASTER<br>VC North") );

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
