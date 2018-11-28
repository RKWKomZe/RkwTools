<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'RKW.RkwTools',
			'Overview',
			[
				'Tool' => 'list'
			],
			// non-cacheable actions
			[
				'Tool' => 'list'
			]
		);

		// wizards
        /*
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
			'mod {
				wizards.newContentElement.wizardItems.plugins {
					elements {
						overview {
							icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_overview.svg
							title = LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkw_tools_domain_model_overview
							description = LLL:EXT:rkw_tools/Resources/Private/Language/locallang_db.xlf:tx_rkw_tools_domain_model_overview.description
							tt_content_defValues {
								CType = list
								list_type = rkwtools_overview
							}
						}
					}
					show = *
				}
		   }'
		);
        */

		// register the hooks
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extKey] = 'RKW\\RkwTools\\Hooks\\ToolHook';

		// caching
		if( !is_array($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] ) ) {
			$GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] = array();
		}
		// Hier ist der entscheidende Punkt! Es ist der Cache von Variablen gesetzt!
		if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] ) ) {
			$GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] = 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend';
		}

		if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['groups'] ) ) {
			$GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['groups'] = array('pages');
		}

		// set logger
		$GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwTools']['writerConfiguration'] = array(
			// configuration for WARNING severity, including all
			// levels with higher severity (ERROR, CRITICAL, EMERGENCY)
			\TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(
				// add a FileWriter
				'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
					// configuration for the writer
					'logFile' => 'typo3temp/logs/tx_rkwtools.log'
				)
			),
		);

		// Signal Slot for varnish-extension
		if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('varnish')) {
			/**
			 * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
			 */
			$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
			$signalSlotDispatcher->connect(
				'RKW\\RkwTools\\Hooks\\ToolHook',
				\RKW\RkwTools\Hooks\ToolHook::SIGNAL_CLEAR_PAGE_VARNISH,
				'RKW\\RkwTools\\Service\\VarnishService',
				'clearCacheOfToolsEvent'
			);
		}

	},
	$_EXTKEY
);
