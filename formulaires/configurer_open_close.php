<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_configurer_open_close_saisies_dist() {
  include_spip('inc/config');
  $config = lire_config('open_close');

  return array(
    array(
      'saisie' => 'fieldset',
      'options' => array(
        'nom'      => 'horaires_resume_fs',
        'label'    => _T('open_close:config_titre_horaires_resume'),
        'tagfield' => '<legend>'
      ),
      'saisies' => array(
        array(
          'saisie' => 'explication',
          'options' => array(
            'nom'   => 'info_horaires_quotidiens',
            'texte' => _T('open_close:config_info_horaires_resume')
          )
        ),
        array(
          'saisie' => 'textarea',
          'options' => array(
            'nom'         => 'horaires_resume',
            'defaut'      => $config['horaires_resume'],
            'rows'        => 8,
            'label'       => _T('open_close:config_label_horaires_resume'),
            'obligatoire' => 'oui'
          )
        )
      )
    ),
    array(
      'saisie' => 'fieldset',
      'options' => array(
        'nom'      => 'horaires_quotidiens_fs',
        'label'    => _T('open_close:config_titre_horaires_quotidiens'),
        'tagfield' => '<legend>'
      ),
      'saisies' => array(
        array(
          'saisie' => 'input',
          'options' => array(
            'nom'    => 'jour_1',
            'label'  => _T('open_close:config_label_jour1'),
            'defaut' => $config['jour_1']
          )
        ),
        array(
          'saisie' => 'input',
          'options' => array(
            'nom'    => 'jour_2',
            'label'  => _T('open_close:config_label_jour2'),
            'defaut' => $config['jour_2']
          )
        ),
        array(
          'saisie' => 'input',
          'options' => array(
            'nom'    => 'jour_3',
            'label'  => _T('open_close:config_label_jour3'),
            'defaut' => $config['jour_3']
          )
        ),
        array(
          'saisie' => 'input',
          'options' => array(
            'nom'    => 'jour_4',
            'label'  => _T('open_close:config_label_jour4'),
            'defaut' => $config['jour_4']
          )
        ),
        array(
          'saisie' => 'input',
          'options' => array(
            'nom'    => 'jour_5',
            'label'  => _T('open_close:config_label_jour5'),
            'defaut' => $config['jour_5']
          )
        ),
        array(
          'saisie' => 'input',
          'options' => array(
            'nom'    => 'jour_6',
            'label'  => _T('open_close:config_label_jour6'),
            'defaut' => $config['jour_6']
          )
        ),
        array(
          'saisie'  => 'input',
          'options' => array(
            'nom'    => 'jour_7',
            'label'  => _T('open_close:config_label_jour7'),
            'defaut' => $config['jour_7']
          )
        )
      )
    ),
    array(
      'saisie'  => 'fieldset',
      'options' => array(
        'nom'      => 'vacances_fs',
        'label'    => _T('open_close:config_titre_vacances'),
        'tagfield' => '<legend>'
      ),
      'saisies' => array(
        array(
          'saisie' => 'explication',
          'options' => array(
            'nom'   => 'info_vacances',
            'texte' => _T('open_close:config_info_vacances')
          )
        ),
        array(
          'saisie'  => 'date',
          'options' => array(
            'nom'    => 'vacances_debut',
            'label'  => _T('open_close:config_label_vacances_debut'),
            'defaut' => $config['vacances_debut']
          ),
          'verifier' => array(
            'type' => 'date'
          )
        ),
        array(
          'saisie'  => 'date',
          'options' => array(
            'nom'    => 'vacances_fin',
            'label'  => _T('open_close:config_label_vacances_fin'),
            'defaut' => $config['vacances_fin']
          ),
          'verifier' => array(
            'type' => 'comparaison_date',
            'options' => array(
              'champ' => 'vacances_debut'
            )
          )
        )
      )
    )
  );
}
