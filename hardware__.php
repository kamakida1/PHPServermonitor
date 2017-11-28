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
	$_SESSION[refreshtime] = 180;
}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta http-equiv="refresh" content="<?=$_SESSION[refreshtime]?>">
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
          <td valign="top" style="padding:5px"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #666666">
            <tr>
              <td height="25" colspan="8"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table">
                <tr>
                  <td height="25">Hardware</td>
                  <td align="right">Last Update : <? echo intval(date("d"))." ".$mname[intval(date("m"))]." ".date("Y")."  ".date("H").":".date("i").":".date("s");?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="16%" align="center" valign="top" class="table_label">Device</td>
              <td width="7%" align="center" valign="top" class="table_label">status</td>
              <td width="18%" align="center" valign="top" class="table_label">Functional</td>
              <td width="14%" align="center" valign="top" class="table_label">Local IP </td>
              <td width="19%" align="center" valign="top" class="table_label">Internet IP </td>
              <td width="8%" align="center" valign="top" class="table_label"><a href="hw.php?hw=cpu">CPU</a></td>
              <td width="9%" align="center" valign="top" class="table_label"><a href="hw.php?hw=Memory">Memory</a></td>
              <td width="9%" align="center" valign="top" class="table_label">HDD</td>
              </tr>
            
<?
$n=1; 
  foreach($arr_ip AS $key=>$values){
	$url = "http://$values[localIP]/networkmonitor/system.inc.php?display=ON";
	$arr_result = @file($url);
	
	$pingserver = pingDomain($values[localIP]);
	if( $pingserver == -1){
		$status_server++;	
	}
	if ($n % 2) $bg="table_data1"; else $bg="table_data2";
?>
            <tr class="<?=$bg?>">
              <td valign="top"><?=$key?><br>
[
  <?=$values[hardware]?>
]</td>
              <td align="center" valign="top"><?=server_status($arr_result[0],$arr_result[1],$arr_result[2] )?></td>
              <td align="center" valign="top"><?=$values[functional]?></td>
              <td align="center" valign="top"><?=$values[localIP]?></td>
              <td align="center" valign="top"><?=$values[IPcaption]?></td>
              <td align="center" valign="top"><?=even_status($arr_result[0])?></td>
              <td align="center" valign="top"><?=even_status($arr_result[1])?></td>
              <td align="center" valign="top"><?=even_status_hdd($arr_result[2])?></td>
              </tr>
			 <? 
			 $n++;
	} // end foreach
	

	?> 
            <tr>
              <td valign="top" bgcolor="#666666">&nbsp;</td>
              <td valign="top" bgcolor="#666666">&nbsp;</td>
              <td valign="top" bgcolor="#666666">&nbsp;</td>
              <td valign="top" bgcolor="#666666">&nbsp;</td>
              <td valign="top" bgcolor="#666666">&nbsp;</td>
              <td valign="top" bgcolor="#666666">&nbsp;</td>
              <td valign="top" bgcolor="#666666">&nbsp;</td>
              <td valign="top" bgcolor="#666666">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
