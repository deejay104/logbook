<?
// ---- Desktop

	$tabMenu["logs"]=array(
		"icone"=>"mdi-history",
		"nom"=>"Log des vols",
		"droit"=>"AccesVols",
		"url"=>geturl("logs","index",""),
		"submenu"=>array(
			array("nom"=>"Ajouter un vol","url"=>geturl("logs","edit",""),"droit"=>"AccesVols"),
			array("nom"=>"Carnet de vol","url"=>geturl("logs","index",""),"droit"=>"AccesVols"),
			array("nom"=>"Rechercher","url"=>geturl("logs","search",""),"droit"=>"AccesVols"),
		),
	);

	$tabMenu["rapports"]=array(
		"icone"=>"mdi-table",
		"nom"=>"Rapports",
		"droit"=>"AccesRapports",
		"url"=>geturl("rapports","index",""),
		"submenu"=>array(
			array("nom"=>"Totaux","url"=>geturl("rapports","index",""),"droit"=>"AccesRapports"),
			array("nom"=>"12 mois","url"=>geturl("rapports","mois",""),"droit"=>"AccesRapports"),
		),
	);

	$tabMenu["rapports"]["icone"]="mdi-table";
	$tabMenu["rapports"]["nom"]="Rapports";
	$tabMenu["rapports"]["droit"]="AccesRapports";
	$tabMenu["rapports"]["url"]=geturl("rapports","index","");

	$tabMenu["avions"]["icone"]="mdi-airplane";
	$tabMenu["avions"]["nom"]="Avions";
	$tabMenu["avions"]["droit"]="AccesAvions";
	$tabMenu["avions"]["url"]=geturl("avions","index","");
	
// ---- Phone
	$tabMenuPhone["ajouter"]=array(
		"icone"=>"mdi-plus-box",
		"nom"=>"Ajouter vol",
		"droit"=>"AccesVols",
		"url"=>geturl("logs","edit",""),
	);
	$tabMenuPhone["logs"]=array(
		"icone"=>"mdi-history",
		"nom"=>"Log des vols",
		"droit"=>"AccesVols",
		"url"=>geturl("logs","index",""),
	);
	$tabMenuPhone["rapport"]=array(
		"icone"=>"mdi-table",
		"nom"=>"Rapports",
		"droit"=>"AccesRapports",
		"url"=>geturl("rapports","mois",""),
	);
?>