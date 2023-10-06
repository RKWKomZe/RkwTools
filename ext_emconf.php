<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "rkw_tools"
 *
 * Auto generated by Extension Builder 2017-12-08
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'RKW Tools',
	'description' => '',
	'category' => 'plugin',
	'author' => 'Maximilian Fäßler',
	'author_email' => 'maximilian@faesslerweb.de',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '1',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '9.5.9',
	'constraints' => [
		'depends' => [
            'typo3' => '9.5.0-10.4.99',
            'accelerator' => '9.5.2-10.4.99',
            'rkw_basics' => '9.5.0-10.4.99',
			'rkw_projects' => '9.5.0-10.4.99',
		],
		'conflicts' => [],
		'suggests' => [],
	],
];
