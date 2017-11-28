<?
//*******************************************//
//**********Funtion For NMS *******************//
//*******************************************//
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

function showpic_status($status){
		if($status==1){
			echo  "<img src=\"images/server-alive.gif\" alt=\"alive\" >";
		}else{
			echo "<img src=\"images/server-dead.gif\" alt=\"dead\" >";
		}
}

function conn($host,$username,$pwd){
	$myconnect = mysql_connect("$host","$username","$pwd") ; //OR DIE("Unable to connect to database :: $host ");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");
	return  $myconnect;
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


function server_status($status0,$status1,$status2){
	
	$status = array();
	if($status0<=65){
		$status[0] = 1;
		}else if(($status0>65 and $status0<=90)){
		 $status[0] = 2;
		}else{
		  $status[0] =3;
		}
		
	if(($status1<=65) ){
		$status[1] = 1;
		}else if(($status1>65 and $status1<=90)){
		 $status[1] = 2;
		}else{
		  $status[1] =3;
		}

	
	if($status2<=65){
			 $status[2] =1;
		}else if(($status2>65 and $status2<=85)){
			 $status[2] =2;
		}else{
			 $status[2] =3;
		}
		
		sort($status);
		//print_r($status);

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
// *************  ARRAY **************************



//*********  Write READ DATA  Replication *************//

function WritelogRep($key,$rsrep,$connection_usage,$traffic,$num_query,$query_cache_hitrate,$key_efficiency,$num_thread,$rscpu,$rsmem){

	$file1 = "logreplication.dat";
	$rscpu = trim($rscpu);
	$rsmem = trim($rsmem);
	$f = fopen($file1,"a");
	$msg = (date("d"))."-".(date("m"))."-".date("Y")." ".date("H").":".date("i").":".date("s")."|";
	$msg .= $rsrep."|".$connection_usage."|".$traffic."|".$num_query."|".$query_cache_hitrate."|";
	$msg .= $key_efficiency."|".$num_thread."|".$rscpu."|".$rsmem."|".$key."\r\n";
	fwrite($f,$msg);
	fclose($f);

}

function readlog(){
$file1 = "logreplication.dat";
$handle = fopen($file1, "r");
$i=1;
	if($handle) {
	   while (!feof($handle)) {
		   $buffer[$i] = fgets($handle);
		   //echo $buffer[$i]."<br>";
		   $i++;
	   }
	   fclose($handle);
	}
	return  $buffer;
}

function readlogservice($file1){
$handle = @fopen($file1, "r");
$i=1;
	if($handle) {
	   while (!feof($handle)) {
		   $buffer[$i] = fgets($handle);
		   //echo $buffer[$i]."<br>";
		   $i++;
	   }
	   fclose($handle);
	}
	return  $buffer;
}

//*******************************************

//function แสดงสถานะของ CPU และ MEM
function even_status($value1){
	$value1=trim($value1);
	//$value1=50;
	if($value1<=65){
		$show_even_status=" <span class=\"status_normal\" title=\"normal\">".number_format($value1,2)."%</span>";
		}else if($value1>65 and $value1<=90){
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
	if($value1<=65){
		$show_even_status=" <span class=\"status_normal\" title=\"normal\">".number_format($value1,2)."%</span>";
		}else if($value1>65 and $value1<=85){
		$show_even_status="<span class=\"status_warn\" title=\"warning\">$value1%</span>";
		}else{
		$show_even_status="<span class=\"status_critical\" title=\"critical\">$value1%</span>";
		}
		return $show_even_status;
}

// ***************Over All CPU MEM HDD********************

function even_status_all($cpudata,$memdata,$hdddata){

	$cpudata=trim($cpudata);
	$memdata=trim($memdata);
	$hdddata=trim($hdddata);

	if($cpudata<=65){
		$cpustatus=0;
	}else if($cpudata>65 and $cpudata<=90){
		$cpustatus=1;
	}else{
		$cpustatus=2;
	}

	if($memdata<=65){
		$memstatus=0;
	}else if($memdata>65 and $memdata<=90){
		$memstatus=1;
	}else{
		$memstatus=2;
	}

	if($hdddata<=65){
		$hddstatus=0;
	}else if($hdddata>65 and $hdddata<=85){
		$hddstatus=1;
	}else{
		$hddstatus=2;
	}

	if(($cpustatus>=1) or ($memstatus >= 1) or ($hddstatus >= 1)){
		$statusall=0;
	}else{
		$statusall=1;
	}
	return  $statusall ;

}

//***************************************************

function writelog($monitor_id,$ip,$val){
	global $host,$username,$pwd,$database_sys,$debug;

	$sql1 = " SELECT monitor_id FROM log_warning WHERE monitor_id = '$monitor_id' AND  server_ip = '$ip'  AND val = '$val'  ";
	$result1 = mysql_db_query($database_sys,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	
	if($rs1[monitor_id] == ""){
		$sql = " INSERT INTO  log_warning( monitor_id,server_ip,val ) VALUES ( '$monitor_id','$ip','$val' )";
		if($debug){ echo "$sql<hr>"; }
		mysql_db_query($database_sys,$sql);
		if(mysql_errno() == 0 ){
			$rs_log = true;
		}else{
			$rs_log = false;
		}
	}
	return $rs_log;

}

function checkwarning2sms($gettype,$gettime,$monitor_id,$server_ip){
	global $hostsms,$method,$path,$User,$Password,$database_sys,$debug , $Sender, $MsgType;

	$time_cond = ( $gettime * (-60) ) ; // gen time 

	$timecheck1 = strtotime("$time_cond seconds"); // create time condition
	$timecheck2 = date('Y-m-d H:i', $timecheck1); // convert time

	$sql = " SELECT * FROM log_warning WHERE timeupdate LIKE '$timecheck2%' AND monitor_id = '$monitor_id'  AND server_ip = '$server_ip'  ";
	$result = mysql_db_query($database_sys,$sql);
	//echo $sql;die;
	//echo "$sql<hr>$database_sys<hr>";
	$rs = mysql_fetch_assoc($result);
	if (mysql_errno() != 0 ) { echo "<hr> <b> " .mysql_error()     .  "<b><hr>  " ;  }
	//echo "$rs[val]<hr>";

	if($rs[val] != ""){ 

		// ตรวจสอบว่าได้มีการส่งไปรึยัง
		$sqlx = " SELECT  *  FROM  sms_status WHERE  monitor_id = '$monitor_id'   ";
		$resultx = mysql_db_query($database_sys,$sqlx);
		$rsx = mysql_fetch_assoc($resultx);

		//echo " $sqlx <br> $rsx[sendstatus] <hr>";
		
		if( $rsx[sendstatus]=="w" ){
		
		// send sms
		$arr_user = explode(",",$rsx[user_id]);
		foreach($arr_user AS $values){

		$sql_s = " SELECT  *  FROM  phonenumber WHERE  user_id = '$values'   ";
		//echo "$sql_s<hr>";
		$results = mysql_db_query($database_sys,$sql_s);
		$rss = mysql_fetch_assoc($results);
		$rsx[sms_massage] = $rsx[sms_massage]. " at $server_ip";
		$smsresult=sendRequest($hostsms,$method,$path,'RefNo='.$monitor_id.'&Sender='.$Sender.'&Msn='.$rss[phonenumber].'&Msg='.$rsx[sms_massage].'&MsgType='.$MsgType.'&User='.$User.'&Password='.$Password);
		//echo " $hostsms ,  $method , $path,'RefNo='.$monitor_id.'&Sender='.$Sender.'&Msn='.$rss[phonenumber].'&Msg='.$rsx[sms_massage].'&MsgType='.$MsgType.'&User='.$User.'&Password='.$Password ";
		$rssms = gwStatus($smsresult);	
		//echo "SEND =  $rssms<hr> ";

		mysql_query(" UPDATE  sms_status SET sendstatus = 's' , sms_result = '$rssms' WHERE monitor_id = '$monitor_id' ");
		} // end for
		}	
	}
}

function theshold($gettype,$getvalues,$monitor_id,$ip,$gettime){
	global $host,$username,$pwd;
	conn($host,$username,$pwd);
	if($gettype=="server"){ // all send hdd 
		if($getvalues == 0 ){
			writelog($monitor_id,$ip,$getvalues);
			checkwarning2sms($gettype,$gettime,$monitor_id,$ip);
		}else{
			clearstatus($monitor_id);
		}
	}else if($gettype=="cpu"){
		if($getvalues >= 95 ){
			writelog($monitor_id,$ip,$getvalues);
			checkwarning2sms($gettype,$gettime,$monitor_id,$ip);
		}else{
			clearstatus($monitor_id);
		}
	}else if($gettype=="memory"){
		if($getvalues >= 95 ){
			writelog($monitor_id,$ip,$getvalues);
			checkwarning2sms($gettype,$gettime,$monitor_id,$ip);
		}else{
			clearstatus($monitor_id);
		}
	}else if($gettype=="hdd"){
		if($getvalues >= 95 ){
			writelog($monitor_id,$ip,$getvalues);
			checkwarning2sms($gettype,$gettime,$monitor_id,$ip);
		}else{
			clearstatus($monitor_id);
		}
	}else{

	}
}

function clearstatus($monitor_id){
	global $database_sys,$debug ;
	$sql = " UPDATE  sms_status  SET sendstatus = 'w' , sms_result = 'w'  WHERE monitor_id = '$monitor_id'    ";
	//echo "$sql<hr>";
	mysql_db_query($database_sys,$sql);
}
// =========== SEND SMS ===================
Function sendRequest($host,$method,$path,$data){
    global  $smsgetstatus;
	if($smsgetstatus==true){
		//$method = strtoupper($method);
		$fp = fsockopen($host, 80);

		fputs($fp, "$method $path HTTP/1.1\r\n");
		fputs($fp, "Host: $host\r\n");
		fputs($fp,"Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: " . strlen($data) . "\r\n");

		fputs($fp, "Connection: close\r\n\r\n");
		if ($method == 'POST') 
			{
				fputs($fp, $data);
			}

		while (!feof($fp)) 
			{
				$result .= fgets($fp,128);
			}
		fclose($fp);
		return $result;
	}
}

function gwStatus($raw_socket_return) {
	$raw_socket_return = trim($raw_socket_return);
                $socket_status = "";
                $socket_return = explode("\n", $raw_socket_return);
				$count = count($socket_return);
				$iresult = $count-2;
				$socket_status = $socket_return[$iresult];
		return $socket_status;
}
//---------------------------------------------------------------------------------
?>
