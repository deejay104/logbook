<?
$tabCustom=Array
(
	"flight" => Array
	(
		"id" => Array("Type" => "int(10) unsigned", "Index" => "PRIMARY", ),
		"uid" => Array("Type" => "int(10) unsigned", "Index"=>"1"),
		"dte_flight" => Array("Type" => "date", "Default" => "0000-00-00"),
		"callsign" => Array("Type" => "varchar(8)", "Index"=>"1"),
		"type" => Array("Type" => "varchar(4)"),
		"comment" => Array("Type" => "varchar(50)"),
		"time_dc_day" => Array("Type" => "int(10) unsigned"),
		"time_cdb_day" => Array("Type" => "int(10) unsigned"),
		"time_dc_night" => Array("Type" => "int(10) unsigned"),
		"time_cdb_night" => Array("Type" => "int(10) unsigned"),
		"time_simu" => Array("Type" => "int(10) unsigned"),
		"nb_ifr" => Array("Type" => "int(10) unsigned"),
		"nb_att" => Array("Type" => "int(10) unsigned"),
		"nb_amerr" => Array("Type" => "int(10) unsigned")
	),
	"utilisateurs" => Array
	(
		"time_dc_day" => Array("Type" => "int(10) unsigned"),
		"time_cdb_day" => Array("Type" => "int(10) unsigned"),
		"time_dc_night" => Array("Type" => "int(10) unsigned"),
		"time_cdb_night" => Array("Type" => "int(10) unsigned"),
		"time_simu" => Array("Type" => "int(10) unsigned"),
	)

);



?>