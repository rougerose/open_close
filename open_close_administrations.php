<?php

/**
 * Fichier gérant l'installation et désinstallation du plugin open_close
 *
 * @plugin     open_close
 * @copyright  2017
 * @author     Christophe Le Drean
 * @licence    GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Fonction d'installation et de mise à jour du plugin.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 *
 **/
function open_close_upgrade($nom_meta_base_version, $version_cible) {
	$maj = [];
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Fonction de désinstallation du plugin.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 *
 **/
function open_close_vider_tables($nom_meta_base_version) {
	effacer_meta('open_close');
	effacer_meta($nom_meta_base_version);
}
