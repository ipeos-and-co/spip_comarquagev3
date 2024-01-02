<?php
/**
 * filtres et balises specifiques au plugin
 *
 * @plugin    Comarquage
 * @copyright 2017
 * @author    Mickaël Hippocrate
 * @author    Laurent Vergerolle
 * @licence   GPLv3
 * @package   SPIP\Comarquage\Fonctions
 */

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}


function comarquage_url_cache($url) {
	include_spip('inc/distant');
	if (function_exists('curl_init')) {
		// version moderne
		$fichier_copie_locale = _DIR_RACINE . nom_fichier_copie_locale($url, 'xml');
		$fichier_cache = sous_repertoire(_DIR_CACHE, 'comarquage') . basename($fichier_copie_locale);
		// recuperer les anciens cache de IMG/distant/ si dispo
		if (file_exists($fichier_copie_locale) and !file_exists($fichier_cache)) {
			@rename($fichier_copie_locale, $fichier_cache);
		}

		// le cache date de moins d'1h, on renvoie sans faire de hit sur le serveur
		$fichier_cache_check = dirname($fichier_cache). '/.' . $fichier_cache . '.check';
		if (file_exists($fichier_cache)) {
			if (filemtime($fichier_cache) > $_SERVER['REQUEST_TIME'] - 3600) {
				return $fichier_cache;
			}
			if (file_exists($fichier_cache_check) and filemtime($fichier_cache_check) > $_SERVER['REQUEST_TIME'] - 3600) {
				return $fichier_cache;
			}
		}

		// CURL le fichier car recuperer_url() tourne en boucle infinie dans certaines config depuis le 24/11/2023
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

		spip_log("comarquage_url_cache sur $url via curl", 'distant' . _LOG_DEBUG);

		$user_agent = "SPIP/Comarquage";

		$headers = [];
		$headers[] = 'Connection: Close';
		$headers[] = "User-Agent: $user_agent";

		if (file_exists($fichier_cache)) {
			$headers[] = "If-Modified-Since: " . gmdate('D, d M Y H:i:s \G\M\T', filemtime($fichier_cache));
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		//getting response from server
		$response = curl_exec($ch);
		$erreur = curl_errno($ch);
		$erreur_msg = curl_error($ch);
		if (!$erreur){
			//closing the curl
			curl_close($ch);
			spip_log("comarquage_url_cache sur $url via curl OK : " . strlen($response).'car', 'distant');
			if ($response) {
				spip_log("comarquage_url_cache sur $url via curl OK : => $fichier_cache", 'distant');
				file_put_contents($fichier_cache, $response);
			}
		}
		else {
			spip_log("comarquage_url_cache sur $url via curl HS : " . $response, 'distant' . _LOG_ERREUR);
		}


		// et dans tous les cas on touch le check, pour ne pas verifier de nouveau avant 1h
		@touch($fichier_cache_check);

		return $fichier_cache;

	} else {
		// compat old SPIP
		return copie_locale($url, 'modif');
	}
}

/**
 * Récupération des types de catégorie et leurs URL
 *
 * @param string $categorie
 *
 * @return array
 */
function filtre_type_categorie_dist($categorie) {
	$parametres_xml = array();
	switch ($categorie) {
		case "particuliers":
			$parametres_xml['XMLURL'] = "https://lecomarquage.service-public.fr/vdd/3.3/part/xml/";
			$parametres_xml['CATEGORIE'] = "part";
			break;

		case "associations":
			$parametres_xml['XMLURL'] = "https://lecomarquage.service-public.fr/vdd/3.3/asso/xml/";
			$parametres_xml['CATEGORIE'] = "asso";
			break;

		case 'entreprises':
			$parametres_xml['XMLURL'] = "https://lecomarquage.service-public.fr/vdd/3.3/pro/xml/";
			$parametres_xml['CATEGORIE'] = "pro";
			break;

		default:
			$parametres_xml['XMLURL'] = "https://lecomarquage.service-public.fr/vdd/3.3/part/xml/";
			$parametres_xml['CATEGORIE'] = "part";
			break;
	}

	return $parametres_xml;
}

/**
 * Définit la variable `xml` à la valeur passée en paramètre ou à la
 * valeur par défaut.
 *
 * Nécessaire pour SPIP 2, dont la balise #GET ne renvoie pas la valeur par
 * défaut si la variable est vide.
 *
 * @param string $set
 * @return string
 */
function filtre_set_xml($set) {
	$xml = _request('xml');
	return $xml ? $xml : 'accueil';
}

/**
 * Identification template
 *
 * @param string $xml
 *
 * @return string
 */
function type_entrer($xml) {
	switch ($xml) {
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

/**
 * Identification des noeuds
 *
 * @param array $xml
 *
 * @return string
 */
function parser_xml($xml) {
	$id = substr($xml,0,1);
	switch ($id) {
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

/**
 * Retrouver l'icone associée à la fiche co-marquée
 *
 * @param $id
 *
 * @return string
 */
function media_local($id) {
	$name = "";
	switch ($id) {
		# Particuliers
		case "N19803":
			$name = "part-argent.png";
			break;
		case "N19804":
			$name = "part-europe.png";
			break;
		case "N19805":
			$name = "part-famille.png";
			break;
		case "N19806":
			$name = "part-travail.png";
			break;
		case "N19807":
			$name = "part-justice.png";
			break;
		case "N19808":
			$name = "part-logement.png";
			break;
		case "N19809":
			$name = "part-loisirs.png";
			break;
		case "N19810":
			$name = "part-citoyennete.png";
			break;
		case "N19811":
			$name = "part-sante.png";
			break;
		case "N19812":
			$name = "part-transport.png";
			break;

		# Entreprise
		case "N24264":
			$name = "pro-creation-cessation.png";
			break;
		case "N24265":
			$name = "pro-fiscalite.png";
			break;
		case "N24266":
			$name = "pro-gestion-finance.png";
			break;
		case "N24267":
			$name = "pro-rh.png";
			break;
		case "N24268":
			$name = "pro-vente-commerce.png";
			break;
		case "N24269":
			$name = "pro-secteurs.png";
			break;

		case "N31403":
			$name = "asso-formalites.png";
			break;
		case "N31404":
			$name = "asso-fonctionnement.png";
			break;
		case "N31405":
			$name = "asso-finances.png";
			break;
		case "N31406":
			$name = "asso-specifique.png";
			break;
		default:
			$name = " ";
	}

	return $name;
}

/**
 * Identifiant unique utile pour générer des ID unique
 *
 * @return string
 */
function comarquage_token() {
	return substr(md5(rand(0, 1000000) . 'comarquage'), 0, 6);
}

/**
 * Transforme un texte XML en tableau PHP
 *
 * @param string|object $u
 * @param bool $utiliser_namespace
 *
 * @return array
 */
function inc_comarquagexml_to_array($u, $utiliser_namespace = false) {
	$d = New DOMDocument();
	@$d->loadXML($u);

	$paragraphe = $d->getElementsByTagName('Paragraphe');
	if ($paragraphe) {
		for ($i = 0; $i < $paragraphe->length; $i++) {
			for ($x = 0; $x < $paragraphe->item($i)->childNodes->length; $x++) {
				if (
					isset($paragraphe->item($i)->childNodes->item($x)->tagName)
					and is_null($paragraphe->item($i)->childNodes->item($x)->tagName)
				) {

					// code http://php.net/manual/fr/domnode.replacechild.php#48485
					// Ajouts d'un noeud "texteInterne"
					$parent = new DOMDocument();
					$parent_node = $parent->createElement('TexteInterne',
						$paragraphe->item($i)->childNodes->item($x)->nodeValue);
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

	$u = $d->saveXML();

	if (is_string($u)) {
		$u = @simplexml_load_string($u);
	}

	return array('root' => @fluxXmlObjToArr($u, $utiliser_namespace));
}

/**
 * Reprise de la fonction de SPIP pour fonctionner avec SimpleXMLElement
 * https://core.spip.net/projects/spip/repository/entry/spip/ecrire/iterateur/data.php#L832
 *
 * @param object $obj
 * @param bool $utiliser_namespace
 *
 * @return array
 **/

function fluxXmlObjToArr($obj, $utiliser_namespace = false, $parentName = '') {

	$tableau = array();
	$orderedTags = array(
		'paragraphe',
		'cas',
		'chapitre',
		'texte',
		'souschapitre'
	);

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
			foreach ($objChildren as $childName => $child) {
				$childName = strtolower((string)$childName);
				if (!empty($ns)) {
					$childName = $ns . ':' . $childName;
				}

				if (in_array($parentName, $orderedTags)) {
					$children[][$childName][] = fluxXmlObjToArr($child, $namespace, $childName);
				} else {
					$children[$childName][] = fluxXmlObjToArr($child, $namespace, $childName);
				}
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
