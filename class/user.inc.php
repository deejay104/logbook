<?
// Classe Utilisateur

class user_class extends user_core
{
	protected $table="utilisateurs";
	protected $mod="membres";
	protected $rub="detail";

	// protected $type=array(
		// "member_day" => "duration",
		// "member_night" => "duration",
		// "time_dc_day"=>"duration","time_cdb_day"=>"duration","time_dc_night"=>"duration","time_cdb_night"=>"duration",
		// "multi_dc_day" => "duration",
		// "multi_cdb_day" => "duration",
		// "multi_copi_day" => "duration",
		// "multi_dc_night" => "duration",
		// "multi_cdb_night" => "duration",
		// "multi_copi_night" => "duration",
		// "instru_double" => "duration",
		// "instru_pilote" => "duration",
		// "time_simu"=>"duration",
		// "nb_ifr"=>"number"
	// );

	protected $fields_loc = Array
	(
		"member_day" => array("type"=>"duration"),
		"member_night" => array("type"=>"duration"),
		"time_dc_day"=>array("type"=>"duration"),
		"time_cdb_day"=>array("type"=>"duration"),
		"time_dc_night"=>array("type"=>"duration"),
		"time_cdb_night"=>array("type"=>"duration"),
		"multi_dc_day" => array("type"=>"duration"),
		"multi_cdb_day" => array("type"=>"duration"),
		"multi_copi_day" => array("type"=>"duration"),
		"multi_dc_night" => array("type"=>"duration"),
		"multi_cdb_night" => array("type"=>"duration"),
		"multi_copi_night" => array("type"=>"duration"),
		"instru_double" => array("type"=>"duration"),
		"instru_pilote" => array("type"=>"duration"),
		"time_simu"=>array("type"=>"duration"),
		"nb_ifr"=>array("type"=>"number"),
	);

	# Constructor
	function __construct($id=0,$sql="",$me=false,$setdata=true)
	{
		// $this->data["member_day"]=0;
		// $this->data["member_night"]=0;
		// $this->data["time_dc_day"]=0;
		// $this->data["time_cdb_day"]=0;
		// $this->data["time_dc_night"]=0;
		// $this->data["time_cdb_night"]=0;
		// $this->data["multi_dc_day"]="";
		// $this->data["multi_cdb_day"]="";
		// $this->data["multi_copi_day"]="";
		// $this->data["multi_dc_night"]="";
		// $this->data["multi_cdb_night"]="";
		// $this->data["multi_copi_night"]="";
		// $this->data["instru_double"]="";
		// $this->data["instru_pilote"]="";
		// $this->data["time_simu"]=0;
		// $this->data["nb_ifr"]=0;
		$this->fields=array_merge($this->fields,$this->fields_loc); 
	
		parent::__construct($id,$sql);

	}
}

?>