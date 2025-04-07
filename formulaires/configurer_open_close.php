<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_configurer_open_close_saisies_dist() {
	include_spip('inc/config');
	$config = lire_config('open_close');

	return [
		[
			'saisie' => 'fieldset',
			'options' => [
				'nom' => 'horaires_resume_fs',
				'label' => _T('open_close:config_titre_horaires_resume'),
				'tagfield' => '<legend>',
			],
			'saisies' => [
				[
					'saisie' => 'explication',
					'options' => [
						'nom' => 'info_horaires_quotidiens',
						'texte' => _T('open_close:config_info_horaires_resume'),
					],
				],
				[
					'saisie' => 'textarea',
					'options' => [
						'nom' => 'horaires_resume',
						'defaut' => $config['horaires_resume'],
						'rows' => 8,
						'label' => _T('open_close:config_label_horaires_resume'),
						'obligatoire' => 'oui',
					],
				],
			],
		],
		[
			'saisie' => 'fieldset',
			'options' => [
				'nom' => 'horaires_quotidiens_fs',
				'label' => _T('open_close:config_titre_horaires_quotidiens'),
				'tagfield' => '<legend>',
			],
			'saisies' => [
				[
					'saisie' => 'input',
					'options' => [
						'nom' => 'jour_1',
						'label' => _T('open_close:config_label_jour1'),
						'defaut' => $config['jour_1'],
					],
				],
				[
					'saisie' => 'input',
					'options' => [
						'nom' => 'jour_2',
						'label' => _T('open_close:config_label_jour2'),
						'defaut' => $config['jour_2'],
					],
				],
				[
					'saisie' => 'input',
					'options' => [
						'nom' => 'jour_3',
						'label' => _T('open_close:config_label_jour3'),
						'defaut' => $config['jour_3'],
					],
				],
				[
					'saisie' => 'input',
					'options' => [
						'nom' => 'jour_4',
						'label' => _T('open_close:config_label_jour4'),
						'defaut' => $config['jour_4'],
					],
				],
				[
					'saisie' => 'input',
					'options' => [
						'nom' => 'jour_5',
						'label' => _T('open_close:config_label_jour5'),
						'defaut' => $config['jour_5'],
					],
				],
				[
					'saisie' => 'input',
					'options' => [
						'nom' => 'jour_6',
						'label' => _T('open_close:config_label_jour6'),
						'defaut' => $config['jour_6'],
					],
				],
				[
					'saisie' => 'input',
					'options' => [
						'nom' => 'jour_7',
						'label' => _T('open_close:config_label_jour7'),
						'defaut' => $config['jour_7'],
					],
				],
			],
		],
		[
			'saisie' => 'fieldset',
			'options' => [
				'nom' => 'vacances_fs',
				'label' => _T('open_close:config_titre_vacances'),
				'tagfield' => '<legend>',
			],
			'saisies' => [
				[
					'saisie' => 'explication',
					'options' => [
						'nom' => 'info_vacances',
						'texte' => _T('open_close:config_info_vacances'),
					],
				],
				[
					'saisie' => 'date',
					'options' => [
						'nom' => 'vacances_debut',
						'label' => _T('open_close:config_label_vacances_debut'),
						'defaut' => $config['vacances_debut'],
					],
					'verifier' => [
						'type' => 'date',
					],
				],
				[
					'saisie' => 'date',
					'options' => [
						'nom' => 'vacances_fin',
						'label' => _T('open_close:config_label_vacances_fin'),
						'defaut' => $config['vacances_fin'],
					],
					'verifier' => [
						'type' => 'comparaison_date',
						'options' => [
							'champ' => 'vacances_debut',
						],
					],
				],
			],
		],
	];
}
