<?
// Classe Vol
require_once($appfolder."/class/avion.inc.php");

class flight_class extends objet_core
{
	protected $table="flight";
	protected $mod="logs";
	protected $rub="edit";

	// protected $fields=array(
		// "dte_flight"=>"date",
		// "callsign"=>"uppercase",
		// "type"=>"enum",
		// "comment"=>"varchar",
		// "member_day" => "duration",
		// "member_night" => "duration",
		// "time_dc_day"=>"duration",
		// "time_cdb_day"=>"duration",
		// "time_dc_night"=>"duration",
		// "time_cdb_night"=>"duration",
		// "multi_dc_day" => "duration",
		// "multi_cdb_day" => "duration",
		// "multi_copi_day" => "duration",
		// "multi_dc_night" => "duration",
		// "multi_cdb_night" => "duration",
		// "multi_copi_night" => "duration",
		// "instru_double" => "duration",
		// "instru_pilote" => "duration",
		// "time_simu"=>"duration",
		// "nb_ifr"=>"number",
		// "nb_att"=>"number",
		// "nb_amerr"=>"number",
	// );
	protected $fields = array
	(
		"uid" => Array("type" => "number", "index"=>"1"),
		"dte_flight" => Array("type" => "date", "default" => "0000-00-00"),
		"callsign" => Array("type" => "varchar","len"=>8, "index"=>"1"),
		"type" => Array("type" => "varchar","len"=>4),
		"comment" => Array("type" => "varchar","len"=>50),
		"member_day" => Array("type" => "number"),
		"member_night" => Array("type" => "number"),
		"time_dc_day" => Array("type" => "duration"),
		"time_cdb_day" => Array("type" => "duration"),
		"time_dc_night" => Array("type" => "duration"),
		"time_cdb_night" => Array("type" => "duration"),
		"multi_dc_day" => Array("type" => "duration"),
		"multi_cdb_day" => Array("type" => "duration"),
		"multi_copi_day" => Array("type" => "duration"),
		"multi_dc_night" => Array("type" => "duration"),
		"multi_cdb_night" => Array("type" => "duration"),
		"multi_copi_night" => Array("type" => "duration"),
		"instru_double" => Array("type" => "duration"),
		"instru_pilote" => Array("type" => "duration"),
		"time_simu" => Array("type" => "duration"),
		"nb_ifr" => Array("type" => "number"),
		"nb_att" => Array("type" => "number","defautl"=>1),
		"nb_amerr" => Array("type" => "number"),
	);

	protected $tabList=array(
		"type"=>array('P'=>'Pilote','EP'=>'El�ve'),
	);
	
	# Constructor
	function __construct($id=0,$sql)
	{
		global $gl_uid;
	
		parent::__construct($id,$sql);

		$this->data["uid"]=$gl_uid;
		$this->data["dte_flight"]=date("Y-m-d");
		$this->data["nb_att"]=1;
	}
	
	function Save()
	{
		parent::save();

		$sql=$this->sql;
		
		if ($this->data["callsign"]!="")
		{
			$q="SELECT id FROM ".$this->tbl."_plane WHERE uid='".$this->data["uid"]."' AND callsign='".strtolower($this->data["callsign"])."'";
			$res=$sql->QueryRow($q);
			
			if ($res["id"]>0)
			{
			}
			else
			{
				$avion=new plane_class(0,$sql);
				$avion->Valid("uid",$this->data["uid"]);
				$avion->Valid("callsign",$this->data["callsign"]);
				$avion->Save();
			}
		}
	}

}

?>