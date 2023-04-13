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
// ---- Load template
	$tmpl_x = new XTemplate (MyRep("search.htm"));
	$tmpl_x->assign("path_module","$module/$mod");

	require_once($appfolder."/class/user.inc.php");
	require_once($appfolder."/class/vol.inc.php");
	require_once($appfolder."/class/avion.inc.php");

	$tl=checkVar("tl","numeric",0,30);
	$ts=checkVar("ts","numeric");

// ---- Affiche le menu
	$aff_menu="";
	// addPageMenu("","logs","Ajouter",geturl("logs","edit",""),"");

// ---- Get my id	
	$id=$myuser->id;

// ---- Save Flight
	if (($fonc=="Enregistrer") && (!isset($_SESSION['tab_checkpost'][$_REQUEST["checktime"]])))
	{
		$lid=checkVar("lid","numeric");
		$fl=new flight_class($lid,$sql);
		if (count($form_data)>0)
		{
			foreach($form_data as $k=>$v)
		  	{
		  		$msg_erreur.=$fl->Valid($k,$v);
		  	}
		}

		$fl->Save();
		if ($lid==0)
		{
			$lid=$fl->id;
		}
		$msg_confirmation.="Vos données ont été enregistrées.<BR>";
		
		$_SESSION['tab_checkpost'][$checktime]=$checktime;

	}

	
// ---- Delete flight
	if (($fonc=="delete") && (is_numeric($_REQUEST["lid"])))
	{
		$q="DELETE FROM ".$MyOpt["tbl"]."_flight WHERE id='".$_REQUEST["lid"]."'";
		$sql->Delete($q);
	}

// ---- Initialize variables


// ---- Fill Fields
	$fl=new flight_class(0,$sql);

	$dte_flight=checkVar("form_dte_flight","date");
	$callsign=checkVar("form_calsign","varchar",10);
	$trie=checkVar("trie","varchar",1);
	$order=checkVar("order","varchar",10);
	$tabsearch=checkVar("tabsearch","array");

	if ($order=="")
	{
		$order="dte_flight";
	}
	
	if ($dte_flight!="0000-00-00")
	{
		$fl->data["dte_flight"]=$dte_flight;
	}
	if ($callsign!="")
	{
		// $fl->data["callsign"]=$callsign;
	}

	$fl->Render("form","form");

// ---- Calculate total line
	$usr = new user_class($id,$sql,true);

	$query = "SELECT COUNT(*) AS nb,
		SUM(time_dc_day) AS time_dc_day,
		SUM(time_cdb_day) AS time_cdb_day,
		SUM(time_dc_night) AS time_dc_night,
		SUM(time_cdb_night) AS time_cdb_night,
		SUM(time_simu) AS time_simu 
		FROM ".$MyOpt["tbl"]."_flight WHERE uid=$id";
	$res=$sql->QueryRow($query);

	$tmpl_x->assign("tot_time_dc_day",AffTemps($res['time_dc_day'],"no"));

	$res['time_dc_day']=$res['time_dc_day']+$usr->data['time_dc_day'];
	$res['time_cdb_day']=$res['time_cdb_day']+$usr->data['time_cdb_day'];
	$res['time_dc_night']=$res['time_dc_night']+$usr->data['time_dc_night'];
	$res['time_cdb_night']=$res['time_cdb_night']+$usr->data['time_cdb_night'];
	$res['time_simu']=$res['time_simu']+$usr->data['time_simu'];
	
// ---- Set table header

	$tabTitre=array();
	$tabTitre["dte_flight"]["aff"]="Date";
	$tabTitre["dte_flight"]["width"]=130;
if ($theme!="phone") {
	$tabTitre["callsign"]["aff"]="Immat";
	$tabTitre["callsign"]["width"]=80;
	$tabTitre["type"]["aff"]="Fonction";
	$tabTitre["type"]["width"]=80;
}
	$tabTitre["comment"]["aff"]="Nature du vol";
	$tabTitre["comment"]["width"]=250;
if ($theme!="phone") {
	$tabTitre["line1"]["aff"]="<line>";
	$tabTitre["line1"]["width"]=1;
	$tabTitre["time_dc_day"]["aff"]="DC Jour<br />".AffTemps($res['time_dc_day'],"no");
	$tabTitre["time_dc_day"]["width"]=80;
	$tabTitre["time_cdb_day"]["aff"]="CDB Jour<br />".AffTemps($res['time_cdb_day'],"no");
	$tabTitre["time_cdb_day"]["width"]=80;
	$tabTitre["time_dc_night"]["aff"]="DC Nuit<br />".AffTemps($res['time_dc_night'],"no");
	$tabTitre["time_dc_night"]["width"]=80;
	$tabTitre["time_cdb_night"]["aff"]="CDB Nuit<br />".AffTemps($res['time_cdb_night'],"no");
	$tabTitre["time_cdb_night"]["width"]=80;
	$tabTitre["time_simu"]["aff"]="Simu<br />".AffTemps($res['time_simu'],"no");
	$tabTitre["time_simu"]["width"]=80;
	$tabTitre["line2"]["aff"]="<line>";
	$tabTitre["line2"]["width"]=1;
	$tabTitre["nb_ifr"]["aff"]="ARR IFR";
	$tabTitre["nb_ifr"]["width"]=60;
	$tabTitre["nb_att"]["aff"]="Nb ATT";
	$tabTitre["nb_att"]["width"]=60;
	$tabTitre["nb_amerr"]["aff"]="Nb AMERR";
	$tabTitre["nb_amerr"]["width"]=60;
}
	$tabTitre["delete"]["aff"]=" ";
	$tabTitre["delete"]["width"]=50;

// ---- Load flights

	$s="";
	if ((isset($tabsearch)) && (is_array($tabsearch)))
	{
		foreach($tabsearch as $v=>$d)
		{
			if ($d!="")
			{
				$s.="AND ".$v." LIKE '%".$d."%' ";
			}
		}
	}

	$query = "SELECT COUNT(*) AS nb FROM ".$MyOpt["tbl"]."_flight WHERE uid=$id ";
	$query.=$s;
	$res=$sql->QueryRow($query);

	$query = "SELECT * FROM ".$MyOpt["tbl"]."_flight WHERE uid=$id ";
	$query.=$s;
	$query.="ORDER BY $order ".((($trie=="i") || ($trie=="")) ? "DESC" : "").", id DESC LIMIT $ts,$tl";

	$sql->Query($query);


	$tabValeur=array();
	$totligne=$res["nb"];

	for($i=0; $i<$sql->rows; $i++)
	{ 
		$sql->GetRow($i);

		$tabValeur[$i]["dte_flight"]["val"]=CompleteTxt($i,"20","0");
		$tabValeur[$i]["dte_flight"]["aff"]=date("d/m/Y",strtotime($sql->data["dte_flight"]));
		$tabValeur[$i]["callsign"]["val"]=$sql->data["callsign"];
		$tabValeur[$i]["callsign"]["aff"]=strtoupper($sql->data["callsign"]);
		$tabValeur[$i]["type"]["val"]=$sql->data["type"];
		$tabValeur[$i]["type"]["aff"]=$sql->data["type"];
		$tabValeur[$i]["type"]["align"]="center";
		$tabValeur[$i]["comment"]["val"]=$sql->data["comment"];
		$tabValeur[$i]["comment"]["aff"]="<div style='width:245px;'>".$sql->data["comment"]."</div>";
		$tabValeur[$i]["line1"]["val"]="<line>";
		$tabValeur[$i]["time_dc_day"]["val"]=$sql->data["time_dc_day"];
		$tabValeur[$i]["time_dc_day"]["aff"]=($sql->data["time_dc_day"]>0) ? AffTemps($sql->data["time_dc_day"],"no") : "&nbsp;";
		$tabValeur[$i]["time_dc_day"]["align"]="center";
		$tabValeur[$i]["time_cdb_day"]["val"]=$sql->data["time_cdb_day"];
		$tabValeur[$i]["time_cdb_day"]["aff"]=($sql->data["time_cdb_day"]>0) ? AffTemps($sql->data["time_cdb_day"],"no") : "&nbsp;";
		$tabValeur[$i]["time_cdb_day"]["align"]="center";
		$tabValeur[$i]["time_dc_night"]["val"]=$sql->data["time_dc_night"];
		$tabValeur[$i]["time_dc_night"]["aff"]=($sql->data["time_dc_night"]>0) ? AffTemps($sql->data["time_dc_night"],"no") : "&nbsp;";
		$tabValeur[$i]["time_dc_night"]["align"]="center";
		$tabValeur[$i]["time_cdb_night"]["val"]=$sql->data["time_cdb_night"];
		$tabValeur[$i]["time_cdb_night"]["aff"]=($sql->data["time_cdb_night"]>0) ? AffTemps($sql->data["time_cdb_night"],"no") : "&nbsp;";
		$tabValeur[$i]["time_cdb_night"]["align"]="center";
		$tabValeur[$i]["time_simu"]["val"]=$sql->data["time_simu"];
		$tabValeur[$i]["time_simu"]["aff"]=($sql->data["time_simu"]>0) ? AffTemps($sql->data["time_simu"],"no") : "&nbsp;";
		$tabValeur[$i]["time_simu"]["align"]="center";
		$tabValeur[$i]["line2"]["val"]="<line>";
		$tabValeur[$i]["nb_ifr"]["val"]=$sql->data["nb_ifr"];
		$tabValeur[$i]["nb_ifr"]["aff"]="&nbsp;".($sql->data["nb_ifr"]);
		$tabValeur[$i]["nb_ifr"]["align"]="center";
		$tabValeur[$i]["nb_att"]["val"]=$sql->data["nb_att"];
		$tabValeur[$i]["nb_att"]["aff"]=$sql->data["nb_att"];
		$tabValeur[$i]["nb_att"]["align"]="center";
		$tabValeur[$i]["nb_amerr"]["val"]=$sql->data["nb_amerr"];
		$tabValeur[$i]["nb_amerr"]["aff"]=$sql->data["nb_amerr"];
		$tabValeur[$i]["nb_amerr"]["align"]="center";
		$tabValeur[$i]["delete"]["val"]="x";
		$tabValeur[$i]["delete"]["aff"]="<a class='imgDelete' href='/logs/edit?lid=".$sql->data["id"]."'><i class='mdi mdi-pencil'></i></a>";
		$tabValeur[$i]["delete"]["aff"].="<a href='/logs/search?fonc=delete&lid=".$sql->data["id"]."&ts=".$ts."' class='imgDelete'><i class='mdi mdi-delete'></i></a>";
	}


	if ($order=="") { $order="date"; }
	$tmpl_x->assign("aff_tableau",AfficheTableauFiltre($tabValeur,$tabTitre,$order,$trie,$url="id=$id",$ts,$tl,$totligne,true));

	$tmpl_x->assign("form_checktime",$_SESSION['checkpost']);

	

// ---- Affecte les variables d'affichage
	$tmpl_x->parse("icone");
	$icone=$tmpl_x->text("icone");
	$tmpl_x->parse("infos");
	$infos=$tmpl_x->text("infos");
	$tmpl_x->parse("corps");
	$corps=$tmpl_x->text("corps");



?>
