<?php
	$q="SELECT uid,callsign FROM ".$MyOpt["tbl"]."_flight GROUP BY uid,callsign";
	$sql->Query($q);

	$tabAvions=array();
	for($i=0; $i<$sql->rows; $i++)
	{ 
		$sql->GetRow($i);

		$tabAvions[$sql->data["uid"]][$sql->data["callsign"]]=1;
	}
	
	foreach($tabAvions as $uid=>$t)
	{
		foreach($t as $c=>$d)
		{
			$q="SELECT id FROM ".$MyOpt["tbl"]."_plane WHERE callsign='".$c."'";
			$res=$sql->QueryRow($q);
		
			if ($res["id"]>0)
			{
			}
			else if ($c!="XXX")
			{
				$q="INSERT ".$MyOpt["tbl"]."_plane SET callsign='".strtolower($c)."', uid='".$uid."'";
				$sql->Insert($q);
			}
		}
	}

?>