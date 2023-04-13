<?
// Classe Avion

class plane_class extends objet_core
{
	protected $table="plane";
	protected $mod="avions";
	protected $rub="detail";

	// protected $type=array(
		// "callsign"=>"uppercase",
		// "type"=>"varchar",
		// "comment"=>"text",
	// );

		// "id" => Array("Type" => "int(10) unsigned", "Index" => "PRIMARY", ),
		// "uid" => Array("Type" => "int(10) unsigned", "Index"=>"1"),
		// "callsign" => Array("Type" => "varchar(8)", "Index"=>"1"),
		// "type" => Array("Type" => "varchar(10)"),
		// "comment" => Array("Type" => "varchar(50)"),


	protected $fields=array
	(
		"uid" => Array("type" => "number", "index"=>"1"),
		"callsign"=>Array("type"=>"uppercase", "len"=>8, "index"=>1),
		"type"=>Array("type"=>"varchar", "len"=>15),
		"comment"=>Array("type"=>"text"),
		"train"=>Array("type"=>"enum","default"=>"T"),
	);

	protected $tabList=array(
		"train"=>array('C'=>'Classique','T'=>'Tricycle'),
	);
	
	# Constructor
	function __construct($id=0,$sql,$me=false,$setdata=true)
	{
		global $gl_uid;
		$this->data["uid"]=$gl_uid;
		$this->data["callsign"]="";
		$this->data["type"]="";
		$this->data["comment"]="";
	
		parent::__construct($id,$sql);

	}
	
	function LoadCallsign($c,$uid)
	{
		$sql=$this->sql;
		$q="SELECT id FROM ".$this->tbl."_plane WHERE callsign='".$c."' AND uid='".$uid."'";
		$res=$sql->QueryRow($q);
		if (isset($res["id"]))
		{
			$this->load($res["id"]);
		}
	}
	
	function TotalHeures()
	{ global $gl_uid,$MyOpt;
		$sql=$this->sql;

		$q="SELECT
			SUM(time_dc_day) AS dc_day,
			SUM(time_cdb_day) AS cdb_day,
			SUM(time_dc_night) AS dc_night,
			SUM(time_cdb_night) AS cdb_night,
			SUM(time_simu) AS simu,
			SUM(multi_dc_day) AS multi_dc_day,
			SUM(multi_cdb_day) AS multi_cdb_day,
			SUM(multi_copi_day) AS multi_copi_day,
			SUM(multi_dc_night) AS multi_dc_night,
			SUM(multi_cdb_night) AS multi_cdb_night,
			SUM(multi_copi_night) AS multi_copi_night,
			SUM(nb_ifr) AS nb_ifr,
			SUM(nb_att) AS nb_att,
			SUM(nb_amerr) AS nb_amerr
			FROM ".$MyOpt["tbl"]."_flight
			WHERE uid='".$gl_uid."' AND callsign='".$this->data["callsign"]."'";
		$res=$sql->QueryRow($q);
		
		return AffTemps($res["dc_day"]+$res["cdb_day"]+$res["dc_night"]+$res["cdb_night"]+$res["simu"]+$res["multi_dc_day"]+$res["multi_cdb_day"]+$res["multi_copi_day"]+$res["multi_dc_night"]+$res["multi_cdb_night"]+$res["multi_copi_night"],"no");
	}

	function TotalAtt()
	{ global $gl_uid,$MyOpt;
		$sql=$this->sql;

		$q="SELECT
			SUM(nb_att) AS nb_att,
			SUM(nb_amerr) AS nb_amerr
			FROM ".$MyOpt["tbl"]."_flight
			WHERE uid='".$gl_uid."' AND callsign='".$this->data["callsign"]."'";
		$res=$sql->QueryRow($q);
		
		return $res["nb_att"];
	}
}


function ListeAvions($sql)
{
	global $gl_uid;
	return ListeObjets($sql,"plane",array("id"),array("uid"=>$gl_uid));
}
?>