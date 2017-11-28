<?
session_start();
set_time_limit(0);
include("config.inc.php");
include("function.inc.php");

if($_GET[action]=="reset"){
conn($host,$username,$pwd);
$sqlx= " UPDATE  sms_status  SET  sendstatus = 'w' , sms_result = 'w' WHERE sendstatus <> 'w' AND sms_result <> 'w'  ";
mysql_db_query($database_sys,$sqlx);
mysql_close();
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<link href="nms_style.css" rel="stylesheet" type="text/css">
<title>Reset</title>
</head>
<body bgcolor="#FFFFFF">
<div align="center"><a href="?action=reset"><img src="images/reset_button-297x300.jpg" alt="reset config" width="297" height="300" border="0"></a>
  <br>
  <a href="?action=reset">RESET</a></div>
</body>
</html>
