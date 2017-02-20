<?php
namespace ElementareTeilchen\Datatable\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Franz Kugelmann <franz.kugelmann@elementare-teilchen.de>, elementare teilchen GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * DatatableController
 */
class DatatableController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * datatableRepository
     *
     * @var \ElementareTeilchen\Datatable\Domain\Repository\DatatableRepository
     * @inject
     */
    protected $datatableRepository = NULL;
    
    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        $flexformSettings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
        );
        #\TYPO3\CMS\Core\Utility\DebugUtility::debug($flexformSettings);

        if (filter_var($flexformSettings['sourceUrl'], FILTER_VALIDATE_URL)) {
            $jsonUrl = $flexformSettings['sourceUrl'];
        } else {
            $jsonUrl = GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST') . '/typo3conf/ext/datatable/Resources/Public/Testdata/simple.json';
            #$jsonUrl = GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST') . '/typo3conf/ext/datatable/Resources/Public/Testdata/complex.json';

        }
        $dataArrayOriginal = $this->datatableRepository->getJsonDataFromUrl($jsonUrl);

        if (empty($flexformSettings['columns'])) {
            $dataArray = $dataArrayOriginal;
        } else {
            $dataArray = [];
            $columnSettings = [];
            // rearrange flexform data into array
            foreach (explode("\n",$flexformSettings['columns']) as $singleColumnSetting) {
                list($columnName, $columnFilter) = array_map('trim', explode('|', $singleColumnSetting));
                $columnSettings[$columnName] = ['filter' => $columnFilter];
            }

            // filter columns by flexform config
            foreach ($dataArrayOriginal as $dataRowOriginal) {
                $dataArray[] = array_intersect_key($dataRowOriginal, $columnSettings);
            }

            // apply default sorting
            if (!empty($flexformSettings['sorting'])) {
                list($sortingColumn, $sortingDirection) = array_map('trim', explode(' ', $flexformSettings['sorting']));
                if (!empty($sortingColumn)) {
                    usort($dataArray, datatableSorter($sortingColumn));
                    if ($sortingDirection == 'desc') {
                        $dataArray = array_reverse($dataArray);
                    }
                }
            }
        }

        $this->view->assign('activateDatatable', $flexformSettings['activateDatatable']);
        $this->view->assign('columnSettings', $columnSettings);
        $this->view->assign('datatable', $dataArray);
    }

}

function datatableSorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
}