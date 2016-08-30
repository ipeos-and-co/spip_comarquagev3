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

function comarquage_v3_insert_head_css($flux) {
    include_spip('inc/utils');
    $flux .= '<link rel="stylesheet" href="' . find_in_path('css/comarquage.css') . '" media="all" />';

    return $flux;
}
?>
