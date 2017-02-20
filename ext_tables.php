<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'ElementareTeilchen.' . $_EXTKEY,
	'Datatable',
	'Datatable'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Datatable');

// there is no table right now
#\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_datatable_domain_model_datatable', 'EXT:datatable/Resources/Private/Language/locallang_csh_tx_datatable_domain_model_datatable.xlf');
#\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_datatable_domain_model_datatable');
