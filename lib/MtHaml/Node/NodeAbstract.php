<?php

namespace MtHaml\Node;

use MtHaml\Helpers\Position;
use MtHaml\NodeVisitor\NodeVisitorInterface;

abstract class NodeAbstract implements Node
{
    /**
     * @var Position
     */
    private $position;

    /**
     * @var NestAbstract
     */
    private $parent;

    /**
     * @var NodeAbstract
     */
    private $nextSibling;

    /**
     * @var NodeAbstract
     */
    private $previousSibling;

    /**
     * @param Position $position
     */
    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->position->getLineNumber();
    }

    /**
     * @return int
     */
    public function getColumn()
    {
        return $this->position->getColumn();
    }

    protected function setParent(NestAbstract $parent = null)
    {
        $this->parent = $parent;
    }

    public function hasParent()
    {
        return null !== $this->parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    abstract public function getNodeName();

    abstract public function accept(NodeVisitorInterface $visitor);

    protected function setNextSibling(NodeAbstract $node = null)
    {
        $this->nextSibling = $node;
    }

    public function getNextSibling()
    {
        return $this->nextSibling;
    }

    protected function setPreviousSibling(NodeAbstract $node = null)
    {
        $this->previousSibling = $node;
    }

    public function getPreviousSibling()
    {
        return $this->previousSibling;
    }

    public function isConst()
    {
        return false;
    }
}

