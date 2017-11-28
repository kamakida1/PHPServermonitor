<?
echo "<pre>";
	system("uptime"); 
	system("uname -a");
	system("free -m");
	system("df -h");

$OS_name=PHP_OS." ".php_uname('r');
$apache_name=apache_get_version();
$php_name=phpversion();

?>