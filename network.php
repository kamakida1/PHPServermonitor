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
<title>NMS-Network</title>
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
              <td height="25" colspan="7"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="top_table">
                <tr>
                  <td height="25">Network</td>
                  <td align="right">Last Update : <? echo intval(date("d"))." ".$mname[intval(date("m"))]." ".date("Y")."  ".date("H").":".date("i").":".date("s");?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="18%" align="center" valign="top" class="table_label">Circuit</td>
              <td width="21%" align="center" valign="top" class="table_label">Functional &amp; IP </td>
              <td width="61%" colspan="5" align="center" valign="top" class="table_label">Graph</td>
              </tr>
            
			<?
			$n=1; 
  foreach($network_con AS $key=>$values){
	if ($n % 2) $bg="table_data1"; else $bg="table_data2";
  ?>
            <tr class="<?=$bg?>">
              <td align="center" valign="middle"><?=$key?></td>
              <td valign="top"><strong>Functional :</strong><br><?=$values[functional]?>
                <br>
                <br>
                <strong>IP Address:</strong><br><?=$values[ipusage]?></td>
              <td colspan="5" align="center" valign="middle">
			  <A HREF="http://<?=$values[ipusage]?>/cacti/graph.php?action=view&rra_id=all&local_graph_id=<?=$values[graph_id]?>" target=_blank><img src="http://<?=$values[ipusage]?>/cacti/graph_image.php?action=view&local_graph_id=<?=$values[graph_id]?>&rra_id=0&graph_height=80&graph_width=300&graph_nolegend=true" alt="Graph" border=0></A></td>
              </tr>
			 <? 
			 $n++;
	} // end foreach
	
	?> 
            <tr>
              <td colspan="7" valign="top" bgcolor="#666666">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
