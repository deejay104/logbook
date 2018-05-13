<?
$tabCustom=Array
(
	"echeance" => Array
	(
		"id" => Array("Type" => "bigint(20) unsigned", "Index" => "PRIMARY", ),
		"typeid" => Array("Type" => "int(10) unsigned", "Index" => "1", ),
		"uid" => Array("Type" => "int(10) unsigned", "Index" => "1", ),
		"dte_echeance" => Array("Type" => "date", ),
		"paye" => Array("Type" => "enum('oui','non')", "Default" => "non", ),
		"actif" => Array("Type" => "enum('oui','non')", "Default" => "oui", "Index"=>1 ),
		"dte_create" => Array("Type" => "datetime", "Default" => "0000-00-00 00:00:00"),
		"uid_create" => Array("Type" => "int(10) unsigned", ),
		"dte_maj" => Array("Type" => "datetime", "Default" => "0000-00-00 00:00:00"),
		"uid_maj" => Array("Type" => "int(10) unsigned", ),
	),
	"echeancetype" => Array
	(
		"id" => Array("Type" => "int(10) unsigned", "Index" => "PRIMARY", ),
		"description" => Array("Type" => "varchar(100)", ),
		"poste" => Array("Type" => "int(11)", "Index" => "1", ),
		"cout" => Array("Type" => "decimal(10,2)", "Default" => "0.00", ),
		"resa" => Array("Type" => "enum('obligatoire','instructeur','facultatif')", ),
		"droit" => Array("Type" => "varchar(3)", ),
		"multi" => Array("Type" => "enum('oui','non')", "Default" => "non", ),
		"notif" => Array("Type" => "enum('oui','non')", "Default" => "non", ),
		"delai" => Array("Type" => "tinyint(3) unsigned", "Default" => "30", ),
	),
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