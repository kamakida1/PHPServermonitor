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
              <td height="25" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table">
                <tr>
                  <td height="25">Hardware-&gt;CPU</td>
                  <td align="right">Last Update : <? echo intval(date("d"))." ".$mname[intval(date("m"))]." ".date("Y")."  ".date("H").":".date("i").":".date("s");?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="16%" align="center" valign="top" class="table_label">Device</td>
              <td width="19%" align="center" valign="top" class="table_label">Functional</td>
              <td width="65%" align="center" valign="top" class="table_label">GRAPH</td>
              </tr>
            
<?
$n=1; 
  foreach($arr_ip AS $key=>$values){

if ($n % 2) $bg="table_data1"; else $bg="table_data2";
?>
            <tr class="<?=$bg?>">
              <td valign="middle"><?=$key?>
[
  <?=$values[hardware]?>
]</td>
              <td align="center" valign="middle"><?=$values[functional]?></td>
              <td align="center" valign="middle"><a href="http://<?=$values[IPcaption]?>/munin/localhost/localhost-cpu.html" target="_blank"><img src="http://<?=$values[IPcaption]?>/munin/localhost/localhost-cpu-day.png" width="495" height="336" border="0"></a></td>
              </tr>
			 <? 
			 $n++;
	} // end foreach
	

	?> 
            <tr>
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
