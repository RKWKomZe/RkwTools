<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{

        //=================================================================
        // Register Plugin
        //=================================================================
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
			'RKW.RkwTools',
			'Overview',
			'RKW Tools: Übersicht'
		);

        //=================================================================
        // Add Tables
        //=================================================================
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
		    'tx_rkwtools_domain_model_tool'
        );

        //=================================================================
        // Add TypoScript
        //=================================================================
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript',
            'RKW Tools'
        );

		//=================================================================
		// Add Flexform
		//=================================================================
		$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));
		$pluginName = strtolower('Overview');
		$pluginSignature = $extensionName . '_' . $pluginName;
		$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
		$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
		    $pluginSignature,
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/Overview.xml'
        );

	},
	$_EXTKEY
);
