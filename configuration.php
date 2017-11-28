<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "ServerMonitor";
$module_code = "report";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::5/08/2007
#LastUpdate::6/08/2007
#DatabaseTable::
#END
#########################################################
session_start();
set_time_limit(1000);
$maxconn = array(100,200,300,400,500,600);
$status_server = 0 ;	
$status_rep = 0 ;	

if($_SESSION[refreshtime] == ""){
	$_SESSION[refreshtime] = 180;
}

			
$arr_ip = array(
//"61.7.155.243"=>array("comname"=>"","hardware"=>"","localIP"=>"","username"=>"","pwd"=>"","functional"=>"","comname"=>"","picture"=>""),
"61.7.155.244"=>array("comname"=>"VC MASTER","hardware"=>"ML350","localIP"=>"192.168.2.12","username"=>"root","pwd"=>"vc@*!sprd","functional"=>"VC MASTER  EastNorth#1 -CMSS-CMS","picture"=>"ML350.gif","IPcaption"=>"61.7.155.244 , 202.69.143.76","gid_net"=>"30"),
//"61.7.155.245"=>array("comname"=>"","hardware"=>"","localIP"=>"","username"=>"","pwd"=>"","functional"=>"","comname"=>"","picture"=>""),
"61.7.155.246"=>array("comname"=>"VC SLAVE1","hardware"=>"IBM X serie266","localIP"=>"192.168.2.16","username"=>"root","pwd"=>"vc@*!sprd","functional"=>"VC EastNorth#2","picture"=>"IBM_XSERIES226.gif","IPcaption"=>"61.7.155.246","gid_net"=>"30"),
"58.147.20.34"=>array("comname"=>"VC SLAVE2","hardware"=>"Acer Altos G5350","localIP"=>"192.168.2.101","username"=>"root","pwd"=>"vc@*!sprd","functional"=>"VC South AND North","picture"=>"ACER_ALTOS350.gif","IPcaption"=>"58.147.20.34","gid_net"=>"63"),
"58.147.20.42"=>array("comname"=>"VC SLAVE3","hardware"=>"ML350","localIP"=>"192.168.2.102","username"=>"root","pwd"=>"vc@*!sprd","functional"=>"VC Central","picture"=>"ML350.gif","IPcaption"=>"58.147.20.42","gid_net"=>"34")
//"202.69.143.75"=>array("comname"=>"SAPPHIRE","hardware"=>"ML110","localIP"=>"192.168.2.11","username"=>"webmaster","pwd"=>"office!sprd","functional"=>"Sapphire - All office Application ","picture"=>"ML110.gif")
//"202.69.143.76"=>array("comname"=>"VC_MASTERIP2","hardware"=>"","localIP"=>"","username"=>"","pwd"=>"","functional"=>"","comname"=>"","picture"=>"ML350.gif")
);


function Query1($sql){
	$result  = mysql_query($sql);
	echo mysql_error();
	$rs = mysql_fetch_array($result);
	return $rs[0];
}

function pingDomain($domain){
    $starttime = microtime(true);
    $file      = @fsockopen ($domain, 80, $errno, $errstr , 0.1);
    $stoptime  = microtime(true);
    $status    = 0;

    if (!$file) $status = -1;  // Site is down
    else {
        fclose($file);
        $status = ($stoptime - $starttime) * 1000;
       // $status = floor($status);
    }
    return $status;
}

function conn($host,$username,$pwd){
	$myconnect = @mysql_connect($host,"$username","$pwd") ; //OR DIE("Unable to connect to database :: $host ");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");
}

function connect_rep($gethost,$getusr,$getpwd){
	global $debug;
	$pos_slave = 0;
	$con = @mysql_connect("$gethost","$getusr","$getpwd");
	if ($con){
		$sql = "show master status;";
		$result = @mysql_query($sql); 
		echo mysql_error();
		$rs = @mysql_fetch_assoc($result); 
		if($debug=="ON"){print_r($rs);}
		$pos_slave = intval($rs[Position]);
	}else{
		$pos_slave = -1;
	}
	return $pos_slave;
}


	$pos_master = 0;
	$con = @mysql_connect("localhost","sapphire","sprd!@#$%");
	if ($con){
		$sql = "show master status;";
		$result = @mysql_query($sql); //echo mysql_error();
		$rs = @mysql_fetch_assoc($result); //print_r($rs);
		$pos_master = intval($rs[Position]);
		$status_master = "server Online";
	}else{
		$pos_master = -1;
		$status_master = "Cannot connect server [Master]";
	}
	function server_status($status0,$status1,$status2){
	
	$status = array();
	if($status0<=70){
		$status[0] = 1;
	}else if(($status0>70 and $status0<=85)){
		$status[0] = 2;
	}else{
		$status[0] = 3;
	}
		
	if(($status1<=70) ){
		$status[1] = 1;
	}else if(($status1>70 and $status1<=85)){
		$status[1] = 2;
	}else{
		$status[1] = 3;
	}
	
	if($status2<=70){
		$status[2] =1;
	}else if(($status2>70 and $status2<=85)){
		$status[2] = 2;
	}else{
		$status[2] = 3;
	}
		
	sort($status);
	print_r($status);

	if($status[2]==1){
		return "<img src=\"images/server-alive.gif\" alt=\"alive\" >";
	}else if($status[2]==2){
		return "<img src=\"images/server-warn.gif\" alt=\"warning\" >";
	}else{
		return "<img src=\"images/server-dead.gif\" alt=\"dead\" >";
	}
/*
	if($status==1){
		$showimg="<img src=\"images/server-dead.gif\" alt=\"dead\" >";
		}else{
		$showimg="<img src=\"images/server-alive.gif\" alt=\"alive\" >";
		}
		return $showimg;
		*/
	}
	
	//function แสดงสถานะของ CPU และ MEM
	function even_status($value1){
	$value1=trim($value1);
	//$value1=50;
	if($value1<=70){
		$show_even_status=" <span class=\"status_normal\" title=\"normal\">".number_format($value1,2)."%</span>";
		}else if($value1>70 and $value1<=90){
		$show_even_status="<span class=\"status_warn\" title=\"warning\">$value1%</span>";
		}else{
		$show_even_status="<span class=\"status_critical\" title=\"critical\">$value1%</span>";
		}
		return $show_even_status;
	}
	//function แสดงสถานะของ HDD
	function even_status_hdd($value1){
	$value1=trim($value1);
	//$value1=50;
	if($value1<=70){
		$show_even_status=" <span class=\"status_normal\" title=\"normal\">".number_format($value1,2)."%</span>";
		}else if($value1>70 and $value1<=85){
		$show_even_status="<span class=\"status_warn\" title=\"warning\">$value1%</span>";
		}else{
		$show_even_status="<span class=\"status_critical\" title=\"critical\">$value1%</span>";
		}
		return $show_even_status;
	}
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta http-equiv="refresh" content="<?=$_SESSION[refreshtime]?>">
<title>NMS-Configuration</title>
<link href="nms_style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><? include("header.php"); ?>
      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="150" valign="top"><? include("left_menu.php"); ?></td>
          <td valign="top" style="padding:5px"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #666666">
            <tr>
              <td height="25" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table">
                <tr>
                  <td height="25">Configuration</td>
                  <td align="right">Last Update : 08-08-2007 14:58:40</td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="7%" align="center" valign="top" class="table_label"><input type="checkbox"  title="Select all "name="checkbox5" value="checkbox"></td>
              <td width="35%" valign="top" class="table_label">Application</td>
              <td width="58%" valign="top" class="table_label">Description</td>
              </tr>
            <tr class="table_data1" >
              <td align="center" valign="top"><input type="checkbox" name="checkbox" value="checkbox"></td>
              <td valign="top">VC</td>
              <td valign="top">&nbsp;</td>
              </tr>
            <tr class="table_data2" >
              <td align="center" valign="top"><input type="checkbox" name="checkbox2" value="checkbox"></td>
              <td valign="top">CMSS</td>
              <td valign="top">&nbsp;</td>
              </tr>
            <tr class="table_data1" >
              <td align="center" valign="top"><input type="checkbox" name="checkbox3" value="checkbox"></td>
              <td valign="top">Callcenter</td>
              <td valign="top">&nbsp;</td>
              </tr>
            <tr class="table_data2" >
              <td align="center" valign="top"><input type="checkbox" name="checkbox4" value="checkbox"></td>
              <td valign="top">Sapphire Website </td>
              <td valign="top">&nbsp;</td>
              </tr>
            <tr>
              <td height="25" valign="top" bgcolor="#666666">&nbsp;</td>
              <td colspan="2" valign="middle" bgcolor="#666666"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="86" class="white_text_bold">Refresh Time </td>
                  <td width="97"><select name="select">
                    <option selected>-Time-</option>
                    <option>1 Minute</option>
                    <option>2 Minute</option>
					<option>3 Minute</option>
					<option>4 Minute</option>
					<option>5 Minute</option>
                  </select>
                  </td>
                  <td width="377"><input type="submit" name="Submit" value="View"></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
                <label></label></td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
