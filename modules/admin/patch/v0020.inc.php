<?php
	// Save data
	$q="UPDATE ".$MyOpt["tbl"]."_flight SET description=comment WHERE description='' OR description IS NULL";
	$sql->Update($q);

	// Find airports
	$q="SELECT id,field_from,field_to,comment FROM ".$MyOpt["tbl"]."_flight";
	$sql->Query($q);

	$tab=array();
	for($i=0; $i<$sql->rows; $i++)
	{ 
		$sql->GetRow($i);

		if (($sql->data["field_from"]=="") && ($sql->data["field_to"]==""))
    	{
            $tab[$sql->data["id"]]=$sql->data["comment"];
    	}
	}
	
	foreach($tab as $i=>$t)
	{
        if (preg_match("/^.*\b([A-Z]{4})\s*-?\s*([A-Z]{4})[\s_]+(.*)$/",$t,$m))
        {
            $ret["data"].= "  => 1 ".$m[1]."**".$m[2].": ".$m[3]."\n";
            $q="UPDATE ".$MyOpt["tbl"]."_flight SET field_from='".strtoupper(substr($m[1],0,4))."', field_to='".strtoupper(substr($m[2],0,4))."', comment='".addslashes($m[3])."' WHERE id='".$i."'";
            $sql->Update($q);
        }
        else if (preg_match("/^.*\b([A-Za-z]{4})\s*-\s*([A-Za-z]{4})[\s_]+(.*)$/",$t,$m))
        {
            $ret["data"].= "  => 2 ".$m[1]."**".$m[2].": ".$m[3]."\n";
            $q="UPDATE ".$MyOpt["tbl"]."_flight SET field_from='".strtoupper(substr($m[1],0,4))."', field_to='".strtoupper(substr($m[2],0,4))."', comment='".addslashes($m[3])."' WHERE id='".$i."'";
            $sql->Update($q);
        }
        else if (preg_match("/^([A-Za-z]{4})\s*-\s*([A-Za-z]{4})$/",$t,$m))
        {
            $ret["data"].= "  => 3 ".$m[1]."**".$m[2]."\n";
            $q="UPDATE ".$MyOpt["tbl"]."_flight SET field_from='".strtoupper(substr($m[1],0,4))."', field_to='".strtoupper(substr($m[2],0,4))."', comment='' WHERE id='".$i."'";
            $sql->Update($q);
        }
		else if (preg_match("/(?:^|[\s-])([A-Z]{4})(?=$|[\s-]|$)/",$t,$m))
		{
			//echo print_r($m,true);
			$c=preg_replace("/".$m[1]."[\s_]*/","",$t);
			$c=preg_replace("/[\s_]*-/","",$c);

			$ret["data"].= "  => 4 ".$m[1]."**".$m[1].": ".$c."\n";
			$q="UPDATE ".$MyOpt["tbl"]."_flight SET field_from='".strtoupper(substr($m[1],0,4))."', field_to='".strtoupper(substr($m[1],0,4))."', comment='".addslashes($c)."' WHERE id='".$i."'";
			$sql->Update($q);
		}
	}

?>