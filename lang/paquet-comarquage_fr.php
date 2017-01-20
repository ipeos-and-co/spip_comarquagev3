<?php
/**
 * Fichier de langue pour le paquet Comarquage
 *
 * @plugin     Comarquage
 * @copyright  2017
 * @author     Mickaël Hippocrate
 * @author     Laurent Vergerolle
 * @author     Olivier Watté
 * @licence    GPLv3
 * @package    SPIP/Comarquage/Lang
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(
	'comarquage_description' => "Le flux s’insère dans un article au moyen du tag : <code><comarquage|categorie=particuliers></code> <br/>Vous pouvez préciser une page en définissant l’attributs xml de l’url :<br/><code><comarquage|categorie=particuliers|xml=N333></code> <br/>Par exemple pour appeler la page principale de la rubrique 'Comment faire si' utilisez ce code : <br/><code><comarquage|categorie=particuliers|xml=N13042></code> <br/>Pour appeler la page principale de la rubrique 'Associations', insérez ce code : <br/><code><comarquage|categorie=associations|xml=N20></code>",
	'comarquage_nom' => 'Co-Marquage Service Public',
	'comarquage_slogan' => 'Rediffuser le flux de la documentation française du service public',
);
