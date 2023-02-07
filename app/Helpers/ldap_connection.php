<?php
namespace app\Helpers;

class ldap_connection{
    public $ldapHost, $port, $baseDn, $upn, $ldapPassword;
    public function __construct(){
        $this->config = config('ldap');
        $this->ldapHost = "172.25.1.38";
        $this->port = 389;
        $this->baseDn = "dc=emp-one,dc=com";
        $this->upn = "ssvc-intranet@emp-one.com"; //user test
        $this->ldapPassword = "P@ssw0rd27"; //user test
    }

    public function search($filter, $username, $password){ //filter example samaccountname=username

    $ldap_host = $this->ldapHost;
    // connect to active directory
    $ldapconn = ldap_connect($ldap_host, $this->port) or die("Could not connect to LDAP Server");
    //ldap bind
    $baseDn = $this->baseDn;
    $upn = $username;
    $ldappass = $password;
    $ldaptree = "cn=ssvc-intranet,cn=Users,dc=emp-one,dc=com";
    // set connection is using protocol version 3, if not will occur warning error.
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        if ($ldapconn) {
            // binding to ldap server
            $ldapbind = ldap_bind($ldapconn, $upn, $ldappass);
            // verify binding
            if($ldapbind){
                $attributes = ['displayname','description','givenname','telephonenumber','whencreated','whenchanged','department','company','streetaddress',
                'extensionattribute12','extensionattribute15','name','objectguid','employeeid','samaccountname','userprincipalname',
                'mail','msexchwhenmailboxcreated','physicaldeliveryofficename','division'];
                $results = ldap_search($ldapconn, $baseDn, $filter, $attributes);
                $info = ldap_get_entries($ldapconn, $results);
                $entry_array = $info;
                if(count($entry_array) < 1){
                    return null;
                    die();
                }//end if return
                $person_array = array();
                for ($i = 0; $i < count($entry_array) - 1; $i++) {
                    $person = array();
                    if ($entry_array[$i]) {
                        foreach ($attributes as $idx => $att) {
                            if (isset($entry_array[$i][$att])) {
                                $person[$att] = json_encode(str_replace("\r\n","<br/>",str_replace('"','',$entry_array[$i][$att][0])));
                            }else{
                            $person[$att] = '-';
                            }
                        }
                    }
                    $person_array[] = $person;
                }
            return (empty($person_array) ?  null : $person_array[0]);
            ldap_unbind($ldapconn);
            }
        }
        ldap_close($ldapconn);
    } //endfunction

}//end class
?>
