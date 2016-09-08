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

    // noeud_structure_xml($d);
    // schema de parcours
    // structure();
    $u = $d->saveXML();

    if (is_string($u)) {
		$u = simplexml_load_string($u);
	}
	return array('root' => @fluxXmlObjToArr($u, $utiliser_namespace));
}

/**
 * Transforme un objet SimpleXML en flux de tableau PHP
 * http://www.php.net/manual/pt_BR/book.simplexml.php#108688
 * xaviered at gmail dot com 17-May-2012 07:00
 *
 * @param object $obj
 * @param bool $utiliser_namespace
 * @return array
 **/
function fluxXmlObjToArr($obj, $utiliser_namespace = false) {
	$tableau = array();
	// Cette fonction getDocNamespaces() est longue sur de gros xml. On permet donc
	// de l'activer ou pas suivant le contenu supposé du XML
	if (is_object($obj)) {
		if (is_array($utiliser_namespace)) {
			$namespace = $utiliser_namespace;
		} else {
			if ($utiliser_namespace) {
				$namespace = $obj->getDocNamespaces(true);
			}
			$namespace[null] = null;
		}

		$name = strtolower((string)$obj->getName());
		$text = trim((string)$obj);
		if (strlen($text) <= 0) {
			$text = null;
		}

		$children = array();
		$attributes = array();

		// get info for all namespaces
		foreach ($namespace as $ns => $nsUrl) {
			// attributes
			$objAttributes = $obj->attributes($ns, true);
			foreach ($objAttributes as $attributeName => $attributeValue) {
				$attribName = strtolower(trim((string)$attributeName));
				$attribVal = trim((string)$attributeValue);
				if (!empty($ns)) {
					$attribName = $ns . ':' . $attribName;
				}
				$attributes[$attribName] = $attribVal;
			}

			// children
			$objChildren = $obj->children($ns, true);
      $cpt = -1;
			foreach ($objChildren as $childName => $child) {
				$childName = strtolower((string)$childName);
				if (!empty($ns)) {
					$childName = $ns . ':' . $childName;
				}
        $cpt++;
        // Rendre certain noeud en mode flux 
        // $children[$childName][] = fluxXmlObjToArr($child, $namespace);
        $children[$cpt][] = fluxXmlObjToArr($child, $namespace);
			}
		}

		$tableau = array(
			'name' => $name,
		);
		if ($text) {
			$tableau['text'] = $text;
		}
		if ($attributes) {
			$tableau['attributes'] = $attributes;
		}
		if ($children) {
			$tableau['children'] = $children;
		}
	}

	return $tableau;
}

?>
