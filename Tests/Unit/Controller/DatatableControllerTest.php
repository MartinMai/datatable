<?php
namespace ElementareTeilchen\Datatable\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Franz Kugelmann <franz.kugelmann@elementare-teilchen.de>, elementare teilchen GmbH
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

/**
 * Test case for class ElementareTeilchen\Datatable\Controller\DatatableController.
 *
 * @author Franz Kugelmann <franz.kugelmann@elementare-teilchen.de>
 */
class DatatableControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \ElementareTeilchen\Datatable\Controller\DatatableController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('ElementareTeilchen\\Datatable\\Controller\\DatatableController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenDatatableToView()
	{
		$datatable = new \ElementareTeilchen\Datatable\Domain\Model\Datatable();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('datatable', $datatable);

		$this->subject->showAction($datatable);
	}
}
