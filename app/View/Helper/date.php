<?php 
class DateHelper extends AppHelper{
	
	protected $jour = array(0=>"Dimanche",1=>"Lundi",2=>"Mardi",3=>"Mercredi",4=>"Jeudi",5=>"Vendredi",6=>"Samedi",7=>"Dimanche");
    protected $sJour = array(0=>"Dim",1=>"Lun",2=>"Mar",3=>"Mer",4=>"Jeu",5=>"Ven",6=>"Sam",7=>"Dim");
    protected $mois = array(1=>"Janvier",2=>"Février",3=>"Mars",4=>"Avril",5=>"Mai",6=>"Juin",7=>"Juillet",8=>"Août",9=>"Septembre",10=>"Octobre",11=>"Novembre",12=>"Décembre");
    protected $sMois = array(1=>"Jan",2=>"Fév",3=>"Mars",4=>"Avr",5=>"Mai",6=>"Juin",7=>"Juil",8=>"Août",9=>"Sept",10=>"Oct",11=>"Nov",12=>"Déc");
    
    protected $heure = false;
    protected $cMois = false;
    protected $cJour = false;

    /**
     *Fonction qui renvois le numéro du jour de la semaine
    **/
    
    protected function day2Num($jour){
       $jour = strtolower($jour);
        switch($jour){
            case 'lun' : case 'lundi' : 
                $num = 1; break;
            case 'mar' : case 'mardi' : 
                $num = 2; break;
            case 'mer' : case 'mercredi' : 
                $num = 3; break;
            case 'jeu' : case 'jeudi' : 
                $num = 4; break;
            case 'ven' : case 'vendredi' : 
                $num = 5; break;
            case 'sam' : case 'samedi' : 
                $num = 6; break;
            case 'dim' : case 'dimanche' : 
                $num = 7; break;    
        }
        
        return $num;    
    }
    
    /**
     *  Fonction qui renvois le nom du jour en fonction d'un nombre
    **/
    protected function num2Day($jour){
        $res = $this->cJour ? $this->sJour[$jour] : $this->jour[$jour];
        return $res;
    }
    
    /**
     *Fonction qui renvois le numéro du mois en fonction d'un mois donné
    **/
    
    protected function month2Num($mois){
       $mois = strtolower($mois);
        switch($mois){
            case 'jan' : case 'janvier' : 
                $num = 1; break;
            case 'fev' : case 'fevrier' : 
                $num = 2; break;
            case 'mars' :  
                $num = 3; break;
            case 'avr' : case 'avril' : 
                $num = 4; break;
            case 'mai' :  
                $num = 5; break;
            case 'juin' :  
                $num = 6; break;
            case 'juil' : case 'juillet' : 
                $num = 7; break;
            case 'aout' :  
                $num = 8; break;
            case 'sept' : case 'septembre' : 
                $num = 9; break;     
            case 'oct' : case 'octobre' : 
                $num = 10; break; 
            case 'nov' : case 'novembre' : 
                $num = 11; break; 
            case 'dec' : case 'decembre' : 
                $num = 12; break; 
        }
        return $num;    
    }
    
    /**
     *  Fonction qui renvois le nom du mois en fonction d'un nombre
    **/
    protected function num2Month($mois){
        $res = $this->cMois ? $this->sMois[$mois] : $this->mois[$mois];
        return $res;
    }
    
    /**
     *Fonction qui renvois le nom du mois en fonction d'une date
    **/
    
    public function getNomMois($date){
        $nMois = $this->getMois($date);
        $res = $this->cMois ? $this->sMois[$nMois] : $this->mois[$nMois];
        return $res;
    }
    
    /**
     *Fonction qui renvois le numéro du mois à partir d'une date 
    **/
    
    public function getMois($date){
        $timestamp = $this->format($date,'UNX');
        return date('m',$timestamp);
    }
    
    /**
     *Fonction qui renvois le numéro du jour d'une date
    **/
    
    public function getJour($date){
        $timestamp = $this->format($date,'UNX');
        return date('d',$timestamp);
    }
    
    /**
     *Fonction qui renvois le nom du jour d'une date
    **/
    
    public function getNomJour($date){
        $nJour = $this->getJour($date);
        $res = $this->cJour ? $this->sJour[$nJour] : $this->jour[$nJour];
        return $res;
    }
    
    /**
     *Fonction qui renvois l' année d'une date
    **/
    
    public function getAnnee($date){
        $infosdate = $this->getInfosDate($date);
        if(isset($infosdate['annee']))
            return $infosdate['annee'];
    }
    
    /**
     *  Fonction qui renvoie la date actuelle formatée
    **/
    public function getDate($format ='UNX'){
        return $this->format(time(),$format);
    }
    
    /**
     *retourne le no de semaine d'une date
    **/
    
    public function getSemaine($a_date=""){
	$date = $this->convert("UNX",$date);
	return(date("W",$date));
    }
    
    /**
     *Fonction qui renvois le nombre de jour dans le mois
    **/
    
    public function getJourMois($mois,$annee){
        return date('t',mktime(0, 0, 0, $mois, 1, $annee));
    }
    
    //fonction qui retourne le premier jour du mois
    //0->Lundi
    //1->Mardi
    //...
    //6->Dimanche
    
    protected function getFirstDay($mois,$annee){
        $tmstp=mktime(0,0,0,$mois,1,$annee);
        //on récupère le numéro du jour de la semaine... mais au format anglais (0->dimanche, ...) mais
        //nous on commence le lundi !!
        $jour=date("w",$tmstp);
        return $this->day2Num($this->jour[$jour]);
    }

    //fonction qui renvoit le mois et l'année  dans le calendrier en fonction du pas
    //un pas de 1 signifie la date pour le mois suivant celui passé en paramètre
    //un pas de -1 signifie la date pour le mois précédent celui passé en paramètre
    protected function getSuivant($mois,$annee,$pas){
        $tmstp_suivant=mktime(0,0,0,($mois+$pas),1,$annee);
        $date_suivante['mois']=date("m",$tmstp_suivant);
        $date_suivante['annee']=date("Y",$tmstp_suivant);
        return $date_suivante;
    }
    
    /**
     *  Fonction qui renvois le nombre de jour dans une période
    **/
    
    public function getPeriode($dateFrom,$dateTo){
        $timestampFrom = $this->format($dateFrom,'UNX');
        $timestampTo = $this->format($dateTo,'UNX');
        return floor( (($timestampTo-$timestampFrom)/60/60/24) + 1);
    }
    
    /**
     * Fonction qui renvoit le format d'une date
    **/
    
    public function getFormat($date){
        $date = $this->getInfosDate($date);
        return $date['format'];
    }
    
    /**
     *Fonction qui renvois les infos d'une date sous forme de tableau
    **/
        
    protected function getInfosDate($date){
        
        $res = array();
        
        // défini l'expression régulière d'une date en version fr
        $patternFr = "/^(lundi|lun|mardi|mar|mercredi|mer|jeudi|jeu|vendredi|ven|samedi|sam|dimanche|dim)?";
		$patternFr .= "[[:space:]]*([\d]{1,2})";
		$patternFr .= "[[:space:]]*(janvier|jan|fevrier|février|fev|fév|mars|mar|avril|avr|mai|juin|jui|juillet|aout|août|aou|aoû|septembre|sep|octobre|oct|novembre|nov|decembre|décembre|dec|déc)";
		$patternFr .= "[[:space:]]*([\d]{2,4})";
		$patternFr .= "[[:space:]]?([\d]{2}:[\d]{2}(:[\d]{2})*)?";
		$patternFr .= "$/i";
        
	       // timestamp
		if (is_numeric($date)){
		    $res['format'] = "UNX";
		    $res['annee'] = date("Y",$date);
		    $res['mois'] = date("m",$date);
		    $res['jour'] = date("j",$date);
		    $res['heure'] = date("H:i:s",$date);
		}
		// SQL 					2008-08-11 15:30:21
		else if (preg_match("/^([\d]{4})-([\d]{1,2})-([\d]{1,2})( [\d]{2}:[\d]{2}:[\d]{2})?$/",$date,$l_date)){
		    $res['format'] = "SQL";
		    $res['annee'] = $l_date[1];
		    $res['mois'] = $l_date[2];
		    $res['jour'] = $l_date[3];
		    $res['heure'] = isset($l_date[4]) ? trim($l_date[4]) : "00:00:00";
		}
		// STR 					11/08/2008 ou 11/08/2008
		else if (preg_match("/^([\d]{1,2})\/([\d]{1,2})\/([\d]{2,4})([[:space:]]?[\d]{2}:[\d]{2}(:[\d]{2})*)?$/",$date,$l_date)){
		    $res['format'] = "STR";
		    $res['annee'] = $l_date[3];
		    $res['mois'] = $l_date[2];
		    $res['jour'] = $l_date[1];
		    $res['heure'] = isset($l_date[4]) ? trim($l_date[4]) : "00:00:00";
		}
		// RSS					Mon, 11 Aug 2008 14:18:58
		else if (preg_match("/^([\w]{3}), ([\d]{1,2}) ([\w]{1,3}) ([\d]{2,4}) ([\d]{2}:[\d]{2}:[\d]{2})$/i",$date,$l_date)){
		    $res['format'] = "RSS";
		    $res['annee'] = $l_date[4];
		    $res['mois'] = $this->getNumMois($l_date[3]);
		    $res['jour'] = $l_date[2];
		    $res['heure'] = isset($l_date[5]) ? trim($l_date[5]) : "00:00:00";
		}
	        // FR 					lundi 11 aout 2008 14:18:58
		else if (preg_match($patternFr,$date,$l_date)){
		    $res['format'] = "FR";
		    $res['annee'] = $l_date[4];
		    $res['mois'] = $this->getNumMois($l_date[3]);
		    $res['jour'] = $l_date[2];
		    $res['heure'] = isset($l_date[5]) ? trim($l_date[5]) : "00:00:00";
		}
	    return $res;
    }
    
    public function format($date,$type = null){
        
        // analyse de la date envoyée
        $infosdate = array();
        $infosdate = $this->getInfosDate($date);
        if(isset($infosdate['heure ']) && $infosdate['heure'] != '00:00:00'){
            $heures = explode(':',$infosdate['heure']);
            $timestamp = gmmktime($heures[0],$heures[1],$heures[2],$infosdate['mois'],$infosdate['jour'],$infosdate['annee']);
        }
        else
            $timestamp = gmmktime(0,0,0,$infosdate['mois'],$infosdate['jour'],$infosdate['annee']);
        if(isset($type)){
            switch($type){
                case 'UNX' :
                    $res = $timestamp;
                    break;
                case 'SQL' :
                    $res = gmdate('Y-m-d '.($this->heure ? 'H:i:s' : ''),$timestamp);
                    break;
                case 'STR' :
                    $res = gmdate('d/m/Y',$timestamp);
                    break;
                case 'FR' :
                    $res = $this->cJour ? $this->sJour[gmdate('w',$timestamp)] : $this->jour[gmdate('w',$timestamp)];
                    $res .= ' '.$infosdate['jour'];
                    $res .= ' '.($this->cMois ? $this->sMois[gmdate('n',$timestamp)] : $this->mois[gmdate('n',$timestamp)]);
                    $res .= ' '.$infosdate['annee'];
                    break;
                case 'FRS' :
                    $res = ' '.$infosdate['jour'];
                    $res .= ' '.($this->cMois ? $this->sMois[gmdate('n',$timestamp)] : $this->mois[gmdate('n',$timestamp)]);
                    $res .= ' '.$infosdate['annee'];
                    break;
                case 'URL' :
                    $res = gmdate('Y/m/d',$timestamp);
                    break;
            }
        }
        return $res;
    }
    
    public function setHeure($bool = false){
        $this->heure = $bool;
    }
    
    public function setMoisCourt($bool = false){
        $this->cMois = $bool;
    }
    
    public function setJourCourt($bool = false){
        $this->cJour = $bool;
    }
}
 ?>