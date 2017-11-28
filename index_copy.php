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

?>
<HTML>
<HEAD>
<TITLE>network</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-874">
<LINK href="style.css" rel=stylesheet>
<meta http-equiv="refresh" content="300">
</HEAD>
<BODY BGCOLOR=#A3B2CC LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>

<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
<TR>
	<TD align="center" valign="top">
  <? 
	$pos_master = 0;
	conn($host,$username,$pwd);

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

  foreach($arr_ip AS $key=>$values){
	$url = "http://$values[localIP]/networkmonitor/system.inc.php?display=ON";
	$arr_result = @file($url);
	
	$pingserver = pingDomain($values[localIP]);
	if( $pingserver == -1){
		$status_server++;	
	}
	//$arr_result[0] =100;
	theshold("cpu",$arr_result[0],"1","$values[localIP]",30);
	theshold("memory",$arr_result[1],"2","$values[localIP]",20);
	theshold("hdd",$arr_result[2],"3","$values[localIP]",1);

  ?>
  <table width="790" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#333333">
        <tr>
          <td width="17%" rowspan="10" align="center"><img src="images/<?=$values[picture]?>" width="90" height="122" border="0"></A></td>
          <td width="36%" align="right" class="link_back">Computer Name:</td>
          <td width="47%">&nbsp;<?=$values[comname]?> [ <?=$values[hardware]?> ]</td>
        </tr>
        <tr>
          <td align="right" class="link_back">Functional :</td>
          <td>&nbsp;<?=$values[functional]?></td>
        </tr>
        <tr>
          <td align="right" class="link_back">Local IP Address:</td>
          <td>&nbsp;<?=$values[localIP]?></td>
        </tr>
        <tr>
          <td align="right" class="link_back"><A HREF="http://<?=$key?>/cacti/graph.php?action=view&rra_id=all&local_graph_id=<?=$values[gid_net]?>" target=_blank>Internet IP Address:</a></td>
          <td>&nbsp;<?=$values[IPcaption]?></td>
        </tr>
        <tr>
          <td align="right" class="link_back"><a href="http://<?=$key?>/mrtg/" target="_blank">CPU Usage:</a></td>
    <td align="left"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" name="percent" width="100%" height="15" align="middle" id="percent">
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="movie" value="images/percent_mini_revert.swf?score=<?=$arr_result[0]?>&amp;header=<?=$header?>" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#A5B2CE" />
                <embed src="images/percent_mini_revert.swf?score=<?=$arr_result[0]?>&header=<?=$header?>" quality="high" bgcolor="#A5B2CE" width="100%" height="15" name="percent" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />        
          </object></td>
        </tr>
        <tr>
          <td align="right" class="link_back"><a href="http://<?=$key?>/mrtg/" target="_blank">Memory Usage:</a></td>
          <td align="left">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" name="percent" width="100%" height="15" align="middle" id="percent2">
              <param name="allowScriptAccess" value="sameDomain" />
              <param name="movie" value="images/percent_mini_revert.swf?score=<?=$arr_result[1]?>&amp;header=<?=$header?>" />
              <param name="quality" value="high" />
              <param name="bgcolor" value="#A5B2CE" />
              <embed src="images/percent_mini_revert.swf?score=<?=$arr_result[1]?>&header=<?=$header?>" quality="high" bgcolor="#A5B2CE" width="100%" height="15" name="percent" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />            
</object></td>
        </tr>
        <tr>
          <td align="right" class="link_back"><a href="http://<?=$key?>/mrtg/" target="_blank">HDD Usage:</a></td>
          <td align="left"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" name="percent" width="100%" height="15" align="middle" id="percent3">
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="movie" value="images/percent_mini_revert.swf?score=<?=$arr_result[2]?>&amp;header=<?=$header?>" />
            <param name="quality" value="high" />
            <param name="bgcolor" value="#A5B2CE" />
            <embed src="images/percent_mini_revert.swf?score=<?=$arr_result[2]?>&header=<?=$header?>" quality="high" bgcolor="#A5B2CE" width="100%" height="15" name="percent" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />          
</object></td>
        </tr>
        <tr>
          <td align="right" class="link_back"><a href="http://<?=$key?>/monitoring/report/mysql_health.php" target="_blank">MySQL Health Status</a>:</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="16" align="right" class="link_back">MySQL Replication Status:</td>
          <td>&nbsp;
          <? 
		  		$rs_position = connect_rep("$values[localIP]","$values[username]","$values[pwd]") ;
				$rep_error = 0 ;
				$df_rep = $pos_master - $rs_position ;
				if($debug=="ON"){ echo " $values[localIP] :::  $df_rep = $pos_master - $rs_position <hr> ";}
				if( ($df_rep > 50) or ($df_rep < 0) or ($pos_master == -1) ){
					//echo "<font color=\"red\"><b>Replication Not Connect </b></font>";	
					echo "<font color=\"red\"><b>$rs_position </b></font>";	
					$status_server++;
					$rep_error = 1;				
				}else{
					echo "<font color=\"green\"><b>$rs_position</b></font>";
					//echo "<font color=\"green\"><b>Replication Connect</b></font>";
				}
		  ?>		  
          </td>
        </tr>
        <tr>
          <td height="16" align="right" class="link_back">Data Status:</td>
          <td>&nbsp;</td>
        </tr>
        </table>
    <? 
	} // end foreach
	
	if($status_server > 0 ){
		//echo "<BGSOUND SRC=\"sound/warning.wav\" LOOP=1>";
	}
	

	?>        
    </TD>
</TR>
</TABLE>
</BODY>
</HTML>