<?
/*	
$tabCustom=Array
(
	"utilisateurs" => Array
	(
		"member_day" => Array("Type" => "int(10) unsigned"),
		"member_night" => Array("Type" => "int(10) unsigned"),
		"time_dc_day" => Array("Type" => "int(10) unsigned"),
		"time_cdb_day" => Array("Type" => "int(10) unsigned"),
		"time_dc_night" => Array("Type" => "int(10) unsigned"),
		"time_cdb_night" => Array("Type" => "int(10) unsigned"),
		"multi_dc_day" => Array("Type" => "int(10) unsigned"),
		"multi_cdb_day" => Array("Type" => "int(10) unsigned"),
		"multi_copi_day" => Array("Type" => "int(10) unsigned"),
		"multi_dc_night" => Array("Type" => "int(10) unsigned"),
		"multi_cdb_night" => Array("Type" => "int(10) unsigned"),
		"multi_copi_night" => Array("Type" => "int(10) unsigned"),
		"instru_double" => Array("Type" => "int(10) unsigned"),
		"instru_pilote" => Array("Type" => "int(10) unsigned"),
		"time_simu" => Array("Type" => "int(10) unsigned"),
		"nb_ifr" => Array("Type" => "int(10) unsigned"),
	)

);
*/

	require_once ($appfolder."/class/user.inc.php");
	$obj=new user_class(0,$sql);
	$obj->genSqlTab($tabTmpl);


	require_once ($appfolder."/class/vol.inc.php");
	$obj=new flight_class(0,$sql);
	$obj->genSqlTab($tabCustom);

	require_once ($appfolder."/class/avion.inc.php");
	$obj=new plane_class(0,$sql);
	$obj->genSqlTab($tabTmpl);

	require_once ($appfolder."/class/navpoints.inc.php");
	$obj=new navpoint_class(0,$sql);
	$obj->genSqlTab($tabTmpl);

?>