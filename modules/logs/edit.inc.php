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
	$tmpl_x = new XTemplate (MyRep("edit.htm"));
	$tmpl_x->assign("path_module","$module/$mod");

	require($appfolder."/class/vol.inc.php");

// ---- Get my id	
	$id=$gl_uid;

// ---- Affiche les variables
	$prev=checkVar("prev","varchar");
	$lid=checkVar("lid","numeric");

// ---- Save data
	if ($fonc=="Enregistrer")
	{
		$form_data=checkVar("form_data","array");
		
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
		header('Location: /logs/'.$prev, true, 303);
		exit;
	}

// ---- Load data
	$fl=new flight_class($lid,$sql);
	$fl->Render("form","form");


// ---- Affecte les variables d'affichage
	$tmpl_x->assign("form_prev",$prev);

	$tmpl_x->parse("icone");
	$icone=$tmpl_x->text("icone");
	$tmpl_x->parse("infos");
	$infos=$tmpl_x->text("infos");
	$tmpl_x->parse("corps");
	$corps=$tmpl_x->text("corps");



?>
