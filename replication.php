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
include("config.inc.php");
include("function.inc.php");

if($_SESSION[refreshtime] == ""){
	$_SESSION[refreshtime] = 2;
}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta http-equiv="refresh" content="20">
<title>NMS-Hardware</title>
<link href="nms_style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><? include("header.php"); ?>
      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="150" valign="top"><? include("left_menu.php"); ?></td>
          <td valign="top" style="padding:5px"><table border=0 width="100%" bgcolor="#404040" cellpadding=5 cellspacing=1 align=center>
            <tr bgcolor="#3366FF" height="30">
              <th class="top_table">Server IP</th>
              <th class="top_table">Position</th>
              <th class="top_table">Master Host</th>
              <th class="top_table">IO Read<BR>
                Master Position</th>
              <th class="top_table">SQL Execue<BR>
                Master Position</th>
              <th class="top_table">IO Process</th>
              <th class="top_table">SQL Process</th>
            </tr>
            <?
set_time_limit(1000);
$now = date("Y-m-d H:i:s") ;

$color = array("#FF6600","#666600","#330066","#993300","#0033CC","#CC3300","#006600","#660033","#3300CC", "#FF3300","#CC6633","#660066","#99CC00","#0099FF","#003333","#FF6666","#339900","#CC0000");

$c = 0;
$scolor = array();
$slave = array();
$master_position = array();
foreach($arr_ip AS $key=>$values){
	//if ($values[localIP] == $current_ip) $values[localIP] = "localhost";
	$pos = 0;
	$scolor[$values[localIP]] = $color[$c++];

	$con = @conn($values[localIP],$values[username],$values[pwd]);
	if ($con){
		//@mysql_select_db($main_db);

		$sql = "show master status;";
		$result = @mysql_query($sql); //echo mysql_error();
		$rs = @mysql_fetch_assoc($result); //print_r($rs);
		$pos = intval($rs[Position]);
		$master_position[$values[localIP]] = $pos;

		$sql = "show slave status;";
		$result = @mysql_query($sql); //echo mysql_error();
		$rs = @mysql_fetch_assoc($result); //print_r($rs);
		$slave[$values[localIP]]["master_host"] = $rs["Master_Host"];
		$slave[$values[localIP]]["master_position_read"] = intval($rs["Read_Master_Log_Pos"]);
		$slave[$values[localIP]]["master_position_exec"] = intval($rs["Exec_Master_Log_Pos"]);
		$slave[$values[localIP]]["IO"] = $rs["Slave_IO_Running"];
		$slave[$values[localIP]]["SQL"] = $rs["Slave_SQL_Running"];
		
		
		$status = "server Online";
	}else{
		$pos = -1;
		$status = "Cannot connect server [$values[localIP]]";
	}
} // foreach


foreach($arr_ip AS $key=>$values){
	if ($slave[$values[localIP]]["master_position_read"] != $master_position[($slave[$values[localIP]]["master_host"])]){
		$c1 = "RED";
		#echo $master_position[($slave[$values[localIP]]["master_host"])]."<hr>".$slave[$values[localIP]]["master_position_read"]."<hr>";
	}else{
		$c1 = "WHITE";
	}

	if ($slave[$values[localIP]]["master_position_exec"] != $master_position[($slave[$values[localIP]]["master_host"])]){
		$c2 = "RED";
	}else{
		$c2 = "WHITE";
	}
?>
            <tr bgcolor='WHITE'>
              <td height="25" width="190" align=center>&nbsp;
              <?=$key?>(<FONT COLOR="<?=$scolor[$values[localIP]]?>"><?=$values[localIP]?>)<br>(<?=$values[functional]?></FONT>)</td>
              <td align=right><B style="color: <?=$scolor[$values[localIP]]?>;">
                <?=number_format($master_position[$values[localIP]])?>
              </B> &nbsp;</td>
              <td align=center><FONT COLOR="<?=$scolor[($slave[$values[localIP]]["master_host"])]?>">
                <?=$slave[$values[localIP]]["master_host"]?>
              </FONT> </td>
              <td align=right bgcolor="<?=$c1?>"><B style="color: <?=$scolor[($slave[$values[localIP]]["master_host"])]?>;">
                <?=number_format($slave[$values[localIP]]["master_position_read"])?>
              </B> &nbsp;</td>
              <td align=right bgcolor="<?=$c2?>"><B style="color: <?=$scolor[($slave[$values[localIP]]["master_host"])]?>;">
                <?=number_format($slave[$values[localIP]]["master_position_exec"])?>
              </B> &nbsp;</td>
              <td align=center <?if ($slave[$values[localIP]]["IO"] != "Yes") echo "BGCOLOR='RED'";?> ><?=$slave[$values[localIP]]["IO"]?></td>
              <td align=center <?if ($slave[$values[localIP]]["SQL"] != "Yes") echo "BGCOLOR='RED'";?> ><?=$slave[$values[localIP]]["SQL"]?></td>
            </tr>
            <?
} // foreach

?>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
