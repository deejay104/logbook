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
	require_once($appfolder."/class/avion.inc.php");
	if (!GetDroit("AccesAvions")) { FatalError("Accès non autorisé (AccesAvions)"); }

// ---- Vérifie les variables
	$order=checkVar("order","varchar");
	$trie=checkVar("trie","varchar");

// ---- Charge template
	$tmpl_x = new XTemplate (MyRep("index.htm"));
	$tmpl_x->assign("path_module",$module."/".$mod);


// ---- Liste des avions
	$lst=ListeAvions($sql);

	$tabTitre=array();
	$tabTitre["callsign"]["aff"]="Immat";
	$tabTitre["callsign"]["width"]=100;
	$tabTitre["type"]["aff"]="Type";
	$tabTitre["type"]["width"]=100;
	$tabTitre["hdv"]["aff"]="HdV";
	$tabTitre["hdv"]["width"]=100;

	$tabValeur=array();
	foreach($lst as $i=>$d)
	{
		$pb = new plane_class($i,$sql);

		$tabValeur[$i]["callsign"]["val"]=$pb->val("callsign");
		$tabValeur[$i]["callsign"]["aff"]=$pb->aff("callsign");
		$tabValeur[$i]["type"]["val"]=$pb->val("type");
		$tabValeur[$i]["type"]["aff"]=$pb->aff("type");
		$tabValeur[$i]["hdv"]["val"]=$pb->TotalHeures();
		$tabValeur[$i]["hdv"]["aff"]=$pb->TotalHeures();
	}

	if ((!isset($order)) || ($order=="")) { $order="callsign"; }
	if ((!isset($trie)) || ($trie=="")) { $trie="d"; }

	$tmpl_x->assign("aff_tableau",AfficheTableau($tabValeur,$tabTitre,$order,$trie));

	
// ---- Affecte les variables d'affichage
	$tmpl_x->parse("icone");
	$icone=$tmpl_x->text("icone");
	$tmpl_x->parse("infos");
	$infos=$tmpl_x->text("infos");
	$tmpl_x->parse("corps");
	$corps=$tmpl_x->text("corps");
?>
