<?php
namespace ElementareTeilchen\Datatable\Domain\Repository;


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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * The repository for Datatables
 */
class DatatableRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    public function getJsonDataFromUrl($jsonUrl) {
        $services = ExtensionManagementUtility::findService('connector', 'json');
        if ($services === FALSE) {
            // Issue an error
        } else {
            $connector = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('connector', 'json');
        }

        $parameters = array(
            'uri' => $jsonUrl,
            'encoding' => 'utf-8',
        );

        return $connector->fetchArray($parameters);
    }
}