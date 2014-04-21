<?php

namespace MtHaml\Tests\Node;

use MtHaml\Helpers\Position;
use MtHaml\Node\Tag;

class NodeTest extends \PHPUnit_Framework_TestCase
{
    protected function createNodes()
    {
        $node = new Tag(new Position(), 'div', array());
        $this->assertFalse($node->hasChildren());

        $nodeB = new Tag(new Position(), 'div', array());
        $node->addChild($nodeB);

        $this->assertTrue($node->hasChildren());
        $this->assertSame($node, $nodeB->getParent());

        $nodeC = new Tag(new Position(), 'div', array());
        $node->addChild($nodeC);
        $this->assertSame(2, count($node->getChildren()));

        $this->assertSame($node, $nodeC->getParent());

        $this->assertSame(null, $nodeB->getPreviousSibling());
        $this->assertSame($nodeC, $nodeB->getNextSibling());

        $this->assertSame($nodeB, $nodeC->getPreviousSibling());
        $this->assertSame(null, $nodeC->getNextSibling());

        $nodeD = new Tag(new Position(), 'div', array());
        $node->addChild($nodeD);

        $this->assertSame($nodeB, $nodeC->getPreviousSibling());
        $this->assertSame($nodeD, $nodeC->getNextSibling());

        return compact('node', 'nodeB', 'nodeC', 'nodeD');
    }

    public function testAddingNodes()
    {
        $this->createNodes();
    }

    public function testDeletingFirstChild()
    {
        extract($this->createNodes());

        $node->removeChild($nodeB);
        $this->assertSame(2, count($node->getChildren()));

        $this->assertNull($nodeB->getParent());
        $this->assertNull($nodeB->getPreviousSibling());
        $this->assertNull($nodeB->getNextSibling());

        $this->assertSame(null, $nodeC->getPreviousSibling());
        $this->assertSame($nodeD, $nodeC->getNextSibling());

        $this->assertSame($nodeC, $nodeD->getPreviousSibling());
        $this->assertSame(null, $nodeD->getNextSibling());
    }

    public function testDeletingMiddleChild()
    {
        extract($this->createNodes());

        $node->removeChild($nodeC);
        $this->assertSame(2, count($node->getChildren()));

        $this->assertNull($nodeC->getParent());
        $this->assertNull($nodeC->getPreviousSibling());
        $this->assertNull($nodeC->getNextSibling());

        $this->assertSame(null, $nodeB->getPreviousSibling());
        $this->assertSame($nodeD, $nodeB->getNextSibling());

        $this->assertSame($nodeB, $nodeD->getPreviousSibling());
        $this->assertSame(null, $nodeD->getNextSibling());
    }

    public function testDeletingLastChild()
    {
        extract($this->createNodes());

        $node->removeChild($nodeD);
        $this->assertSame(2, count($node->getChildren()));

        $this->assertNull($nodeD->getParent());
        $this->assertNull($nodeD->getPreviousSibling());
        $this->assertNull($nodeD->getNextSibling());

        $this->assertSame(null, $nodeB->getPreviousSibling());
        $this->assertSame($nodeC, $nodeB->getNextSibling());

        $this->assertSame($nodeB, $nodeC->getPreviousSibling());
        $this->assertSame(null, $nodeC->getNextSibling());
    }

    public function testMovingNode()
    {
        extract($this->createNodes(), EXTR_PREFIX_ALL, 'src');
        extract($this->createNodes(), EXTR_PREFIX_ALL, 'dst');

        $dst_node->addChild($src_nodeC);

        $this->assertSame(2, count($src_node->getChildren()));
        $this->assertSame(4, count($dst_node->getChildren()));
    }
}

