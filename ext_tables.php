<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function($extKey)
	{



        //=================================================================
        // Add Tables
        //=================================================================
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
		    'tx_rkwtools_domain_model_tool'
        );





	},
	$_EXTKEY
);
