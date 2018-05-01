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

	if (!isset($_GET["val"]))
	{
		$res["result"]=utf8_encode("NOK");
		$res["error"]=utf8_encode("val not provided");
		echo json_encode($res);
	  	exit;
	}
	$val=$_GET["val"];

	$res["result"]=utf8_encode("NOK");
	$res["var"]=$var;
	$res["val"]=$val;
	$res["id"]=$id;

	if ( ($var=="time_dc_day") || ($var=="time_cdb_day") || ($var=="time_dc_night") || ($var=="time_cdb_night") || ($var=="time_simu") )
	{
		if (trim($val)=="")
		{
			$val=0;
		}
		$val=preg_replace("/[ ]+/","+",substr($val,0,10));
		$val=preg_replace("/[^0-9]*j/","*1440",$val);
		$val=preg_replace("/[^0-9]*h/","*60",$val);
		$val=preg_replace("/[^0-9]*:/","*60",$val);
		$val=preg_replace("/[^0-9]*m/","",$val);
		eval("\$sched=".$val.";");
		
		$q="UPDATE ".$MyOpt["tbl"]."_flight SET ".$var."='".$sched."' WHERE id='".$id."'";
		$sql->Update($q);
		$res["result"]=utf8_encode("OK");
		$res["value"]=utf8_encode(AffTemps($sched,"no"));
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