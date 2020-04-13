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
	$tmpl_x = new XTemplate (MyRep("index.htm"));
	$tmpl_x->assign("path_module","$module/$mod");
	$tmpl_x->assign("form_checktime",$_SESSION['checkpost']);

	require_once($appfolder."/class/user.inc.php");
	require_once($appfolder."/class/vol.inc.php");
	require_once($appfolder."/class/avion.inc.php");

// ---- Affiche le menu
	$aff_menu="";
	require_once($appfolder."/modules/".$mod."/menu.inc.php");
	$tmpl_x->assign("aff_menu",$aff_menu);

// ---- Get my id	
	$id=$myuser->id;

// ---- Save Flight
	$msg_erreur="";
	if (($fonc=="Enregistrer") && (!isset($_SESSION['tab_checkpost'][$_REQUEST["checktime"]])))
	{
		$form_data=checkVar("form_data","array");
		
		$lid=checkVar("lid","numeric");
		$fl=new flight_class($lid,$sql);
		if (count($form_data)>0)
		{
			foreach($form_data as $k=>$v)
		  	{
		  		$msg_erreur=$fl->Valid($k,$v);
		  	}
		}

		$fl->Save();
		if ($lid==0)
		{
			$lid=$fl->id;
		}
		affInformation("Vos données ont été enregistrées","ok");

		$_SESSION['tab_checkpost'][$checktime]=$checktime;

	}

	
// ---- Show pages
	$p=checkVar("p","numeric",0,-1);

	$query = "SELECT COUNT(*) AS nb FROM ".$MyOpt["tbl"]."_flight WHERE uid=$id";
	$res=$sql->QueryRow($query);
	$nbtot=$res["nb"];
	
	$ii=1;
	$pp=0;
	for ($i=0;$i<$nbtot;$i=$i+14)
	{
		$tmpl_x->assign("aff_deb",$i);
		$tmpl_x->assign("aff_page",($i==$p) ? "[".$ii."]" : $ii);
		$pp=$i;
		$ii++;
		$tmpl_x->parse("corps.lst_page");
	}
	
// ---- Load flights
	if ($p==-1)
	{
		$p=$pp;
	}

	$query = "SELECT * FROM ".$MyOpt["tbl"]."_flight WHERE uid=$id ORDER BY dte_flight,id LIMIT $p,1";
	$res=$sql->QueryRow($query);

	$query = "SELECT SUM(member_day) AS member_day, SUM(member_night) AS member_night, ";
	$query.= "SUM(time_dc_day) AS tot_dc_day, SUM(time_cdb_day) AS tot_cdb_day, SUM(time_dc_night) AS tot_dc_night, SUM(time_cdb_night) AS tot_cdb_night, ";
	$query.= "SUM(multi_dc_day) AS multi_dc_day, SUM(multi_cdb_day) AS multi_cdb_day, SUM(multi_copi_day) AS multi_copi_day, SUM(multi_dc_night) AS multi_dc_night, SUM(multi_cdb_night) AS multi_cdb_night, SUM(multi_copi_night) AS multi_copi_night,";
	$query.= "SUM(instru_double) AS instru_double, SUM(instru_pilote) AS instru_pilote, ";
	$query.= "SUM(time_simu) AS tot_simu, ";
	$query.= "SUM(nb_ifr) AS tot_nbifr ";
	$query.= "FROM ".$MyOpt["tbl"]."_flight ";
	$query.= "WHERE uid='".$id."' AND dte_flight<'".$res["dte_flight"]."'";
	$res=$sql->QueryRow($query);

	$tabTotal=array();
	$usr = new user_class($id,$sql,true);

	$tabTotal["member_day"]=$usr->data["member_day"]+$res["member_day"];
	$tabTotal["member_night"]=$usr->data["member_night"]+$res["member_night"];

	$tabTotal["time_dc_day"]=$usr->data["time_dc_day"]+$res["tot_dc_day"];
	$tabTotal["time_cdb_day"]=$usr->data["time_cdb_day"]+$res["tot_cdb_day"];
	$tabTotal["time_dc_night"]=$usr->data["time_dc_night"]+$res["tot_dc_night"];
	$tabTotal["time_cdb_night"]=$usr->data["time_cdb_night"]+$res["tot_cdb_night"];

	$tabTotal["multi_dc_day"]=$usr->data["multi_dc_day"]+$res["multi_dc_day"];
	$tabTotal["multi_cdb_day"]=$usr->data["multi_cdb_day"]+$res["multi_cdb_day"];
	$tabTotal["multi_copi_day"]=$usr->data["multi_copi_day"]+$res["multi_copi_day"];
	$tabTotal["multi_dc_night"]=$usr->data["multi_dc_night"]+$res["multi_dc_night"];
	$tabTotal["multi_cdb_night"]=$usr->data["multi_cdb_night"]+$res["multi_cdb_night"];
	$tabTotal["multi_copi_night"]=$usr->data["multi_copi_night"]+$res["multi_copi_night"];

	$tabTotal["instru_double"]=$usr->data["instru_double"]+$res["instru_double"];
	$tabTotal["instru_pilote"]=$usr->data["instru_pilote"]+$res["instru_pilote"];

	$tabTotal["time_simu"]=$usr->data["time_simu"]+$res["tot_simu"];
	$tabTotal["nb_ifr"]=$usr->data["nb_ifr"]+$res["tot_nbifr"];

	$tmpl_x->assign("report_member_day",($tabTotal["member_day"]>0) ? AffTemps($tabTotal["member_day"],"no") : "&nbsp;");
	$tmpl_x->assign("report_member_night",($tabTotal["member_night"]>0) ? AffTemps($tabTotal["member_night"],"no") : "&nbsp;");

	$tmpl_x->assign("report_dc_day",($tabTotal["time_dc_day"]>0) ? AffTemps($tabTotal["time_dc_day"],"no") : "&nbsp;");
	$tmpl_x->assign("report_cdb_day",($tabTotal["time_cdb_day"]>0) ? AffTemps($tabTotal["time_cdb_day"],"no") : "&nbsp;");
	$tmpl_x->assign("report_dc_night",($tabTotal["time_dc_night"]>0) ? AffTemps($tabTotal["time_dc_night"],"no") : "&nbsp;");
	$tmpl_x->assign("report_cdb_night",($tabTotal["time_cdb_night"]>0) ? AffTemps($tabTotal["time_cdb_night"],"no") : "&nbsp;");

	$tmpl_x->assign("report_multi_dc_day",($tabTotal["multi_dc_day"]>0) ? AffTemps($tabTotal["multi_dc_day"],"no") : "&nbsp;");
	$tmpl_x->assign("report_multi_cdb_day",($tabTotal["multi_cdb_day"]>0) ? AffTemps($tabTotal["multi_cdb_day"],"no") : "&nbsp;");
	$tmpl_x->assign("report_multi_copi_day",($tabTotal["multi_copi_day"]>0) ? AffTemps($tabTotal["multi_copi_day"],"no") : "&nbsp;");
	$tmpl_x->assign("report_multi_dc_night",($tabTotal["multi_dc_night"]>0) ? AffTemps($tabTotal["multi_dc_night"],"no") : "&nbsp;");
	$tmpl_x->assign("report_multi_cdb_night",($tabTotal["multi_cdb_night"]>0) ? AffTemps($tabTotal["multi_cdb_night"],"no") : "&nbsp;");
	$tmpl_x->assign("report_multi_copi_night",($tabTotal["multi_copi_night"]>0) ? AffTemps($tabTotal["multi_copi_night"],"no") : "&nbsp;");

	$tmpl_x->assign("report_instru_double",($tabTotal["instru_double"]>0) ? AffTemps($tabTotal["instru_double"],"no") : "&nbsp;");
	$tmpl_x->assign("report_instru_pilote",($tabTotal["instru_pilote"]>0) ? AffTemps($tabTotal["instru_pilote"],"no") : "&nbsp;");

	$tmpl_x->assign("report_simu",($tabTotal["time_simu"]>0) ? AffTemps($tabTotal["time_simu"],"no") : "&nbsp;");
	$tmpl_x->assign("report_nb_ifr",($tabTotal["nb_ifr"]>0) ? $tabTotal["nb_ifr"] : "&nbsp;");
	
	$query = "SELECT * FROM ".$MyOpt["tbl"]."_flight AS flight ";
	// $query.="LEFT JOIN ".$MyOpt["tbl"]."_plane AS plane ON flight.callsign=plane.callsign ";
	$query.="WHERE flight.uid='".$id."' ";
	$query.="ORDER BY flight.dte_flight,flight.id LIMIT $p,14";
	$sql->Query($query);

	$tabLine=array();
	for($i=0; $i<$sql->rows; $i++)
	{ 
		$sql->GetRow($i);
		$tabLine[$i]=$sql->data;
	}
	
	foreach($tabLine as $i=>$l)
	{
		$tmpl_x->assign("aff_id",$l["id"]);
		$tmpl_x->assign("aff_date",sql2date($l["dte_flight"]));
		$tmpl_x->assign("aff_callsign",strtoupper($l["callsign"]));
		$tmpl_x->assign("aff_type",strtoupper($l["type"]));
		$tmpl_x->assign("aff_comment",($l["comment"]!="") ? $l["comment"] : "&nbsp;" );

		$tmpl_x->assign("aff_member_day",($l["member_day"]>0) ? AffTemps($l["member_day"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_member_night",($l["member_night"]>0) ? AffTemps($l["member_night"],"no") : "&nbsp;");

		$tmpl_x->assign("aff_time_dc_day",($l["time_dc_day"]>0) ? AffTemps($l["time_dc_day"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_time_cdb_day",($l["time_cdb_day"]>0) ? AffTemps($l["time_cdb_day"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_time_dc_night",($l["time_dc_night"]>0) ? AffTemps($l["time_dc_night"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_time_cdb_night",($l["time_cdb_night"]>0) ? AffTemps($l["time_cdb_night"],"no") : "&nbsp;");

		$tmpl_x->assign("aff_multi_dc_day",($l["multi_dc_day"]>0) ? AffTemps($l["multi_dc_day"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_multi_cdb_day",($l["multi_cdb_day"]>0) ? AffTemps($l["multi_cdb_day"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_multi_copi_day",($l["multi_copi_day"]>0) ? AffTemps($l["multi_copi_day"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_multi_dc_night",($l["multi_dc_night"]>0) ? AffTemps($l["multi_dc_night"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_multi_cdb_night",($l["multi_cdb_night"]>0) ? AffTemps($l["multi_cdb_night"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_multi_copi_night",($l["multi_copi_night"]>0) ? AffTemps($l["multi_copi_night"],"no") : "&nbsp;");

		$tmpl_x->assign("aff_instru_double",($l["instru_double"]>0) ? AffTemps($l["instru_double"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_instru_pilote",($l["instru_pilote"]>0) ? AffTemps($l["instru_pilote"],"no") : "&nbsp;");

		$tmpl_x->assign("aff_time_simu",($l["time_simu"]>0) ? AffTemps($l["time_simu"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_nb_ifr",($l["nb_ifr"]>0) ? $l["nb_ifr"] : "&nbsp;");

		$avion=new plane_class(0,$sql);
		$avion->LoadCallsign($l["callsign"],$gl_uid);
		$tmpl_x->assign("aff_planetype",$avion->val("type"));

		$tabTotal["member_day"]=$tabTotal["member_day"]+$l["member_day"];
		$tabTotal["member_night"]=$tabTotal["member_night"]+$l["member_night"];

		$tabTotal["time_dc_day"]=$tabTotal["time_dc_day"]+$l["time_dc_day"];
		$tabTotal["time_cdb_day"]=$tabTotal["time_cdb_day"]+$l["time_cdb_day"];
		$tabTotal["time_dc_night"]=$tabTotal["time_dc_night"]+$l["time_dc_night"];
		$tabTotal["time_cdb_night"]=$tabTotal["time_cdb_night"]+$l["time_cdb_night"];

		$tabTotal["multi_dc_day"]=$tabTotal["multi_dc_day"]+$l["multi_dc_day"];
		$tabTotal["multi_cdb_day"]=$tabTotal["multi_cdb_day"]+$l["multi_cdb_day"];
		$tabTotal["multi_copi_day"]=$tabTotal["multi_copi_day"]+$l["multi_copi_day"];
		$tabTotal["multi_dc_night"]=$tabTotal["multi_dc_night"]+$l["multi_dc_night"];
		$tabTotal["multi_cdb_night"]=$tabTotal["multi_cdb_night"]+$l["multi_cdb_night"];
		$tabTotal["multi_copi_night"]=$tabTotal["multi_copi_night"]+$l["multi_copi_night"];

		$tabTotal["instru_double"]=$tabTotal["instru_double"]+$l["instru_double"];
		$tabTotal["instru_pilote"]=$tabTotal["instru_pilote"]+$l["instru_pilote"];

		$tabTotal["time_simu"]=$tabTotal["time_simu"]+$l["time_simu"];
		$tabTotal["nb_ifr"]=$tabTotal["nb_ifr"]+$l["nb_ifr"];
		
		$tmpl_x->parse("corps.lst_line");
	}


	$tmpl_x->assign("reportend_member_day",($tabTotal["member_day"]>0) ? AffTemps($tabTotal["member_day"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_member_night",($tabTotal["member_night"]>0) ? AffTemps($tabTotal["member_night"],"no") : "&nbsp;");

	$tmpl_x->assign("reportend_dc_day",($tabTotal["time_dc_day"]>0) ? AffTemps($tabTotal["time_dc_day"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_cdb_day",($tabTotal["time_cdb_day"]>0) ? AffTemps($tabTotal["time_cdb_day"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_dc_night",($tabTotal["time_dc_night"]>0) ? AffTemps($tabTotal["time_dc_night"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_cdb_night",($tabTotal["time_cdb_night"]>0) ? AffTemps($tabTotal["time_cdb_night"],"no") : "&nbsp;");

	$tmpl_x->assign("reportend_multi_dc_day",($tabTotal["multi_dc_day"]>0) ? AffTemps($tabTotal["multi_dc_day"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_multi_cdb_day",($tabTotal["multi_cdb_day"]>0) ? AffTemps($tabTotal["multi_cdb_day"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_multi_copi_day",($tabTotal["multi_copi_day"]>0) ? AffTemps($tabTotal["multi_copi_day"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_multi_dc_night",($tabTotal["multi_dc_night"]>0) ? AffTemps($tabTotal["multi_dc_night"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_multi_cdb_night",($tabTotal["multi_cdb_night"]>0) ? AffTemps($tabTotal["multi_cdb_night"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_multi_copi_night",($tabTotal["multi_copi_night"]>0) ? AffTemps($tabTotal["multi_copi_night"],"no") : "&nbsp;");

	$tmpl_x->assign("reportend_instru_double",($tabTotal["instru_double"]>0) ? AffTemps($tabTotal["instru_double"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_instru_pilote",($tabTotal["instru_pilote"]>0) ? AffTemps($tabTotal["instru_pilote"],"no") : "&nbsp;");
	
	$tmpl_x->assign("reportend_simu",($tabTotal["time_simu"]>0) ? AffTemps($tabTotal["time_simu"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_nb_ifr",($tabTotal["nb_ifr"]>0) ? $tabTotal["nb_ifr"] : "&nbsp;");

	$tot=$tabTotal["time_dc_day"]+$tabTotal["time_cdb_day"]+$tabTotal["time_dc_night"]+$tabTotal["time_cdb_night"];
	$tot=$tot+$tabTotal["multi_dc_day"]+$tabTotal["multi_cdb_day"]+$tabTotal["multi_copi_day"]+$tabTotal["multi_dc_night"]+$tabTotal["multi_cdb_night"]+$tabTotal["multi_copi_night"];
	$tot=$tot+$tabTotal["time_simu"];

	$tmpl_x->assign("reportend_total",AffTemps($tot,"no"));
	
// ---- Affecte les variables d'affichage
	$tmpl_x->parse("icone");
	$icone=$tmpl_x->text("icone");
	$tmpl_x->parse("infos");
	$infos=$tmpl_x->text("infos");
	$tmpl_x->parse("corps");
	$corps=$tmpl_x->text("corps");



?>
