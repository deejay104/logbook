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
}


function ListeAvions($sql)
{
	global $gl_uid;
	return ListeObjets($sql,"plane",array("id"),array("uid"=>$gl_uid));
}
?>