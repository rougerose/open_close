<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function verifier_comparaison_date_dist($valeur, $options = []) {

	$verifier = charger_fonction('verifier', 'inc/');
	$verifier_date = $verifier($valeur, 'date');

	if ($verifier_date) {

		return $verifier_date;

	}

	if (!$champ = $options['champ'] or !is_scalar($champ)) {

		return true;

	}

	$valeur_champ = _request($champ);

	$date_debut = strtotime(date_format(date_create_from_format('j/m/Y', $valeur_champ), 'Y-m-d'));
	$date_fin = strtotime(date_format(date_create_from_format('j/m/Y', $valeur), 'Y-m-d'));

	if ($date_fin < $date_debut) {

		return _T('agenda:erreur_date_avant_apres');

	}

	return '';

}
