<?php

namespace Sandstorm\CrudForms\Tests\Functional;

/**
 * Functional tests for the ActionController
 */
class AddressControllerTest extends \Neos\Flow\Tests\FunctionalTestCase
{

    /**
     * @var boolean
     */
    static protected $testablePersistenceEnabled = TRUE;

    /**
     * Additional setup: Routes
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->registerRoute('address', 'test/address(/{@action})', array(
            '@package' => 'Sandstorm.CrudForms',
            '@subpackage' => 'Tests\Functional\Fixtures',
            '@controller' => 'Address',
            '@action' => 'index',
            '@format' => 'html'
        ));
    }

    /**
     * Checks if a simple request is handled correctly. The route matching the
     * specified URI defines a default action "first" which results in firstAction
     * being called.
     *
     * @test
     */
    public function defaultActionSpecifiedInrouteIsCalledAndResponseIsReturned()
    {
        $this->expectException(\Neos\Flow\Http\Client\InfiniteRedirectionException::class);
        $response = $this->browser->request('http://localhost/test/address/index');
        self::assertEquals('First action was called', $response->getBody()->getContents());
        self::assertEquals('200 OK', $response->getReasonPhrase());
    }
}
