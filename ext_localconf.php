<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'ElementareTeilchen.' . $_EXTKEY,
	'Datatable',
	array(
		'Datatable' => 'show',
		
	),
	// non-cacheable actions
	array(
		'Datatable' => 'show',

	)
);
