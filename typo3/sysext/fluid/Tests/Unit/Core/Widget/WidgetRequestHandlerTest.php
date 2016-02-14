<?php
namespace TYPO3\CMS\Fluid\Tests\Unit\Core\Widget;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Extbase\Mvc\Dispatcher;
use TYPO3\CMS\Extbase\Mvc\Web\Request;
use TYPO3\CMS\Extbase\Mvc\Web\Response;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Fluid\Core\Widget\WidgetRequestBuilder;
use TYPO3\CMS\Fluid\Core\Widget\WidgetRequestHandler;

/**
 * Test case
 */
class WidgetRequestHandlerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \TYPO3\CMS\Fluid\Core\Widget\WidgetRequestHandler
     */
    protected $widgetRequestHandler;

    /**
     * Set up
     */
    protected function setUp()
    {
        $this->widgetRequestHandler = $this->getAccessibleMock(\TYPO3\CMS\Fluid\Core\Widget\WidgetRequestHandler::class, array('dummy'), array(), '', false);
    }

    /**
     * @test
     */
    public function canHandleRequestReturnsTrueIfCorrectGetParameterIsSet()
    {
        $_GET['fluid-widget-id'] = 123;
        $this->assertTrue($this->widgetRequestHandler->canHandleRequest());
    }

    /**
     * @test
     */
    public function canHandleRequestReturnsFalsefGetParameterIsNotSet()
    {
        $_GET['some-other-id'] = 123;
        $this->assertFalse($this->widgetRequestHandler->canHandleRequest());
    }

    /**
     * @test
     */
    public function priorityIsHigherThanDefaultRequestHandler()
    {
        $defaultWebRequestHandler = $this->getMock(\TYPO3\CMS\Extbase\Mvc\Web\AbstractRequestHandler::class, array('handleRequest'), array(), '', false);
        $this->assertTrue($this->widgetRequestHandler->getPriority() > $defaultWebRequestHandler->getPriority());
    }

    /**
     * @test
     */
    public function handleRequestCallsExpectedMethods()
    {
        $handler = new WidgetRequestHandler();
        $request = $this->getMock(Request::class);
        $requestBuilder = $this->getMock(WidgetRequestBuilder::class, array('build'));
        $requestBuilder->expects($this->once())->method('build')->willReturn($request);
        $objectManager = $this->getMock(ObjectManagerInterface::class);
        $objectManager->expects($this->once())->method('get')->willReturn($this->getMock(Response::class));
        $requestDispatcher = $this->getMock(Dispatcher::class, array('dispatch'), array(), '', false);
        $requestDispatcher->expects($this->once())->method('dispatch')->with($request);
        $this->inject($handler, 'requestBuilder', $requestBuilder);
        $this->inject($handler, 'dispatcher', $requestDispatcher);
        $this->inject($handler, 'objectManager', $objectManager);
        $handler->handleRequest();
    }
}
