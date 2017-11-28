<?
//
include("../competency_master/config/cmss_var.php");
    conn();//connect db
 include("../competency_master/common/class.time_query.php");			
$mytime_query->ApplicationName="crontab";   

 

    
    
    
$mode="dumpTrafficData";
if($mode=="dumpTrafficData"){    
  $host_name="http://202.129.35.98:3000/dumpTrafficData.html?language=php&view=long";     
  $TrafficData=array('ifAddr','name','network','netmask','started','firstpkt','lastpkt','virtualDevice','snaplen','datalink','droppedPkts','receivedPkts','ethernetPkts','broadcastPkts','multicastPkts','ethernetBytes','ipBytes','fragmentedIpBytes','tcpBytes','udpBytes','otherIpBytes','icmpBytes','dlcBytes','ipxBytes','stpBytes','decnetBytes','netbiosBytes','arpRarpBytes','atalkBytes','egpBytes','osiBytes','ipv6Bytes','otherBytes','lastMinEthernetBytes','lastFiveMinsEthernetBytes','lastMinEthernetPkts','lastFiveMinsEthernetPkts','upTo64','upTo128','upTo256','upTo512','upTo1024','upTo1518','above1518','shortest','longest','badChecksum','tooLong','peakThroughput','actualThpt','lastMinThpt','lastFiveMinsThpt','peakPacketThroughput','actualPktsThpt','lastMinPktsThpt','lastFiveMinsPktsThpt','throughput','packetThroughput','tcpLocal','tcpLocal2Rem','tcpRem','tcpRem2Local','udpLocal','udpLocal2Rem','udpRem','udpRem2Local','icmpLocal','icmpLocal2Rem','icmpRem','icmpRem2Local') ; 
 $SecurityPkts=array('synPkts','rstPkts','rstAckPkts','synFinPkts','finPushUrgPkts','nullPkts','ackXmasFinSynNullScan','rejectedTCPConn','establishedTCPConn','terminatedTCPConn','udpToClosedPort','udpToDiagnosticPort','tcpToDiagnosticPort','tinyFragment','icmpFragment','overlappingFragment','closedEmptyTCPConn','icmpPortUnreach','icmpHostNetUnreach','icmpProtocolUnreach','icmpAdminProhibited','malformedPkts'); 
 $IP=array('local','local2remote','remote2local','remote');
}

$data = file_get_contents("$host_name");
if($data!=""){
     eval($data);
     $date=date('Y-m-d H:i:s');
     if(is_array($ntopHash)){
           if($mode=="dumpTrafficData"){
               foreach($ntopHash as $index=>$values){//eth0
                $sql_TrafficData="";
                $data=$values;
                $sql_TrafficData.="date_time='$date'";
                 foreach($TrafficData as $index_col=>$values_col){//$TrafficData
                     if($sql_TrafficData!=""){$sql_TrafficData.=",";}
                     $sql_TrafficData.="$values_col='$data[$values_col]'";
                 }
                 $sql_TrafficData="insert into ntop_trafficdata set $sql_TrafficData";  
                 mysql_db_query($db_competency,$sql_TrafficData)or die(mysql_error());
                 $id=mysql_insert_id();
                 
                 $data=$values[securityPkts];
                 $sql_SecurityPkts="id='$id'";
                 foreach($SecurityPkts as $index_col=>$values_col){//$SecurityPkts
                    if($sql_SecurityPkts!=""){$sql_SecurityPkts.=",";}
                     $sql_SecurityPkts.="$values_col='$data[$values_col]'"; 
                 }
                 $sql_SecurityPkts="insert into ntop_securitypkts set $sql_SecurityPkts";  
                 mysql_db_query($db_competency,$sql_SecurityPkts)or die(mysql_error());
                 
                 $data=$values[IP];
                 if(is_array($data)){
                      foreach($data as $index_data=>$values_data){//$IP
                         $sql_IP="id='$id',mode='$index_data'";
                         foreach($IP as $index_col=>$values_col){
                          if($sql_IP!=""){$sql_IP.=",";}
                             $sql_IP.="$values_col='$values_data[$values_col]'"; 
                         }
                         $sql_IP="insert into ntop_ip set $sql_IP";  
                         mysql_db_query($db_competency,$sql_IP)or die(mysql_error());
                     } 
                 }
               }           
           }     
     } 
}

echo"";
?> 
