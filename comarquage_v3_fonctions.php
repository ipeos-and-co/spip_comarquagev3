<?php
/* Plugin Comarquage -flux V3-
 * Auteur Mickaël Hippocrate
 * Auteur IPEOS I-Solutions
 *
 * Licence GPL
 *
 */
 if (!defined("_ECRIRE_INC_VERSION")) {
 	return;
 }

// Récupération des types de catégorie et leurs URL
function type_categorie($categorie){
    $parametres_xml = array();
    switch ($categorie) {
        case "particuliers":
            $parametres_xml['XMLURL'] = "https://lecomarquage.service-public.fr/vdd/3.0/part/xml/";
            $parametres_xml['CATEGORIE'] = "part";
            break;

        case "associations":
            $parametres_xml['XMLURL'] = "https://lecomarquage.service-public.fr/vdd/3.0/asso/xml/";
            $parametres_xml['CATEGORIE'] = "asso";
            break;

        case 'entreprises':
            $parametres_xml['XMLURL'] = "https://lecomarquage.service-public.fr/vdd/3.0/pro/xml/";
            $parametres_xml['CATEGORIE'] = "pro";
            break;

        default:
            $parametres_xml['XMLURL'] = "https://lecomarquage.service-public.fr/vdd/3.0/part/xml/";
            $parametres_xml['CATEGORIE'] = "part";
            break;
    }
    return $parametres_xml;
}

// Identification template
function type_entrer($xml){
    switch ($xml){
        case "accueil":
            $chemin_xml = "accueil";
            break;
        case "Particuliers":
            $chemin_xml = "accueil";
            break;
        case "arborescence":
            $chemin_xml = "arborescence";
            break;
        case "centresDeContact":
            $chemin_xml = "centresDeContact";
            break;
        case "commentFaireSi":
            $chemin_xml = "commentFaireSi";
            break;
        case "menu":
            $chemin_xml = "menu";
            break;
        case "questionsReponses":
            $chemin_xml = "questionsReponses";
            break;
        case "questionsReponses":
            $chemin_xml = "questionsReponses";
            break;
        case "servicesEnLigne":
            $chemin_xml = "servicesEnLigne";
            break;
        case "index":
            $chemin_xml = "actualites";
            break;
        default:
            $chemin_xml = parser_xml($xml);
    }
    return $chemin_xml;
}

// Identification des noeuds
function parser_xml($xml){
    $id = $xml[0];
    switch ($id){
        case "F":
            $noeud = "fiche";
            break;
        case "R":
            $noeud = "ressources";
            break;
        case "N":
            $noeud = "noeud";
            break;
        default:
            $noeud = "accueil";
    }
    return $noeud;
}

function media_local($id){
    $name= "";
    switch($id){
        case "N19803":
            $name = "argent.jpg";
            break;
        case "N19804":
            $name = "europe.jpg";
            break;
        case "N19805":
            $name = "famille.jpg";
            break;
        case "N19806":
            $name = "formation.jpg";
            break;
        case "N19807":
            $name = "justice.jpg";
            break;
        case "N19808":
            $name = "logement.jpg";
            break;
        case "N19809":
            $name = "loisirs.jpg";
            break;
        case "N19810":
            $name = "citoyennete.jpg";
            break;
        case "N19811":
            $name = "sante.jpg";
            break;
        case "N19812":
            $name = "transport.jpg";
            break;
        case "F14128":
            $name = "demenager.jpg";
            break;
        case "F16225":
            $name = "enfant.jpg";
            break;
        case "F17556":
            $name = "emploi.jpg";
            break;
        case "F14485":
            $name = "marie.jpg";
            break;
        case "F16507":
            $name = "deces.jpg";
            break;
        case "F1700":
            $name = "administration.jpg";
            break;
        case "F15913":
            $name = "achat-logement.jpg";
            break;
        case "F17904":
            $name = "retraite.jpg";
            break;
        case "F17649":
            $name = "succession.jpg";
            break;
        case "F3109":
            $name = "associations.jpg";
            break;
        case "F21829":
            $name = "logement.jpg";
            break;
        case "F601":
            $name = "enfant.jpg";
            break;
        case "N24264":
            $name = "creation-cession.jpg";
            break;
        case "N24265":
            $name = "fiscalite.jpg";
            break;
        case "N24266":
            $name = "gestion-finance.jpg";
            break;
        case "N24267":
            $name = "rh.jpg";
            break;
        case "N24268":
            $name = "vente-commerce.jpg";
            break;
        case "N24269":
            $name = "secteurs.jpg";
            break;
        case "F23961":
            $name = "comment-faire.jpg";
            break;
        case "F23697":
            $name = "comment-faire.jpg";
            break;
        case "F23571":
            $name = "comment-faire.jpg";
            break;
        default:
            $name = " ";
    }
    return $name;
}

/**
 * Transforme un texte XML en tableau PHP
 *
 * @param string|object $u
 * @param bool $utiliser_namespace
 * @return array
 */
function inc_domdocument_to_array($u, $utiliser_namespace = false) {
    $d = New DOMDocument();
    $d->loadXML($u);

    $paragraphe = $d->getElementsByTagName('Paragraphe');
    if ($paragraphe){
        $i = 0;
        for($i=0; $i < $paragraphe->length; $i++){
            for($x=0; $x < $paragraphe->item($i)->childNodes->length; $x++){
                if(is_null($paragraphe->item($i)->childNodes->item($x)->tagName)){

                    // code http://php.net/manual/fr/domnode.replacechild.php#48485
                    // Ajouts d'un noeud "texteInterne"
                    $parent = new DOMDocument();
                    $parent_node = $parent->createElement('TexteInterne', $paragraphe->item($i)->childNodes->item($x)->nodeValue);
                    $parent->appendChild($parent_node);

                    // Récupère le chemin de l'ancien noeud
                    $xpath = new DOMXPath($d);
                    $nodelist = $xpath->query($paragraphe->item($i)->childNodes->item($x)->getNodePath());
                    $oldnode = $nodelist->item(0);

                    // Remplace les noeuds
                    $newnode = $d->importNode($parent->documentElement, true);
                    $oldnode->parentNode->replaceChild($newnode, $oldnode);
                }
            }
        }
    }

    noeud_structure_xml($d);
    // schema de parcours
    // structure();
    $u = $d->saveXML();

    if (is_string($u)) {
		$u = simplexml_load_string($u);
	}
    include_spip('inc/simplexml_to_array');
	return array('root' => @xmlObjToArr($u, $utiliser_namespace));
}


global $parent_node;
$parent_node = array();

function noeud_structure_xml($d){
  global $parent_node;
    $node_list = array(
        'SurTitre',
        'Audience',
        'Canal',
        'Cible',
        // 'Theme',
        'SousThemePere',
        // 'DossierPere',
        'SousDossierPere',
        'SousTheme',
        'Dossier',
        'SousDossier',
        'Fiche',
        'Avertissement',
        'Introduction',
        'Groupe',
        'Texte',
        'ListeSituations',
        'LienExterneCommente',
        'VoirAussi',
        'OuSAdresser',
        'Reference',
        'Partenaire',
        'Actualite',
        'ServiceEnLigne',
        'PourEnSavoirPlus',
        'SiteInternetPublic',
        'Definition',
        'Abreviation',
        'QuestionReponse',
        'CommentFaireSi',
        'InformationComplementaire'
    );

    foreach($d->documentElement->childNodes as $value){
        if (in_array($value->tagName, $node_list)){
            trace_xml($value);
        }
    }
}

global $parser_xpath_old;
$parser_xpath_old = "null";

function trace_xml($child, $parser_xpath = ""){
    global $parent_node, $parser_xpath_old;
    for($i=0; $i < $child->childNodes->length;$i++){
      if($child->childNodes->item($i)->hasChildNodes()){
        $parser_xpath = $child->getNodePath();
        trace_xml($child->childNodes->item($i), $parser_xpath);
      }
    }

    if(!strpos($parser_xpath, $parser_xpath_old)){
      $parser_xpath_old = $parser_xpath;
      $parent_node[] = $parser_xpath;
    }
}

//conversion du xpath DomDocument en xpath SimpleXML
function getxpathxml(){
  global $parent_node;
  foreach ($parent_node as $k => $v){
    if(empty($v)){
      unset($parent_node[$k]);
    }else{
      $capture = preg_split("/\/([a-zA-Z]*)\[?(\d*)\]?/", $parent_node[$k], NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

      $total = count($capture);
      foreach ($capture as $key => $value) {
        if($key < 1){
          $parent_node[$k] = "children/";
        }else{
          if(is_numeric($capture[$key])){
            $parent_node[$k] .= intval($capture[$key]-1);
            if($key <  $total-1){
              $parent_node[$k] .= "/";
            }
          }else{
            if($key > 1 and $key <  $total){
              $parent_node[$k] .= "children/";
            }
            $parent_node[$k] .= strtolower($capture[$key]);
            if($key <  $total-1){
              $parent_node[$k] .= "/";
            }
            if(!is_numeric($capture[$key+1]) and $key < $total-1){
              $parent_node[$k] .= "0/";
            }
          }
        }
      }
    }
  }
  $parent_node = array_unique($parent_node);
  return $parent_node;
}

function cut_xpath(){
  global $parent_node;
  getxpathxml();
  foreach ($parent_node as $key => $value){
    $tab_current = current($parent_node);
    $tab_next = next($parent_node);
    if(strlen($tab_next)<=strlen($tab_current)){
      $res = strpos($tab_current,$tab_next);
      if($res !== false){
        unset($parent_node[$key]);
      }
    }
  }
  return $parent_node;
}

function profondeur($str){
  $chemin ="";
  $liste_noeud = array(
    "paragraphe",
    "chapitre",
    "ousadresser",
    "reference",
    "serviceenligne",
    "pourensavoirplus",
    "abreviation",
  );
  $capture = preg_split("/(children\/[a-zA-Z]+\/?[\d]?)+/", $str, NULL, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

  for($k=0;$k<sizeof($capture);$k++){
    if($capture[$k]<>"/"){
      $val = explode('/',$capture[$k]);
      // $tableau .= $capture[$k];
      for($i=0;$i<sizeof($val);$i++){
        if(in_array($val[$i],$liste_noeud, TRUE)){
          $cap = $capture[$k];
          $i = sizeof($val);
        }
      }

      $pos = strpos($cap,$capture[$k]);

      if($pos !== false){
        $chemin .= $capture[$k];
        $k = sizeof($capture);
      }else{
        $chemin .= $capture[$k];
        $chemin .= "/";
      }
    }
  }
  return $chemin;
}

?>
