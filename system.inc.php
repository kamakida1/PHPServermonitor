<?php
//**********************************************************/
// Engine For  return Values  Memory Usage : CPU Usage :  HDD Usage
// Create By Pairoj
//**********************************************************/

define("TEMP_PATH","/tmp/");
 
class CPULoad {
	
	function check_load() {
		$fd = fopen("/proc/stat","r");
		if ($fd) {
			$statinfo = explode("\n",fgets($fd, 1024));
			fclose($fd);
			foreach($statinfo as $line) {
				$info = explode(" ",$line);
				//echo "<pre>"; var_dump($info); echo "</pre>";
				if($info[0]=="cpu") {
					array_shift($info);  // pop off "cpu"
					if(!$info[0]) array_shift($info); // pop off blank space (if any)
					$this->user = $info[0];
					$this->nice = $info[1];
					$this->system = $info[2];
					$this->idle = $info[3];
//					$this->print_current();
					return;
				}
			}
		}
	}
	
	function store_load() {
		$this->last_user = $this->user;
		$this->last_nice = $this->nice;
		$this->last_system = $this->system;
		$this->last_idle = $this->idle;
	}
	
	function save_load() {
		$this->store_load();
		$fp = @fopen(TEMP_PATH."cpuinfo.tmp","w");
		if ($fp) {
			fwrite($fp,time()."\n");
			fwrite($fp,$this->last_user." ".$this->last_nice." ".$this->last_system." ".$this->last_idle."\n");
			fwrite($fp,$this->load["user"]." ".$this->load["nice"]." ".$this->load["system"]." ".$this->load["idle"]." ".$this->load["cpu"]."\n");
			fclose($fp);
		}
	}
	
	function load_load() {
		$fp = @fopen(TEMP_PATH."cpuinfo.tmp","r");
		if ($fp) {
			$lines = explode("\n",fread($fp,1024));
			
			$this->lasttime = $lines[0];
			list($this->last_user,$this->last_nice,$this->last_system,$this->last_idle) = explode(" ",$lines[1]);
			list($this->load["user"],$this->load["nice"],$this->load["system"],$this->load["idle"],$this->load["cpu"]) = explode(" ",$lines[2]);
			fclose($fp);
		} else {
			$this->lasttime = time() - 60;
			$this->last_user = $this->last_nice = $this->last_system = $this->last_idle = 0;
			$this->user = $this->nice = $this->system = $this->idle = 0;
		}
	}
	
	function calculate_load() {
		//$this->print_current();
		
		$d_user = $this->user - $this->last_user;
		$d_nice = $this->nice - $this->last_nice;
		$d_system = $this->system - $this->last_system;
		$d_idle = $this->idle - $this->last_idle;
		
		//printf("Delta - User: %f  Nice: %f  System: %f  Idle: %f<br>",$d_user,$d_nice,$d_system,$d_idle);
 
		$total=$d_user+$d_nice+$d_system+$d_idle;
		if ($total<1) $total=1;
		$scale = 100.0/$total;
		
		$cpu_load = ($d_user+$d_nice+$d_system)*$scale;
		$this->load["user"] = $d_user*$scale;
		$this->load["nice"] = $d_nice*$scale;
		$this->load["system"] = $d_system*$scale;
		$this->load["idle"] = $d_idle*$scale;
		$this->load["cpu"] = ($d_user+$d_nice+$d_system)*$scale;
	}
	
	function print_current() {
		printf("Current load tickers - User: %f  Nice: %f  System: %f  Idle: %f<br>",
			$this->user,
			$this->nice,
			$this->system,
			$this->idle
		);
	}
 
	function print_load() {
		printf("User: %.1f%%  Nice: %.1f%%  System: %.1f%%  Idle: %.1f%%  Load: %.1f%%<br>",
			$this->load["user"],
			$this->load["nice"],
			$this->load["system"],
			$this->load["idle"],
			$this->load["cpu"]
		);
	}
 
	function sample_load($interval=1) {
		$this->check_load();
		$this->store_load();
		sleep($interval);
		$this->check_load();
		$this->calculate_load();
	}
	
	function get_load($fastest_sample=4) {
		$this->load_load();
		$this->cached = (time()-$this->lasttime);
		if ($this->cached>=$fastest_sample) {
			$this->check_load(); 
			$this->calculate_load();
			$this->save_load();
		}
	}
 
}

//==============MEMORY===============================

function get_memory() {
  foreach(file('/proc/meminfo') as $ri)
    $m[strtok($ri, ':')] = strtok('');
  return 100 - round(($m['MemFree'] + $m['Buffers'] + $m['Cached']) / $m['MemTotal'] * 100);
}

//require_once("class_CPULoad.php");
 
// NOTE: Calling $cpuload->get_load() requires that your webserver has
// write access to the /tmp directory!  If it does not have access, you
// need to edit class_CPULoad.php and change the temporary directory.
$cpuload = new CPULoad();
$cpuload->get_load();
//$cpuload->print_load();

// CPU Usage
$resultcpu =  number_format($cpuload->load["cpu"],2);
//echo $resultcpu;
// Memory Usage
$resultmemory = get_memory() ;

// HDD Usage
$partition = "/";
$totalSpace = disk_total_space($partition) / 1048576;
$usedSpace = $totalSpace - disk_free_space($partition) / 1048576;
$totalSpace = number_format(($totalSpace/1024),2);
$usedSpace = number_format(($usedSpace/1024),2);
$resulthdd = number_format((($usedSpace/$totalSpace)*100),2);
$arr_result = array("$resultcpu","$resultmemory","$resulthdd","$totalSpace","$usedSpace");
if($_GET[debug]=="ON"){
	echo "Memory Usage : $resultmemory %<hr> CPU Usage : $resultcpu % <hr> HDD Usage : $resulthdd %";
}

if($_GET[display]=="ON"){
	echo "$resultcpu\n$resultmemory\n$resulthdd\n$totalSpace\n$usedSpace";
	
}

$OS_name=PHP_OS." ".php_uname('r');
$apache_name=apache_get_version();
$php_name=phpversion();

if($_GET[display]=="ON"){
	echo "\n$OS_name\n$apache_name\n$php_name";
	
}


?>