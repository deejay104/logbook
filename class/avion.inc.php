<?
// Classe Avion

class plane_class extends objet_core
{
	protected $table="plane";
	protected $mod="avions";
	protected $rub="detail";

	protected $type=array(
		"callsign"=>"uppercase",
		"type"=>"varchar",
		"comment"=>"text",
	);

	protected $tabList=array(
		"type"=>array('P'=>'Pilote','EP'=>'Elève'),
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
		$this->load($res["id"]);
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
			SUM(nb_ifr) AS nb_ifr,
			SUM(nb_att) AS nb_att,
			SUM(nb_amerr) AS nb_amerr
			FROM ".$MyOpt["tbl"]."_flight
			WHERE uid='".$gl_uid."' AND callsign='".$this->data["callsign"]."'";
		$res=$sql->QueryRow($q);
		
		return AffTemps($res["dc_day"]+$res["cdb_day"]+$res["dc_night"]+$res["cdb_night"]+$res["simu"],"no");
	}
}


function ListeAvions($sql)
{
	global $gl_uid;
	return ListeObjets($sql,"plane",array("id"),array("uid"=>$gl_uid));
}
?>