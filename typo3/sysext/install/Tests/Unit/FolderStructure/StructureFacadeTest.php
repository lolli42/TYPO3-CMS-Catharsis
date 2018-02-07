<?php
namespace TYPO3\CMS\Install\Tests\Unit\FolderStructure;

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

use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Install\FolderStructure\RootNode;
use TYPO3\CMS\Install\FolderStructure\StructureFacade;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class StructureFacadeTest extends UnitTestCase
{
    /**
     * @test
     */
    public function getStatusReturnsStatusOfStructureAndReturnsItsResult()
    {
        /** @var $facade StructureFacade|AccessibleObjectInterface|\PHPUnit_Framework_MockObject_MockObject */
        $facade = $this->getAccessibleMock(StructureFacade::class, ['dummy'], [], '', false);
        $root = $this->createMock(RootNode::class);
        $root->expects($this->once())->method('getStatus')->will($this->returnValue([]));
        $facade->_set('structure', $root);
        $status = $facade->getStatus();
        $this->assertInstanceOf(FlashMessageQueue::class, $status);
    }

    /**
     * @test
     */
    public function fixCallsFixOfStructureAndReturnsItsResult()
    {
        /** @var $facade StructureFacade|AccessibleObjectInterface|\PHPUnit_Framework_MockObject_MockObject */
        $facade = $this->getAccessibleMock(StructureFacade::class, ['dummy'], [], '', false);
        $root = $this->createMock(RootNode::class);
        $root->expects($this->once())->method('fix')->will($this->returnValue([]));
        $facade->_set('structure', $root);
        $status = $facade->fix();
        $this->assertInstanceOf(FlashMessageQueue::class, $status);
    }
}
