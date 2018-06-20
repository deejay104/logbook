<?
// Classe Vol
require_once($appfolder."/class/avion.inc.php");

class flight_class extends objet_core
{
	protected $table="flight";
	protected $mod="logs";
	protected $rub="edit";

	protected $type=array(
		"dte_flight"=>"date",
		"callsign"=>"uppercase",
		"type"=>"enum",
		"comment"=>"varchar",
		"time_dc_day"=>"duration",
		"time_cdb_day"=>"duration",
		"time_dc_night"=>"duration",
		"time_cdb_night"=>"duration",
		"time_simu"=>"duration",
		"nb_ifr"=>"number",
		"nb_att"=>"number",
		"nb_amerr"=>"number",
	);

	protected $tabList=array(
		"type"=>array('P'=>'Pilote','EP'=>'Elève'),
	);
	
	# Constructor
	function __construct($id=0,$sql)
	{
		global $gl_uid;
		$this->data["uid"]=$gl_uid;
		$this->data["dte_flight"]=date("Y-m-d");
		$this->data["callsign"]="";
		$this->data["type"]="P";
		$this->data["comment"]="";
		$this->data["time_dc_day"]="";
		$this->data["time_cdb_day"]="";
		$this->data["time_dc_night"]="";
		$this->data["time_cdb_night"]="";
		$this->data["time_simu"]="";
		$this->data["nb_ifr"]=0;
		$this->data["nb_att"]=1;
		$this->data["nb_amerr"]=0;

	
		parent::__construct($id,$sql);

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