<?
// ---------------------------------------------------------------------------------------------
//   Variables
// ---------------------------------------------------------------------------------------------

$MyOptTmpl=array();
$MyOptHelp=array();

$MyOptHelp[""]="";

// Prefixe des tables
$MyOptTmpl["tbl"]="ea";
$MyOptHelp["tbl"]="Prefixe des tables dans la base de donn�es";

// Site en maintenance
$MyOptTmpl["maintenance"]="off";
$MyOptHelp["maintenance"]="Mettre le site en maintenance (on=site en maintenance, off=site accessible)";

// path
$MyOptTmpl["mydir"]=htmlentities(preg_replace("/[a-z]*\.php/","",$_SERVER["SCRIPT_FILENAME"]));
$MyOptHelp["mydir"]="Chemin de l'installation. Utilis� pour l'ex�cution des scripts";

// Timezone
$MyOptTmpl["timezone"]=date_default_timezone_get();
$MyOptHelp["timezone"]="S�lectionner la timezone locale (Europe/Paris)";


// URL
$MyOptTmpl["host"]=htmlentities($_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].preg_replace("/\/[a-z]*\.php/","",$_SERVER["SCRIPT_NAME"]));
$MyOptHelp["host"]="Chemin complet du site. Utilis� pour g�n�rer les url statiques.";

// Titre du site
$MyOptTmpl["site_title"]="Batch";
$MyOptHelp["site_title"]="Titre du site web";

// Logo du site dans le dossier images
$MyOptTmpl["site_logo"]="logo.png";
$MyOptHelp["site_logo"]="Nom du fichier pour le logo. Il doit se trouver dans le dossier custom.";

// Active l'envoi de mail (0=ok, 1=nok)
$MyOptTmpl["sendmail"]="off";
$MyOptHelp["sendmail"]="Active l'envoi de mail (on=Activ�)";

$MyOptTmpl["mail"]["smtp"]="on";
$MyOptHelp["mail"]["smtp"]="Envoie des mails par SMTP (on=SMTP sinon sendmail)";

$MyOptTmpl["mail"]["host"]="localhost";
$MyOptHelp["mail"]["host"]="FQDN du serveur SMTP";

$MyOptTmpl["mail"]["port"]="25";
$MyOptHelp["mail"]["port"]="SMTP port";

$MyOptTmpl["mail"]["username"]="";
$MyOptHelp["mail"]["username"]="SMTP username";

$MyOptTmpl["mail"]["password"]="";
$MyOptHelp["mail"]["password"]="SMTP user password";

// Uid Syst�me
$MyOptTmpl["uid_system"]=2;
$MyOptHelp["uid_system"]="ID du compte syst�me";

// Trie par Nom ou par Pr�nom
$MyOptTmpl["globalTrie"]="prenom";
$MyOptHelp["globalTrie"]="Ordre de trie par d�fault des listes (prenom, nom,...). Mettre le nom du champs pour le trie";

// Active la visualisation des membres supprim�s
$MyOptTmpl["showDesactive"]="";
$MyOptHelp["showDesactive"]="on : Affiche les membres supprim�s";

$MyOptTmpl["showSupprime"]="";
$MyOptHelp["showSupprime"]="on : Affiche les membres supprim�s";

// Documents
$MyOptTmpl["expireCache"]="0";
$MyOptHelp["expireCache"]="Si sup�rieur � 0, nombre d'heure durant lesquelles on garde les fichiers en cache. Si 0, on garde ind�finiment.";


// Modules

// D�nini les droits d'acc�s aux rubriques
// [vide] : Visible par tous
// x : Visible pour tous, y compris invit�
// - : Masqu�
// [Role] : Affich� que pour le role
$MyOptHelp["menu"]["accueil"]="Affichage des menus du site. [vide]: Visible par tous, x : visible pour tous y compris les invit�s, - : Masqu�, [Role] : Affich� uniquement pour le role correspondant";

$MyOptTmpl["menu"]["accueil"]="";
$MyOptTmpl["menu"]["membres"]="x";
$MyOptTmpl["menu"]["forums"]="";
$MyOptTmpl["menu"]["mesinfos"]="x";
$MyOptTmpl["menu"]["configuration"]="AccesConfiguration";


?>
