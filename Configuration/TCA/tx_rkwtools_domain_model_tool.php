<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => true,
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'name,description,image,link,sys_category,projects,department',
		'iconfile' => 'EXT:rkw_tools/Resources/Public/Icons/tx_rkwtools_domain_model_tool.gif',
		'dividers2tabs' => TRUE,
        //@todo does this mean 'sys_category'?
		//'requestUpdate' => 'sys_category_parent'
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, description, image, --div--;LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.tab.reference, link, --div--;LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.tab.assignment, type, department, sys_category, projects, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
	],
	'columns' => [
        'crdate' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.crdate',
            'config' => [
                'type' => 'none',
                'format' => 'date',
                'eval' => 'date',
            ],
        ],
        'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_rkwtools_domain_model_tool',
				'foreign_table_where' => 'AND tx_rkwtools_domain_model_tool.pid=###CURRENT_PID### AND tx_rkwtools_domain_model_tool.sys_language_uid IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		't3ver_label' => [
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			],
		],
		'hidden' => [
			'exclude' => true,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
					]
				],
			],
		],
		'starttime' => [
			'exclude' => true,
			//'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 13,
				'eval' => 'datetime',
				'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
			]
		],
		'endtime' => [
			'exclude' => true,
			//'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
                'renderType' => 'inputDateTime',
				'size' => 13,
				'eval' => 'datetime',
				'default' => 0,
				'range' => [
					'upper' => mktime(0, 0, 0, 1, 1, 2038)
				],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
			],
		],
		'name' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			],
		],
		'description' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.description',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim, required'
			]
		],
        'type' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwtools_domain_model_tooltype',
                'foreign_table_where' => 'AND tx_rkwtools_domain_model_tooltype.deleted = 0 AND tx_rkwtools_domain_model_tooltype.hidden = 0 ORDER BY tx_rkwtools_domain_model_tooltype.name',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
                'default' => 0,
                'items' => [
                    ['---', 0],
                ],
            ],
        ],
		'image' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'image',
				[
					'maxitems' => 1,
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                            ],
                        ],
                    ],
				],
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		],
		'link' => [
			'label' => 'LLL:EXT:cms/locallang_ttc.xlf:header_link',
			'exclude' => false,
			'config' => [
				'type' => 'input',
                'renderType' => 'inputLink',
			]
		],
		'sys_category' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.sys_category',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectTree',
				'foreign_table' => 'sys_category',
				'foreign_table_where' => ' AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(sys_category.parent,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND sys_category.sys_language_uid IN (-1, 0) AND deleted = 0 ORDER BY sys_category.title ASC',
				'minitems' => 0,
				'maxitems' => 9999,
				'multiple' => 1,
				'treeConfig' => [
					'parentField' =>'parent',
					'appearance' => [
						'expandAll' => false,
						'showHeader' => true,
					],
				],
			],
		],
		'projects' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.projects',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_rkwprojects_domain_model_projects',
				'foreign_table_where' => 'AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(tx_rkwprojects_domain_model_projects.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND tx_rkwprojects_domain_model_projects.sys_language_uid = ###REC_FIELD_sys_language_uid### AND tx_rkwprojects_domain_model_projects.deleted = 0 AND tx_rkwprojects_domain_model_projects.hidden = 0 ORDER BY tx_rkwprojects_domain_model_projects.pid ASC, tx_rkwprojects_domain_model_projects.status ASC, tx_rkwprojects_domain_model_projects.short_name ASC, tx_rkwprojects_domain_model_projects.name ASC',
                'itemsProcFunc' => 'RKW\RkwProjects\TCA\OptionLabels->getExtendedProjectNamesByUid',
                'minitems' => 0,
				'maxitems' => 9999,
				'appearance' => [
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				],
			],
		],
		'department' => [
			'exclude' => false,
			'label' => 'LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkwtools_domain_model_tool.department',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_rkwbasics_domain_model_department',
				'foreign_table_where' => 'AND tx_rkwbasics_domain_model_department.sys_language_uid = ###REC_FIELD_sys_language_uid### AND tx_rkwbasics_domain_model_department.deleted = 0 AND tx_rkwbasics_domain_model_department.hidden = 0 ORDER BY tx_rkwbasics_domain_model_department.name',
				'minitems' => 1,
				'maxitems' => 1,
				'appearance' => [
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				],
                'default' => 0,
                'items' => [
                    ['---', 0],
                ],
			],
		],
	],
];
