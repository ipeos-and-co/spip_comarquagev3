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


/**
 * Inserer des scripts dans le head
 * @param $flux
 * @return string
 */
function comarquage_v3_insert_head($flux){
  $flux .= '<script type="text/javascript" src="' . find_in_path('js/comarquage.js') . '"></script>';
  return $flux;
}

/**
 * Inserer des scripts dans le head
 * @param $flux
 * @return string
 */
function comarquage_v3_insert_head_css($flux) {
    $flux .= '<link rel="stylesheet" href="' . find_in_path('css/comarquage.css') . '" media="all" />';
    return $flux;
}
?>
