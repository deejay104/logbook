<?
	$tmpl_custom = new XTemplate (MyRep("custom.htm"));
	$tmpl_x->assign("path_module",$corefolder."/".$module."/".$mod);

// ---- Charge l'utilisateur
	require_once ($appfolder."/class/user.inc.php");
	$usrcus = new user_class($id,$sql,true);

// ---- Sauvegarde
	if (($fonc=="Enregistrer") && ((GetMyId($id)) || (GetDroit("ModifUserSauve"))))
	{
		// Sauvegarde les données
		if (count($form_data)>0)
		{
			foreach($form_data as $k=>$v)
		  	{
		  		$msg_erreur.=$usrcus->Valid($k,$v);
		  	}
		}
		$usrcus->Save();
		
	}
	
// ---- Données Utilisateurs	
	foreach($usrcus->data as $k=>$v)
	  { $tmpl_custom->assign("form_$k", $usrcus->aff($k,$typeaff)); }


// ---- Affiche la page
	$tmpl_custom->parse("left");
	$left=$tmpl_custom->text("left");

	$tmpl_custom->parse("right");
	$right=$tmpl_custom->text("right");

?>