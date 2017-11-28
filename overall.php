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

				function spritdata($data){
					$s_data = explode(" ",$data);
					return $s_data[1];
				}

if($_SESSION[refreshtime] == ""){
	$_SESSION[refreshtime] = 180;
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<meta http-equiv="refresh" content="<?=$_SESSION[refreshtime]?>">
<title>NMS-Overall</title>
<link href="nms_style.css" rel="stylesheet" type="text/css">
</head>

<body>
<SCRIPT language=JavaScript src="loader1.js"></SCRIPT>

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
                  <td width="30%" height="25">Overall</td>
                  <td width="70%" align="right">Last Update : <? echo intval(date("d"))." ".$mname[intval(date("m"))]." ".date("Y")."  ".date("H").":".date("m").":".date("s");?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="17%" align="center" valign="top" class="table_label">Device</td>
              <td width="12%" align="center" valign="top" class="table_label">Hardware</td>
              <td width="19%" align="center" valign="top" class="table_label">Network</td>
              <td width="14%" align="center" valign="top" class="table_label">System Service </td>
              <td width="12%" align="center" valign="top" class="table_label">Database</td>
              <td width="12%" align="center" valign="top" class="table_label">Replication</td>
              <td width="14%" align="center" valign="top" class="table_label">Application</td>
              </tr>
			 <? 
			foreach($arr_ip AS $key=>$values){
			
			$con = @conn($values[localIP],$values[username],$values[pwd]);

			// ***** Hardware ***********
			$url = "http://$values[localIP]/networkmonitor/system.inc.php?display=ON";
			$arr_result = @file($url);
			
			//theshold("cpu",$arr_result[0],"1","$values[localIP]",30);
			//theshold("memory",$arr_result[1],"2","$values[localIP]",20);
			//theshold("hdd",$arr_result[2],"3","$values[localIP]",1);
			
			$getstatusall = even_status_all($arr_result[0],$arr_result[1],$arr_result[2]);
			
			
			//***********Replication*************
			$sql = "show slave status;";
			$result = @mysql_query($sql); //echo mysql_error();
			$rs = @mysql_fetch_assoc($result); //print_r($rs);
			
			//***********Network*******
				if($key=="61.7.155.244"){$rsip = "localhost";}else{$rsip = "$values[localIP]";}
				$host1 = "$rsip";
				$community = "public";
				$eth = 2;
				$sleeptime = 10;
				$suminbound = 0;
				$delta1 = array();
				$delta2 = array();
				$tempin = array();
				$tempout = array();
				//***************************
				
				// BandWidth util = ( ( ( diff in ifInOctets) + ( diff in ifOutOctets ) )* 8 * 100 ) / ( ( diff in Time) * ifSpeed ) 
				
				/*
				for($i=0;$i < 2;$i++){
				
				$ifInOctets = ".1.3.6.1.2.1.2.2.1.10" ;
				$ifOutOctets =".1.3.6.1.2.1.2.2.1.16" ;
				$ifSpeed = ".1.3.6.1.2.1.2.2.1.5" ;
				
				$ifInOctet_1 = @snmpwalk("$host1","$community","$ifInOctets"); // Counter collected for ifInOctet
				$ifOutOctet_1 = @snmpwalk("$host1","$community","$ifOutOctets");  // Counter collected for ifOutOctet
				
				$time_between_polls = $sleeptime; // Number of seconds between polls
				
				$ifSpeed = @snmpwalk("$host1","$community","$ifSpeed"); // The ifspeed that was polled for the port on the switch
				
				$tempin[$i] = spritdata("$ifInOctet_1[$eth]") ;
				$tempout[$i] = spritdata("$ifOutOctet_1[$eth]") ;
				
				$bki = $i - 1 ;
				
				$delta1[$i] = ((spritdata("$ifInOctet_1[$eth]") - $tempin[$bki])*8)/$sleeptime;
				$delta2[$i] = ((spritdata("$ifOutOctet_1[$eth]") - $tempout[$bki])*8)/$sleeptime;
				if($i>0){ $suminbound+=$delta1[$i];$sumoutbound+=$delta2[$i]; }
				
				sleep($sleeptime);
				
				
				} // end for
				*/
			//  ******** Service *************
				$dataservice = readlogservice("http://$values[localIP]/networkmonitor/services.log");
				$exdataservice1 = explode("|",$dataservice[1]);
				$exdataservice2 = explode("|",$dataservice[2]);
				$exdataservice3 = explode("|",$dataservice[3]);
				if(($exdataservice1[3] == 0) or ($exdataservice2[3] == 0) or ($exdataservice3[3]==0)){
					$servicestatus = 0 ;
				}else{
					$servicestatus = 1 ;
				}
			//***************************
			
			 ?> 
            <tr class="table_data1" >
              <td align="center" valign="top"><?=$key?></td>
              <td align="center" valign="top"><?=showpic_status($getstatusall)?></td>
              <td align="center" valign="top"><? echo "dl ".number_format(($suminbound/1000),2)."  kbs / ";echo "ul ".number_format(($sumoutbound/1000),2)."  kbs";?></td>
              <td align="center" valign="top"><?=showpic_status($servicestatus)?></td>
              <td align="center" valign="top">&nbsp;</td>
              <td align="center" valign="top">
			  <? 
			//********** Display Replication  **************
			if(($rs["Slave_IO_Running"] == "Yes") AND ($rs["Slave_SQL_Running"] == "Yes")){
				showpic_status("1");
			}else{
				showpic_status("0");
			}
			 ?>			  </td>
              <td align="center" valign="top">&nbsp;</td>
              </tr>
            <tr>
			<? } ?>
              <td align="center" valign="top" bgcolor="#666666">&nbsp;</td>
              <td align="center" valign="top" bgcolor="#666666">&nbsp;</td>
              <td align="center" valign="top" bgcolor="#666666">&nbsp;</td>
              <td align="center" valign="top" bgcolor="#666666">&nbsp;</td>
              <td align="center" valign="top" bgcolor="#666666">&nbsp;</td>
              <td align="center" valign="top" bgcolor="#666666">&nbsp;</td>
              <td align="center" valign="top" bgcolor="#666666">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<SCRIPT language=JavaScript src="loader2.js"></SCRIPT>

</body>
</html>
