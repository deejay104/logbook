<?
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

<?
// ---- Load template
	$tmpl_x = new XTemplate (MyRep("index.htm"));
	$tmpl_x->assign("path_module","$module/$mod");
	$tmpl_x->assign("form_checktime",$_SESSION['checkpost']);

	require_once($appfolder."/class/user.inc.php");
	require_once($appfolder."/class/vol.inc.php");

// ---- Affiche le menu
	$aff_menu="";
	require_once($appfolder."/modules/".$mod."/menu.inc.php");
	$tmpl_x->assign("aff_menu",$aff_menu);

// ---- Get my id	
	$id=$myuser->id;

// ---- Save Flight
	if (($_REQUEST["fonc"]=="Enregistrer") && (!isset($_SESSION['tab_checkpost'][$_REQUEST["checktime"]])))
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

	
// ---- Show pages
	$query = "SELECT COUNT(*) AS nb FROM ".$MyOpt["tbl"]."_flight WHERE uid=$id";
	$res=$sql->QueryRow($query);
	$nbtot=$res["nb"];

	if (!isset($p))
	{
		$p=-1;
	}
	
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

	$query = "SELECT SUM(time_dc_day) AS tot_dc_day, SUM(time_cdb_day) AS tot_cdb_day, SUM(time_dc_night) AS tot_dc_night, SUM(time_cdb_night) AS tot_cdb_night, SUM(time_simu) AS tot_simu FROM ".$MyOpt["tbl"]."_flight WHERE uid=$id AND dte_flight<'".$res["dte_flight"]."'";
	$res=$sql->QueryRow($query);

	$tabTotal=array();
	$usr = new user_class($id,$sql,true);
	$tabTotal["time_dc_day"]=$usr->data["time_dc_day"]+$res["tot_dc_day"];
	$tabTotal["time_cdb_day"]=$usr->data["time_cdb_day"]+$res["tot_cdb_day"];
	$tabTotal["time_dc_night"]=$usr->data["time_dc_night"]+$res["tot_dc_night"];
	$tabTotal["time_cdb_night"]=$usr->data["time_cdb_night"]+$res["tot_cdb_night"];
	$tabTotal["time_simu"]=$usr->data["time_simu"]+$res["tot_simu"];

	$tmpl_x->assign("report_dc_day",($tabTotal["time_dc_day"]>0) ? AffTemps($tabTotal["time_dc_day"],"no") : "&nbsp;");
	$tmpl_x->assign("report_cdb_day",($tabTotal["time_cdb_day"]>0) ? AffTemps($tabTotal["time_cdb_day"],"no") : "&nbsp;");
	$tmpl_x->assign("report_dc_night",($tabTotal["time_dc_night"]>0) ? AffTemps($tabTotal["time_dc_night"],"no") : "&nbsp;");
	$tmpl_x->assign("report_cdb_night",($tabTotal["time_cdb_night"]>0) ? AffTemps($tabTotal["time_cdb_night"],"no") : "&nbsp;");
	$tmpl_x->assign("report_simu",($tabTotal["time_simu"]>0) ? AffTemps($tabTotal["time_simu"],"no") : "&nbsp;");
	
	$query = "SELECT * FROM ".$MyOpt["tbl"]."_flight WHERE uid=$id ORDER BY dte_flight,id LIMIT $p,14";
	$sql->Query($query);

	for($i=0; $i<$sql->rows; $i++)
	{ 
		$sql->GetRow($i);
		$tmpl_x->assign("aff_id",$sql->data["id"]);
		$tmpl_x->assign("aff_date",sql2date($sql->data["dte_flight"]));
		$tmpl_x->assign("aff_callsign",strtoupper($sql->data["callsign"]));
		$tmpl_x->assign("aff_type",strtoupper($sql->data["type"]));
		$tmpl_x->assign("aff_comment",($sql->data["comment"]!="") ? $sql->data["comment"] : "&nbsp;" );
		$tmpl_x->assign("aff_time_dc_day",($sql->data["time_dc_day"]>0) ? AffTemps($sql->data["time_dc_day"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_time_cdb_day",($sql->data["time_cdb_day"]>0) ? AffTemps($sql->data["time_cdb_day"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_time_dc_night",($sql->data["time_dc_night"]>0) ? AffTemps($sql->data["time_dc_night"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_time_cdb_night",($sql->data["time_cdb_night"]>0) ? AffTemps($sql->data["time_cdb_night"],"no") : "&nbsp;");
		$tmpl_x->assign("aff_time_simu",($sql->data["time_simu"]>0) ? AffTemps($sql->data["time_simu"],"no") : "&nbsp;");

		$tabTotal["time_dc_day"]=$tabTotal["time_dc_day"]+$sql->data["time_dc_day"];
		$tabTotal["time_cdb_day"]=$tabTotal["time_cdb_day"]+$sql->data["time_cdb_day"];
		$tabTotal["time_dc_night"]=$tabTotal["time_dc_night"]+$sql->data["time_dc_night"];
		$tabTotal["time_cdb_night"]=$tabTotal["time_cdb_night"]+$sql->data["time_cdb_night"];
		$tabTotal["time_simu"]=$tabTotal["time_simu"]+$sql->data["time_simu"];
		
		$tmpl_x->parse("corps.lst_line");
	}


	$tmpl_x->assign("reportend_dc_day",($tabTotal["time_dc_day"]>0) ? AffTemps($tabTotal["time_dc_day"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_cdb_day",($tabTotal["time_cdb_day"]>0) ? AffTemps($tabTotal["time_cdb_day"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_dc_night",($tabTotal["time_dc_night"]>0) ? AffTemps($tabTotal["time_dc_night"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_cdb_night",($tabTotal["time_cdb_night"]>0) ? AffTemps($tabTotal["time_cdb_night"],"no") : "&nbsp;");
	$tmpl_x->assign("reportend_simu",($tabTotal["time_simu"]>0) ? AffTemps($tabTotal["time_simu"],"no") : "&nbsp;");

	$tot=$tabTotal["time_dc_day"]+$tabTotal["time_cdb_day"]+$tabTotal["time_dc_night"]+$tabTotal["time_cdb_night"]+$tabTotal["time_simu"];
	$tmpl_x->assign("reportend_total",AffTemps($tot,"no"));
	
// ---- Affecte les variables d'affichage
	$tmpl_x->parse("icone");
	$icone=$tmpl_x->text("icone");
	$tmpl_x->parse("infos");
	$infos=$tmpl_x->text("infos");
	$tmpl_x->parse("corps");
	$corps=$tmpl_x->text("corps");



?>
