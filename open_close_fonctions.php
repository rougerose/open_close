<?php

if (!defined('_ECRIRE_INC_VERSION')) {
  return;
}

/**
 * isOpenClose
 *
 * Utilise https://github.com/coryetzkorn/php-store-hours
 *
 * Déterminer à partir des heures d'ouverture enregistrées dans la base,
 * et éventuellement de dates (début et fin) de vacances
 * si le lieu est ouvert ou fermé
 *
 * @param date $date La date passée en argument n'est pas prise en compte.
 * @param string $ouvert La chaîne à retourner si le lieu est ouvert.
 * @param string $ferme La chaîne à retourner si le lieu est fermé.
 * @return return string
 */
function filtre_isOpenClose($date, $ouvert, $ferme) {

  include_spip('lib/php-store-hours/StoreHours.class');

  $tz = lire_config('timezone');
  $oc = lire_config('open_close');

  if (isset($tz) AND isset($oc)) {
    date_default_timezone_set($tz);

    $horaires = array();
    $vacances = array();
    $exceptions = array();
    $semaine = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');

    foreach ($oc as $cle => $valeur) {
      // horaires
      if (strstr($cle, 'jour_')) {
        $jour = substr($cle, 5);
        $horaire = array_map('trim', explode(',', $valeur));
        $horaires[$semaine[$jour]] = $horaire;
      }

      // vacances
      if (strstr($cle, 'vacances_') AND !empty($valeur)) {
        // vacances_debut ou vacances_fin
        $periodes = substr($cle, 9);

        // convertir la date jj/mm/aaaa en Y-m-d
        $date = date_create_from_format('j/m/Y', $valeur);
        $vacances[$periodes] = date_format($date, 'Y-m-d');
      }
    }

    if (count($vacances) == 2) {
      $debut = new DateTime($vacances['debut']);
      $fin = new DateTime($vacances['fin']);
      $fin = $fin->modify('+1 day');
      $interval = new DateInterval('P1D');
      $dates = new DatePeriod($debut, $interval, $fin);

      foreach($dates as $date) {
        $cle = $date->format('Y-m-d');
        $exceptions[$cle] = array();
      }
    }

    $store_hours = new StoreHours($horaires, $exceptions);

    if($store_hours->is_open()) {
      return $ouvert;
    } else {
      return $ferme;
    }

  } else {
    return '';
  }
}
