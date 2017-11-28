// Compile : gcc `net-snmp-config --cflags` `net-snmp-config --libs` `net-snmp-config --external-libs` snmp_walk.c -o snmp_walk

#include <net-snmp/net-snmp-config.h>
#include <net-snmp/net-snmp-includes.h>
#include <string.h>

int main(int argc, char ** argv)
{
  struct snmp_session session; 
  struct snmp_session *sess_handle;

  struct snmp_pdu *pdu;                   
  struct snmp_pdu *response;

  struct variable_list *vars;            

  oid ifDescr_oid[MAX_OID_LEN];
  oid ifInOctets_oid[MAX_OID_LEN];

  size_t ifDescr_len = MAX_OID_LEN;
  size_t ifInOctets_len = MAX_OID_LEN;

  int status;                             

  struct tree * mib_tree;
	
  /*********************/

  if(argv[1] == NULL){
	printf("Please supply a hostname\n");
	exit(1);
  }

  init_snmp("APC Check");

  snmp_sess_init( &session );
   session.version = SNMP_VERSION_1;
   session.community = "public";
   session.community_len = strlen(session.community);
   session.peername = argv[1];
  sess_handle = snmp_open(&session);

  add_mibdir("."); 
//  mib_tree = read_mib("PowerNet-MIB.txt"); 

  pdu = snmp_pdu_create(SNMP_MSG_GET);

  read_objid("IF-MIB:ifDescr.3", ifDescr_oid, &ifDescr_len);
  snmp_add_null_var(pdu, ifDescr_oid, ifDescr_len);
        
  read_objid("IF-MIB:ifInOctets.3", ifInOctets_oid, &ifInOctets_len);
  snmp_add_null_var(pdu, ifInOctets_oid, ifInOctets_len);

  status = snmp_synch_response(sess_handle, pdu, &response);
        
  for(vars = response->variables; vars; vars = vars->next_variable)
	print_value(vars->name, vars->name_length, vars);

  snmp_free_pdu(response);
  snmp_close(sess_handle);
        
  return (0);
}
