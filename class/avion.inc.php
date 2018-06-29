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
}


function ListeAvions($sql)
{
	global $gl_uid;
	return ListeObjets($sql,"plane",array("id"),array("uid"=>$gl_uid));
}
?>