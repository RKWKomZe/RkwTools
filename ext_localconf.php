<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{

        //=================================================================
        // Configure Plugin
        //=================================================================
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


        //=================================================================
        // Register Hooks
        //=================================================================
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extKey] = \RKW\RkwTools\Hooks\ToolHook::class;

        //=================================================================
        // Register Signal Slot for varnish-extension
        //=================================================================
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('varnish')) {
            /**
             * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
             */
            $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
            $signalSlotDispatcher->connect(
                \RKW\RkwTools\Hooks\ToolHook::class,
                \RKW\RkwTools\Hooks\ToolHook::SIGNAL_CLEAR_PAGE_VARNISH,
                \RKW\RkwTools\Service\VarnishService::class,
                'clearCacheOfToolsEvent'
            );
        }

        //=================================================================
        // Register Caching
        //=================================================================
		if( !is_array($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] ) ) {
			$GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] = array();
		}
		// Hier ist der entscheidende Punkt! Es ist der Cache von Variablen gesetzt!
		if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] ) ) {
			$GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] = TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class;
		}

		if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['groups'] ) ) {
			$GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['groups'] = array('pages');
		}

        //=================================================================
        // Register Logger
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwTools']['writerConfiguration'] = array(
            // configuration for WARNING severity, including all
            // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
            \TYPO3\CMS\Core\Log\LogLevel::WARNING => array(
                // add a FileWriter
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
                    // configuration for the writer
                    'logFile' => \TYPO3\CMS\Core\Core\Environment::getVarPath()  . '/log/tx_rkwtools.log'
                )
            ),
        );

	},
	'rkw_tools'
);
