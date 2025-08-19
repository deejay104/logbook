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

	function ListeTerrains()
	{
		$sql=$this->sql;

		$tabValeur=array();

		$query = "SELECT flight.field_from AS nom,COUNT(*) AS nb,MAX(flight.dte_flight) AS last, wp.description,wp.lat AS latitude,wp.lon AS longitude FROM ".$this->tbl."_flight AS flight ";
		$query.= "LEFT JOIN ".$this->tbl."_navpoints AS wp ON flight.field_from=wp.nom ";
		$query.= "WHERE uid='".$this->id."' GROUP BY flight.field_from";
		$sql->Query($query);

		for($i=0; $i<$sql->rows; $i++)
		{ 
			$sql->GetRow($i);
			$tabValeur[$sql->data["nom"]]["nom"]=$sql->data["nom"];
			$tabValeur[$sql->data["nom"]]["description"]=$sql->data["description"];
			$tabValeur[$sql->data["nom"]]["nb"]=$sql->data["nb"];
			$tabValeur[$sql->data["nom"]]["last"]=$sql->data["last"];
			$tabValeur[$sql->data["nom"]]["latitude"]=$sql->data["latitude"];
			$tabValeur[$sql->data["nom"]]["longitude"]=$sql->data["longitude"];
		}


		$query = "SELECT flight.field_to AS nom,COUNT(*) AS nb,MAX(flight.dte_flight) AS last, wp.description,wp.lat AS latitude,wp.lon AS longitude FROM ".$this->tbl."_flight AS flight ";
		$query.= "LEFT JOIN ".$this->tbl."_navpoints AS wp ON flight.field_to=wp.nom ";
		$query.= "WHERE uid='".$this->id."' GROUP BY flight.field_to";
		$sql->Query($query);

		for($i=0; $i<$sql->rows; $i++)
		{ 
			$sql->GetRow($i);

			if (isset($tabValeur[$sql->data["nom"]]))
			{
				$tabValeur[$sql->data["nom"]]["nb"]=$tabValeur[$sql->data["nom"]]["nb"]+$sql->data["nb"];
			}
			else
			{
				$tabValeur[$sql->data["nom"]]["nom"]=$sql->data["nom"];
				$tabValeur[$sql->data["nom"]]["description"]=$sql->data["description"];
				$tabValeur[$sql->data["nom"]]["nb"]=$sql->data["nb"];
				$tabValeur[$sql->data["nom"]]["last"]=$sql->data["last"];
				$tabValeur[$sql->data["nom"]]["latitude"]=$sql->data["latitude"];
				$tabValeur[$sql->data["nom"]]["longitude"]=$sql->data["longitude"];
			}
		}

		return $tabValeur;
	}

	function OrigineTerrains()
	{
		$sql=$this->sql;

		$query = "SELECT field_from AS nom,COUNT(*) AS nb, wp.description,wp.lat AS latitude,wp.lon AS longitude FROM ".$this->tbl."_flight AS flight ";
		$query.= "LEFT JOIN ".$this->tbl."_navpoints AS wp ON flight.field_from=wp.nom ";
		$query.= "WHERE uid='".$this->id."' AND flight.field_from<>'' GROUP BY flight.field_from ORDER BY nb DESC LIMIT 0,1";
		$res=$sql->QueryRow($query);

		$tabValeur=array();
		$tabValeur["nom"]=$res["nom"];
		$tabValeur["latitude"]=$res["latitude"];
		$tabValeur["longitude"]=$res["longitude"];

		return $tabValeur;
	}
}

?>