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
	$tmpl_x = new XTemplate (MyRep("mois.htm"));
	$tmpl_x->assign("path_module","$module/$mod");

	require_once($appfolder."/class/user.inc.php");

// ---- Affiche le menu
	$aff_menu="";
	require_once($appfolder."/modules/".$mod."/menu.inc.php");
	$tmpl_x->assign("aff_menu",$aff_menu);
	
// ---- Get my id	
	$id=$myuser->id;
	$dte_deb=checkVar("dte_deb","date");
	$dte_fin=checkVar("dte_fin","date");

// ---- Initialize variables
if ($gl_uid==1)
{
$id=5;
}

// ---- Totaux

	if ($dte_deb!="0000-00-00")
	{
		$ddeb=date2sql($dte_deb);
	}
	else
	{
		$ddeb=(date("Y")-1)."-".date("m-d");
		$dte_deb=$ddeb;
	}
	$tmpl_x->assign("dte_deb",$dte_deb);
	if ($dte_fin!="0000-00-00")
	{
		$dfin=date2sql($dte_fin);
	}
	else
	{
		$dfin=date("Y-m-d");
		$dte_fin=$dfin;
	}
	$tmpl_x->assign("dte_fin",$dte_fin);

	$q="SELECT
		SUM(time_dc_day) AS dc_day,
		SUM(time_cdb_day) AS cdb_day,
		SUM(time_dc_night) AS dc_night,
		SUM(time_cdb_night) AS cdb_night,
		SUM(time_simu) AS simu,
		SUM(nb_ifr) AS nb_ifr,
		SUM(nb_att) AS nb_att,
		SUM(nb_amerr) AS nb_amerr
		FROM ".$MyOpt["tbl"]."_flight
		WHERE uid=".$id." AND dte_flight>='".$ddeb."' AND dte_flight<='".$dfin."'";
	$res=$sql->QueryRow($q);
		
// ---- Flight List

	$tabTitre=array();
	$tabTitre["dte"]["aff"]="Date";
	$tabTitre["dte"]["bottom"]="Total";
	$tabTitre["dte"]["width"]=80;
	// $tabTitre["line1"]["aff"]="<line>";
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
	// $tabTitre["line2"]["aff"]="<line>";
	$tabTitre["total"]["aff"]="Total";
	$tabTitre["total"]["bottom"]=AffTemps($res["dc_day"]+$res["cdb_day"]+$res["dc_night"]+$res["cdb_night"]+$res["simu"],"no");
	$tabTitre["total"]["width"]=80;
	// $tabTitre["line3"]["aff"]="<line>";
	$tabTitre["nb_att"]["aff"]="Atterrissage";
	$tabTitre["nb_att"]["bottom"]=$res["nb_att"];
	$tabTitre["nb_att"]["width"]=80;

	$q="SELECT DATE_FORMAT(dte_flight,'%Y-%m') AS dte,
		SUM(time_dc_day) AS dc_day,
		SUM(time_cdb_day) AS cdb_day,
		SUM(time_dc_night) AS dc_night,
		SUM(time_cdb_night) AS cdb_night,
		SUM(time_simu) AS simu,
		SUM(nb_ifr) AS nb_ifr,
		SUM(nb_att) AS nb_att,
		SUM(nb_amerr) AS nb_amerr
		FROM ".$MyOpt["tbl"]."_flight
		WHERE uid=".$id." AND dte_flight>='".$ddeb."' AND dte_flight<='".$dfin."' GROUP BY DATE_FORMAT(dte_flight,'%Y-%m')";
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
		$tabValeur[$i]["line2"]["val"]="<line>";
		$tabValeur[$i]["total"]["val"]=$sql->data["dc_day"]+$sql->data["cdb_day"]+$sql->data["dc_night"]+$sql->data["cdb_night"]+$sql->data["simu"];
		$tabValeur[$i]["total"]["aff"]=AffTemps($sql->data["dc_day"]+$sql->data["cdb_day"]+$sql->data["dc_night"]+$sql->data["cdb_night"]+$sql->data["simu"],"no");
		$tabValeur[$i]["total"]["align"]="center";
		$tabValeur[$i]["line3"]["val"]="<line>";
		$tabValeur[$i]["nb_att"]["val"]=$sql->data["nb_att"];
		$tabValeur[$i]["nb_att"]["aff"]=$sql->data["nb_att"];
		$tabValeur[$i]["nb_att"]["align"]="center";
	}

	if ((!isset($order)) || ($order=="")) { $order="nom"; }
	if ((!isset($trie)) || ($trie=="")) { $trie="d"; }

	$tmpl_x->assign("aff_tableau",AfficheTableau($tabValeur,$tabTitre,$order,$trie));

	$tmpl_x->assign("tot_12mois",AffTemps($res["dc_day"]+$res["cdb_day"]+$res["dc_night"]+$res["cdb_night"]+$res["simu"],"no"));
	$tmpl_x->assign("tot_cdb",AffTemps($res["cdb_day"]+$res["cdb_night"],"no"));
	$tmpl_x->assign("date_deb",sql2date($ddeb));
	$tmpl_x->assign("date_fin",sql2date($dfin));
	$tmpl_x->assign("tot_att",$res["nb_att"]);
	$tmpl_x->assign("dte_today",date("d/m/Y"));
	
	$query ="SELECT SUM(time_dc_day) AS tot_dc_day, SUM(time_cdb_day) AS tot_cdb_day, SUM(time_dc_night) AS tot_dc_night, SUM(time_cdb_night) AS tot_cdb_night, SUM(time_simu) AS tot_simu ";
	$query.="FROM ".$MyOpt["tbl"]."_flight ";
	$query.="WHERE uid='".$id."'";
	$res=$sql->QueryRow($query);

	$tabTotal=array();
	$usr = new user_class($id,$sql,true);
	$tabTotal["time_dc_day"]=$usr->data["time_dc_day"]+$res["tot_dc_day"];
	$tabTotal["time_cdb_day"]=$usr->data["time_cdb_day"]+$res["tot_cdb_day"];
	$tabTotal["time_dc_night"]=$usr->data["time_dc_night"]+$res["tot_dc_night"];
	$tabTotal["time_cdb_night"]=$usr->data["time_cdb_night"]+$res["tot_cdb_night"];
	$tabTotal["time_simu"]=$usr->data["time_simu"]+$res["tot_simu"];

	$tmpl_x->assign("tot_heures",AffTemps($tabTotal["time_dc_day"]+$tabTotal["time_cdb_day"]+$tabTotal["time_dc_night"]+$tabTotal["time_cdb_night"]+$tabTotal["time_simu"],"no"));

	
	
// ---- Affecte les variables d'affichage
	$tmpl_x->parse("icone");
	$icone=$tmpl_x->text("icone");
	$tmpl_x->parse("infos");
	$infos=$tmpl_x->text("infos");
	$tmpl_x->parse("corps");
	$corps=$tmpl_x->text("corps");



?>
