<?php
namespace Sandstorm\CrudForms\Tests\Functional;

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Neos\Flow\Http\Request;
use Neos\Flow\Http\Uri;

/**
 * Functional tests for the ActionController
 */
class AddressControllerTest extends \Neos\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = TRUE;

	/**
	 * Additional setup: Routes
	 */
	public function setUp() {
		parent::setUp();

		$this->registerRoute('address', 'test/address(/{@action})', array(
			'@package' => 'Sandstorm.CrudForms',
			'@subpackage' => 'Tests\Functional\Fixtures',
			'@controller' => 'Address',
			'@action' => 'index',
			'@format' =>'html'
		));
	}

	/**
	 * Checks if a simple request is handled correctly. The route matching the
	 * specified URI defines a default action "first" which results in firstAction
	 * being called.
	 *
	 * @test
	 */
	public function defaultActionSpecifiedInrouteIsCalledAndResponseIsReturned() {
		$response = $this->browser->request('http://localhost/test/address/index');
		$this->assertEquals('First action was called', $response->getContent());
		$this->assertEquals('200 OK', $response->getStatus());
	}
}
