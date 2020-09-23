<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tooltype',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => false,
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
		],
		'searchFields' => 'name,description,image,link,sys_category,projects,department',
		'iconfile' => 'EXT:rkw_tools/Resources/Public/Icons/tx_rkwtools_domain_model_tooltype.gif',
		'dividers2tabs' => TRUE,
        //@toDo: does this mean 'sys_category' of the tool-TCA??
		//'requestUpdate' => 'sys_category_parent'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, description',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, description'],
	],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_rkwtools_domain_model_tooltype',
				'foreign_table_where' => 'AND tx_rkwtools_domain_model_tooltype.pid=###CURRENT_PID### AND tx_rkwtools_domain_model_tooltype.sys_language_uid IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		'hidden' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
					]
				],
			],
		],
		'name' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tooltype.name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			],
		],
		'description' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tooltype.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
	],
];
