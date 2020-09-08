<?php
/*
    LogBook
    Copyright (C) 2018 Matthieu Isorez

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>

<?php
	require_once($appfolder."/class/avion.inc.php");

// ---- Vérifie les variables
	$id=checkVar("id","numeric");
	$order=checkVar("order","varchar");
	$trie=checkVar("order","varchar");

// ---- Charge template
	$tmpl_x = new XTemplate (MyRep("detail.htm"));
	$tmpl_x->assign("path_module",$module."/".$mod);
	$tmpl_x->assign("form_checktime",$_SESSION['checkpost']);

// ---- Enregistre
	$msg_erreur="";
	$msg_confirmation="";
	if (($fonc=="Enregistrer") && (!isset($_SESSION['tab_checkpost'][$_REQUEST["checktime"]])))
	{
		$form_data=checkVar("form_data","array");

		$avion=new plane_class($id,$sql);
		if (count($form_data)>0)
		{
			foreach($form_data as $k=>$v)
		  	{
		  		$msg_erreur.=$avion->Valid($k,$v);
		  	}
		}

		$avion->Save();
		if ($id==0)
		{
			$id=$avion->id;
		}
		$msg_confirmation.="Vos données ont été enregistrées.<BR>";
		
		$_SESSION['tab_checkpost'][$checktime]=$checktime;

		$affrub="index";
	}
	else if ($fonc=="Annuler")
	{
		$affrub="index";
	}
	
// ---- Charge les données
	$avion=new plane_class($id,$sql);
	$avion->Render("form","form");

	$tmpl_x->assign("form_dte_maj",DisplayDate($avion->dte_maj));

	// ---- Totaux
		$q="SELECT
			SUM(time_dc_day) AS dc_day,
			SUM(time_cdb_day) AS cdb_day,
			SUM(time_dc_night) AS dc_night,
			SUM(time_cdb_night) AS cdb_night,
			SUM(time_simu) AS simu,
			SUM(multi_dc_day) AS multi_dc_day,
			SUM(multi_cdb_day) AS multi_cdb_day,
			SUM(multi_copi_day) AS multi_copi_day,
			SUM(multi_dc_night) AS multi_dc_night,
			SUM(multi_cdb_night) AS multi_cdb_night,
			SUM(multi_copi_night) AS multi_copi_night,
			SUM(nb_ifr) AS nb_ifr,
			SUM(nb_att) AS nb_att,
			SUM(nb_amerr) AS nb_amerr
			FROM ".$MyOpt["tbl"]."_flight
			WHERE uid='".$gl_uid."' AND callsign='".$avion->data["callsign"]."'";
		$res=$sql->QueryRow($q);

	// ---- Tableau
		$tabTitre=array();
		$tabTitre["dte"]["aff"]="Année";
		$tabTitre["dte"]["bottom"]="Total";
		$tabTitre["dte"]["width"]=80;
		$tabTitre["line1"]["aff"]="<line>";
		$tabTitre["line1"]["width"]=10;
		$tabTitre["dc_day"]["aff"]="DC Jour";
		$tabTitre["dc_day"]["bottom"]=AffTemps($res["dc_day"],"no");
		$tabTitre["dc_day"]["width"]=80;
		$tabTitre["cdb_day"]["aff"]="CDB Jour";
		$tabTitre["cdb_day"]["bottom"]=AffTemps($res["cdb_day"],"no");
		$tabTitre["cdb_day"]["width"]=80;
		$tabTitre["dc_night"]["aff"]="DC Nuit";
		$tabTitre["dc_night"]["bottom"]=AffTemps($res["dc_night"],"no");
		$tabTitre["dc_night"]["width"]=80;
		$tabTitre["cdb_night"]["aff"]="CDB Nuit";
		$tabTitre["cdb_night"]["bottom"]=AffTemps($res["cdb_night"],"no");
		$tabTitre["cdb_night"]["width"]=80;
		$tabTitre["simu"]["aff"]="Simu";
		$tabTitre["simu"]["bottom"]=AffTemps($res["simu"],"no");
		$tabTitre["simu"]["width"]=80;
		$tabTitre["multi_dc_day"]["aff"]="DC Jour/M";
		$tabTitre["multi_dc_day"]["bottom"]=AffTemps($res["multi_dc_day"],"no");
		$tabTitre["multi_dc_day"]["width"]=80;
		$tabTitre["multi_cdb_day"]["aff"]="CDB Jour/M";
		$tabTitre["multi_cdb_day"]["bottom"]=AffTemps($res["multi_cdb_day"],"no");
		$tabTitre["multi_cdb_day"]["width"]=80;
		$tabTitre["multi_copi_day"]["aff"]="Copi Jour/M";
		$tabTitre["multi_copi_day"]["bottom"]=AffTemps($res["multi_copi_day"],"no");
		$tabTitre["multi_copi_day"]["width"]=80;
		$tabTitre["multi_dc_night"]["aff"]="DC Nuit/M";
		$tabTitre["multi_dc_night"]["bottom"]=AffTemps($res["multi_dc_night"],"no");
		$tabTitre["multi_dc_night"]["width"]=80;
		$tabTitre["multi_cdb_night"]["aff"]="CDB Nuit/M";
		$tabTitre["multi_cdb_night"]["bottom"]=AffTemps($res["multi_cdb_night"],"no");
		$tabTitre["multi_cdb_night"]["width"]=80;
		$tabTitre["multi_copi_night"]["aff"]="Copi Nuit/M";
		$tabTitre["multi_copi_night"]["bottom"]=AffTemps($res["multi_copi_night"],"no");
		$tabTitre["multi_copi_night"]["width"]=80;
		$tabTitre["line2"]["aff"]="<line>";
		$tabTitre["line2"]["width"]=10;
		$tabTitre["total"]["aff"]="Total";
		$tabTitre["total"]["bottom"]=AffTemps($res["dc_day"]+$res["cdb_day"]+$res["dc_night"]+$res["cdb_night"]+$res["simu"]+$res["multi_dc_day"]+$res["multi_cdb_day"]+$res["multi_copi_day"]+$res["multi_dc_night"]+$res["multi_cdb_night"]+$res["multi_copi_night"],"no");
		$tabTitre["total"]["width"]=60;
		$tabTitre["line3"]["aff"]="<line>";
		$tabTitre["line3"]["width"]=10;
		$tabTitre["att"]["aff"]="ATT";
		$tabTitre["att"]["bottom"]=$res["nb_att"];
		$tabTitre["att"]["width"]=40;
		$tabTitre["amr"]["aff"]="AMR";
		$tabTitre["amr"]["bottom"]=$res["nb_amerr"];
		$tabTitre["amr"]["width"]=40;

		$q="SELECT YEAR(dte_flight) AS dte,
			SUM(time_dc_day) AS dc_day,
			SUM(time_cdb_day) AS cdb_day,
			SUM(time_dc_night) AS dc_night,
			SUM(time_cdb_night) AS cdb_night,
			SUM(time_simu) AS simu,
			SUM(multi_dc_day) AS multi_dc_day,
			SUM(multi_cdb_day) AS multi_cdb_day,
			SUM(multi_copi_day) AS multi_copi_day,
			SUM(multi_dc_night) AS multi_dc_night,
			SUM(multi_cdb_night) AS multi_cdb_night,
			SUM(multi_copi_night) AS multi_copi_night,
			SUM(nb_ifr) AS nb_ifr,
			SUM(nb_att) AS nb_att,
			SUM(nb_amerr) AS nb_amerr
			FROM ".$MyOpt["tbl"]."_flight WHERE uid='".$gl_uid."' AND callsign='".$avion->data["callsign"]."' GROUP BY YEAR(dte_flight)";
		$sql->Query($q);
		
		$tabValeur=array();

		for($i=0; $i<$sql->rows; $i++)
		{ 
			$sql->GetRow($i);

			$tabValeur[$i]["dte"]["val"]=$sql->data["dte"];
			$tabValeur[$i]["line1"]["val"]="<line>";
			$tabValeur[$i]["dc_day"]["val"]=$sql->data["dc_day"];
			$tabValeur[$i]["dc_day"]["aff"]=AffTemps($sql->data["dc_day"],"no");
			$tabValeur[$i]["dc_day"]["align"]="center";
			$tabValeur[$i]["cdb_day"]["val"]=$sql->data["cdb_day"];
			$tabValeur[$i]["cdb_day"]["aff"]=AffTemps($sql->data["cdb_day"],"no");
			$tabValeur[$i]["cdb_day"]["align"]="center";
			$tabValeur[$i]["dc_night"]["val"]=$sql->data["dc_night"];
			$tabValeur[$i]["dc_night"]["aff"]=AffTemps($sql->data["dc_night"],"no");
			$tabValeur[$i]["dc_night"]["align"]="center";
			$tabValeur[$i]["cdb_night"]["val"]=$sql->data["cdb_night"];
			$tabValeur[$i]["cdb_night"]["aff"]=AffTemps($sql->data["cdb_night"],"no");
			$tabValeur[$i]["cdb_night"]["align"]="center";
			$tabValeur[$i]["simu"]["val"]=$sql->data["simu"];
			$tabValeur[$i]["simu"]["aff"]=AffTemps($sql->data["simu"],"no");
			$tabValeur[$i]["simu"]["align"]="center";

			$tabValeur[$i]["multi_dc_day"]["val"]=$sql->data["multi_dc_day"];
			$tabValeur[$i]["multi_dc_day"]["aff"]=AffTemps($sql->data["multi_dc_day"],"no");
			$tabValeur[$i]["multi_dc_day"]["align"]="center";
			$tabValeur[$i]["multi_cdb_day"]["val"]=$sql->data["multi_cdb_day"];
			$tabValeur[$i]["multi_cdb_day"]["aff"]=AffTemps($sql->data["multi_cdb_day"],"no");
			$tabValeur[$i]["multi_cdb_day"]["align"]="center";
			$tabValeur[$i]["multi_copi_day"]["val"]=$sql->data["multi_copi_day"];
			$tabValeur[$i]["multi_copi_day"]["aff"]=AffTemps($sql->data["multi_copi_day"],"no");
			$tabValeur[$i]["multi_copi_day"]["align"]="center";
			$tabValeur[$i]["multi_dc_night"]["val"]=$sql->data["multi_dc_night"];
			$tabValeur[$i]["multi_dc_night"]["aff"]=AffTemps($sql->data["multi_dc_night"],"no");
			$tabValeur[$i]["multi_dc_night"]["align"]="center";
			$tabValeur[$i]["multi_cdb_night"]["val"]=$sql->data["multi_cdb_night"];
			$tabValeur[$i]["multi_cdb_night"]["aff"]=AffTemps($sql->data["multi_cdb_night"],"no");
			$tabValeur[$i]["multi_cdb_night"]["align"]="center";
			$tabValeur[$i]["multi_copi_night"]["val"]=$sql->data["multi_copi_night"];
			$tabValeur[$i]["multi_copi_night"]["aff"]=AffTemps($sql->data["multi_copi_night"],"no");
			$tabValeur[$i]["multi_copi_night"]["align"]="center";

			$tabValeur[$i]["line2"]["val"]="<line>";
			$tabValeur[$i]["total"]["val"]=$sql->data["dc_day"]+$sql->data["cdb_day"]+$sql->data["dc_night"]+$sql->data["cdb_night"]+$sql->data["simu"]+$sql->data["multi_dc_day"]+$sql->data["multi_cdb_day"]+$sql->data["multi_copi_day"]+$sql->data["multi_dc_night"]+$sql->data["multi_cdb_night"]+$sql->data["multi_copi_night"];
			$tabValeur[$i]["total"]["aff"]=AffTemps($sql->data["dc_day"]+$sql->data["cdb_day"]+$sql->data["dc_night"]+$sql->data["cdb_night"]+$sql->data["simu"]+$sql->data["multi_dc_day"]+$sql->data["multi_cdb_day"]+$sql->data["multi_copi_day"]+$sql->data["multi_dc_night"]+$sql->data["multi_cdb_night"]+$sql->data["multi_copi_night"],"no");
			$tabValeur[$i]["total"]["align"]="center";

			$tabValeur[$i]["line3"]["val"]="<line>";
			$tabValeur[$i]["att"]["val"]=$sql->data["nb_att"];
			$tabValeur[$i]["att"]["aff"]=$sql->data["nb_att"];
			$tabValeur[$i]["att"]["align"]="center";
			$tabValeur[$i]["amr"]["val"]=$sql->data["nb_amerr"];
			$tabValeur[$i]["amr"]["aff"]=$sql->data["nb_amerr"];
			$tabValeur[$i]["amr"]["align"]="center";
		  }

		if ((!isset($order)) || ($order=="")) { $order="dte"; }
		if ((!isset($trie)) || ($trie=="")) { $trie="d"; }

		$tmpl_x->assign("aff_tableau",AfficheTableau($tabValeur,$tabTitre,$order,$trie));


		$tmpl_x->assign("form_checktime",$_SESSION['checkpost']);

	
// ---- Affecte les variables d'affichage
	$tmpl_x->parse("icone");
	$icone=$tmpl_x->text("icone");
	$tmpl_x->parse("infos");
	$infos=$tmpl_x->text("infos");
	$tmpl_x->parse("corps");
	$corps=$tmpl_x->text("corps");
?>
