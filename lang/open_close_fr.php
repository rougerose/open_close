<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']]  = array(
  // C
  'config_info_horaires_quotidiens'  => "Trois types de saisies sont possibles :\n
    1- pour des horaires sans interruption : <code>HH:mm-HH:mm</code><br> Exemple : <code>09:00-18:00</code>\n
    2- pour des horaires avec interruption : <code>HH:mm-HH:mm, HH:mm-HH:mm</code><br> Exemple : <code>09:00-13:00, 14:00-19:00</code>\n
    3- pour les jours de fermeture : le champs doit rester vide.",
  'config_info_horaires_resume'      => 'Les horaires saisis ci-dessous seront affichés tels quels sur les pages publiques du site',
  'config_info_vacances' => 'Les prochaines dates de vacances. La saisie est de type <code>JJ/MM/AAAA</code>',
  'config_label_jour1'               => 'Lundi',
  'config_label_jour2'               => 'Mardi',
  'config_label_jour3'               => 'Mercredi',
  'config_label_jour4'               => 'Jeudi',
  'config_label_jour5'               => 'Vendredi',
  'config_label_jour6'               => 'Samedi',
  'config_label_jour7'               => 'Dimanche',
  'config_titre_horaires_quotidiens' => 'Horaires quotidiens',
  'config_titre_horaires_resume'     => 'Horaires en résumé',
  'config_titre_page'                => 'Saisir les horaires d\'ouverture'
);
