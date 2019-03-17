<?
// ---- Refuse l'accès en direct
	if ((!isset($token)) || ($token==""))
	  { header("HTTP/1.0 401 Unauthorized"); exit; }

// ---- Vérifie les paramètres
	if (!isset($_GET["id"]))
	{
		$res["result"]=utf8_encode("NOK");
		$res["error"]="id not provided.";
		echo json_encode($res);
	  	exit;
	}
	$id=$_GET["id"];

	if (!isset($_GET["var"]))
	{
		$res["result"]=utf8_encode("NOK");
		$res["error"]="var not provided.";
		echo json_encode($res);
	  	exit;
	}
	$var=$_GET["var"];

	$val=checkVar("val","varchar");

	$res["result"]=utf8_encode("NOK");
	$res["var"]=$var;
	$res["val"]=$val;
	$res["id"]=$id;

	if ( ($var=="time_dc_day") || ($var=="time_cdb_day") || ($var=="time_dc_night") || ($var=="time_cdb_night") 
			|| ($var=="multi_dc_day") || ($var=="multi_cdb_day") || ($var=="multi_copi_day") || ($var=="multi_dc_night") || ($var=="multi_cdb_night") || ($var=="multi_copi_night")
			|| ($var=="member_day") || ($var=="member_night")
			|| ($var=="instru_double") || ($var=="instru_pilote")
			|| ($var=="time_simu")
		)
	{
		if ( (trim(utf8_decode($val))=="") || (utf8_decode($val)=="?"))
		{
			$val=0;
		}
		$tps=CalcTemps($val);

		$q="UPDATE ".$MyOpt["tbl"]."_flight SET ".$var."='".$tps."' WHERE id='".$id."'";
		$sql->Update($q);
		
		$res["result"]=utf8_encode("OK");
		$res["value"]=utf8_encode(AffTemps($tps,"no"));
	}
	else if ($var=="nb_ifr")
	{
		$val=substr(trim($val),0,4);
		$q="UPDATE ".$MyOpt["tbl"]."_flight SET nb_ifr='".$val."' WHERE id='".$id."'";
		$sql->Update($q);
		$res["result"]=utf8_encode("OK");
		$res["value"]=utf8_encode(addslashes($val));
	}
	else if ($var=="comment")
	{
		$val=substr(trim($val),0,50);
		$q="UPDATE ".$MyOpt["tbl"]."_flight SET comment='".$val."' WHERE id='".$id."'";
		$sql->Update($q);
		$res["result"]=utf8_encode("OK");
		$res["value"]=utf8_encode(addslashes($val));
	}
	
	echo json_encode($res);

?>