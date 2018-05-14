<?
// Classe Utilisateur

class user_class extends objet_core
{
	protected $table="utilisateurs";
	protected $mod="membres";
	protected $rub="detail";

	protected $type=array("time_dc_day"=>"duration","time_cdb_day"=>"duration","time_dc_night"=>"duration","time_cdb_night"=>"duration","time_simu"=>"duration");

	# Constructor
	function __construct($id=0,$sql,$me=false,$setdata=true)
	{
		$this->data["time_dc_day"]=0;
		$this->data["time_cdb_day"]=0;
		$this->data["time_dc_night"]=0;
		$this->data["time_cdb_night"]=0;
		$this->data["time_simu"]=0;
	
		parent::__construct($id,$sql);

	}
}

?>