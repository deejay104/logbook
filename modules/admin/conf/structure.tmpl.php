<?
$tabCustom=Array
(
	// "plane" => Array
	// (
		// "id" => Array("Type" => "int(10) unsigned", "Index" => "PRIMARY", ),
		// "uid" => Array("Type" => "int(10) unsigned", "Index"=>"1"),
		// "callsign" => Array("Type" => "varchar(8)", "Index"=>"1"),
		// "type" => Array("Type" => "varchar(10)"),
		// "comment" => Array("Type" => "varchar(50)"),
		// "uid_creat" => Array("Type" => "int(10) unsigned", "Default" => "0"),
		// "dte_creat" => Array("Type" => "datetime", "Default" => "0000-00-00 00:00:00"),
		// "uid_maj" => Array("Type" => "int(10) unsigned", "Default" => "0", ),
		// "dte_maj" => Array("Type" => "datetime", "Default" => "0000-00-00 00:00:00", ),
	// ),
	
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

	// "flight" => Array
	// (
		// "id" => Array("Type" => "int(10) unsigned", "Index" => "PRIMARY", ),
		// "uid" => Array("Type" => "int(10) unsigned", "Index"=>"1"),
		// "dte_flight" => Array("Type" => "date", "Default" => "0000-00-00"),
		// "callsign" => Array("Type" => "varchar(8)", "Index"=>"1"),
		// "type" => Array("Type" => "varchar(4)"),
		// "comment" => Array("Type" => "varchar(50)"),
		// "member_day" => Array("Type" => "int(10) unsigned"),
		// "member_night" => Array("Type" => "int(10) unsigned"),
		// "time_dc_day" => Array("Type" => "int(10) unsigned"),
		// "time_cdb_day" => Array("Type" => "int(10) unsigned"),
		// "time_dc_night" => Array("Type" => "int(10) unsigned"),
		// "time_cdb_night" => Array("Type" => "int(10) unsigned"),
		// "multi_dc_day" => Array("Type" => "int(10) unsigned"),
		// "multi_cdb_day" => Array("Type" => "int(10) unsigned"),
		// "multi_copi_day" => Array("Type" => "int(10) unsigned"),
		// "multi_dc_night" => Array("Type" => "int(10) unsigned"),
		// "multi_cdb_night" => Array("Type" => "int(10) unsigned"),
		// "multi_copi_night" => Array("Type" => "int(10) unsigned"),
		// "instru_double" => Array("Type" => "int(10) unsigned"),
		// "instru_pilote" => Array("Type" => "int(10) unsigned"),
		// "time_simu" => Array("Type" => "int(10) unsigned"),
		// "nb_ifr" => Array("Type" => "int(10) unsigned"),
		// "nb_att" => Array("Type" => "int(10) unsigned"),
		// "nb_amerr" => Array("Type" => "int(10) unsigned"),
		// "uid_creat" => Array("Type" => "int(10) unsigned", "Default" => "0"),
		// "dte_creat" => Array("Type" => "datetime", "Default" => "0000-00-00 00:00:00"),
		// "uid_maj" => Array("Type" => "int(10) unsigned", "Default" => "0", ),
		// "dte_maj" => Array("Type" => "datetime", "Default" => "0000-00-00 00:00:00", ),
	// ),

	require_once ($appfolder."/class/vol.inc.php");
	$obj=new flight_class(0,$sql);
	$obj->genSqlTab($tabCustom);

	require_once ($appfolder."/class/avion.inc.php");
	$obj=new plane_class(0,$sql);
	$obj->genSqlTab($tabTmpl);

?>