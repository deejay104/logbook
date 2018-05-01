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
	$tmpl_x = new XTemplate (MyRep("edit.htm"));
	$tmpl_x->assign("path_module","$module/$mod");


// ---- Get my id	
	$id=$myuser->uid;


	$tmpl_x->assign("form_checktime",$_SESSION['checkpost']);

// ---- Load data
	if (!is_numeric($_REQUEST["lid"]))
	{
		$lid=0;
	}
	else
	{
		$lid=$_REQUEST["lid"];
	}

	if ($lid>0)
	{
		$query = "SELECT * FROM ".$MyOpt["tbl"]."_flight WHERE id=$lid";
		$res=$sql->QueryRow($query);
	}

	$tmpl_x->assign("form_lid",$lid);
	$tmpl_x->assign("form_dte_flight",$res["dte_flight"]);
	$tmpl_x->assign("form_callsign",$res["callsign"]);
	$tmpl_x->assign("form_comment",$res["comment"]);
	$tmpl_x->assign("form_time_dc_day",$res["time_dc_day"]);
	$tmpl_x->assign("form_time_cdb_day",$res["time_cdb_day"]);
	$tmpl_x->assign("form_time_dc_night",$res["time_dc_night"]);
	$tmpl_x->assign("form_time_cdb_night",$res["time_cdb_night"]);
	$tmpl_x->assign("form_time_simu",$res["time_simu"]);
	$tmpl_x->assign("form_nb_ifr",$res["nb_ifr"]);
	$tmpl_x->assign("form_nb_att",$res["nb_att"]);
	$tmpl_x->assign("form_nb_amerr",$res["nb_amerr"]);
	

// ---- Affecte les variables d'affichage
	$tmpl_x->parse("icone");
	$icone=$tmpl_x->text("icone");
	$tmpl_x->parse("infos");
	$infos=$tmpl_x->text("infos");
	$tmpl_x->parse("corps");
	$corps=$tmpl_x->text("corps");



?>
