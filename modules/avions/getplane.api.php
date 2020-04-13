<?php
// ---- Refuse l'accès en direct
	if ((!isset($token)) || ($token==""))
	  { header("HTTP/1.0 401 Unauthorized"); exit; }

// ---- 
	$result=array();

	$query="SELECT callsign FROM ".$MyOpt["tbl"]."_plane WHERE callsign LIKE '%".$_REQUEST["term"]."%' AND uid='".$gl_uid."' LIMIT 0,10";
	$sql->Query($query);
	for($i=0; $i<$sql->rows; $i++)
	{
		$sql->GetRow($i);
		$r=array();
		$r["value"]=strtoupper($sql->data["callsign"]);
		$r["label"]=strtoupper($sql->data["callsign"]);
		
		array_push($result,$r);
	}
	
	echo json_encode($result);
?>