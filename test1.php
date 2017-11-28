<?
snmp_set_oid_numeric_print(1);

// Get just the values.
snmp_set_quick_print(TRUE);

// For sequence types, return just the numbers, not the string and numbers.
snmp_set_enum_print(TRUE); 

// Don't let the SNMP library get cute with value interpretation.  This makes 
// MAC addresses return the 6 binary bytes, timeticks to return just the integer
// value, and some other things.
snmp_set_valueretrieval(SNMP_VALUE_PLAIN);  

$host = 'localhost';
$community = 'public';

//get system name
$sysname = snmpget($host, $community, "system.sysName.0");

//get system uptime
$sysup = snmpget($host, $community, "system.sysUpTime.0");
$sysupre = eregi_replace("([0-9]{3})","",$sysup);
$sysupre2 = eregi_replace("Timeticks:","",$sysupre);
$sysupre3 = eregi_replace("[()]","",$sysupre2);

//get tcp connections
$tcpcon = snmpget($host, $community,"tcp.tcpCurrEstab.0");
$tcpconre = eregi_replace("Gauge32:","",$tcpcon);

echo '
System Name: '.$sysname.'<br>
System Uptime: '.$sysupre3.'<br>
Current Tcp Connections: '.$tcpconre.'<br>';

//snmp_set_quick_print(0);  // is default
$strIP = "localhost"; $strComm = "public"; 
$strOID =  ".1.3.6.1.2.1.2.2.1.7.1";
echo "\n Default valueretrieval with snmp_set_quick_print(0)";
echo " snmp_get_valueretrieval = SNMP_VALUE_LIBRARY";
echo ", retrieved value " .  snmpget($strIP, $strComm, $strOID);  
snmp_set_valueretrieval(SNMP_VALUE_LIBRARY);    
echo "\n SNMP_VALUE_LIBRARY " . snmp_get_valueretrieval();
echo ", retrieved value " .   snmpget($strIP, $strComm, $strOID);  
snmp_set_valueretrieval(SNMP_VALUE_PLAIN);    
echo "\n SNMP_VALUE_PLAIN " . snmp_get_valueretrieval();
echo ", retrieved value " .  snmpget($strIP, $strComm, $strOID);  

snmp_set_quick_print(1);
echo "\n Default valueretrieval snmp_set_quick_print(0) " ;
snmp_set_valueretrieval(SNMP_VALUE_LIBRARY);    
echo "\n SNMP_VALUE_LIBRARY " . snmp_get_valueretrieval();
echo ", retrieved value " .   snmpget($strIP, $strComm, $strOID);  
snmp_set_valueretrieval(SNMP_VALUE_PLAIN);    
echo "\n SNMP_VALUE_PLAIN " . snmp_get_valueretrieval();
echo ", retrieved value " .  snmpget($strIP, $strComm, $strOID);  


                     
$sysDescr = snmpget("$host","$community","system.sysDescr.0"); 
$ifDescr = snmpwalk("$host","$community","interfaces.ifTable.ifEntry.ifDescr"); 
$ifIndex = snmpwalk("$host","$community","interfaces.ifTable.ifEntry.ifIndex"); 
$ifAdminStatus = snmpwalk("$host","$community","interfaces.ifTable.ifEntry.ifAdminStatus"); 
$ifOperStatus = snmpwalk("$host","$community","interfaces.ifTable.ifEntry.ifOperStatus"); 
$ifLastChange = snmpwalk("$host","$community","interfaces.ifTable.ifEntry.ifLastChange"); 
                                          
print "<table border=1 bgcolor=#ffffff><tr><td>$host</td></tr></table><br>"; 
print "<table border=1 bgcolor=#ffffff><tr><td>$sysDescr</td></tr></table><br>"; 
print "<table border=1 bgcolor=#ffffff>"; 
print "<tr> 
        <td>ifIndex</td> 
        <td>ifDescr</td> 
        <td>ifAdminStatus</td> 
        <td>ifOperStatus</td> 
        <td>ifLastChange</td> 
        </tr>"; 
             
for ($i=0; $i<count($ifIndex); $i++) { 
        print "<tr>"; 
        print "<td>$ifIndex[$i]</td>"; 
        print "<td>$ifDescr[$i]</td>"; 
        print "<td>$ifAdminStatus[$i]</td>"; 
        print "<td>$ifOperStatus[$i]</td>"; 
        print "<td>$ifLastChange[$i]</td>"; 
        print "</tr>"; 
}            
print "</table>"; 

$a = snmpwalk("localhost", "public", "interfaces.ifTable.ifEntry.ifAdminStatus"); 
for ($i=0; $i<count($a); $i++) {
    echo $a[$i]."<br>";
}


?> 
