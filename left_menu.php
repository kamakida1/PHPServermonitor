<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="nms_style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="264" height="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td width="260" class="toppic_menu">Main Views </td>
  </tr>
  <tr>
    <td height="19"><a href="index.php" class="menu_link">Overall</a></td>
  </tr>
  <tr>
    <td height="19"><a href="hardware.php" class="menu_link">Hardware</a></td>
  </tr>
  <tr>
    <td height="19"><a href="hw.php?hw=cpu" class="menu_link">&nbsp; - CPU</a></td>
  </tr>
  <tr>
    <td height="19"><a href="hw.php?hw=Memory" class="menu_link">&nbsp; - MEMORY</a></td>
  </tr>
  <tr>
   <td height="19"><a href="network.php" class="menu_link">Network</a></td>
  </tr>
  <?   foreach($arr_ip AS $key=>$values){ ?>
   <tr>
    <td height="23"><a href="http://<?=$values[localIP]?>/awstats/awstats.pl" class="menu_link" target="_blank">&nbsp; - Advanced Web Statistics[<?=$values[localIP]?>]</a></td>
  </tr>
  <? } ?>
  <tr>
    <td height="19"><a href="service.php" class="menu_link">System Service</a></td>
  </tr>
  <tr>
    <td height="19"><a href="#" class="menu_link">Database</a></td>
  </tr>
  <?   foreach($arr_ip AS $key=>$values){ ?>
   <tr>
    <td height="23"><a href="database.php?siteip=<?=$values[localIP]?>" class="menu_link">&nbsp; - <?=$values[localIP]?></a></td>
  </tr>
  <? } ?>
    <tr>
    <td height="19"><a href="replication.php" class="menu_link">&nbsp; - Replication</a></td>
  </tr>
  <tr>
    <td height="19"><a href="#" class="menu_link">Application</a></td>
  </tr>
  <tr>
    <td height="25" class="toppic_menu">Tools </td>
  </tr>
  <tr>
    <td><a href="configuration.php" class="menu_link">Configuration</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="100%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
