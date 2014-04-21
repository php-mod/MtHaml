<?php

namespace MtHaml\Node;

use MtHaml\NodeVisitor\NodeVisitorInterface;

abstract class NodeAbstract implements Node
{
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

    public function __construct(array $position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getLineno()
    {
        return $this->position['lineno'];
    }

    public function getColumn()
    {
        return $this->position['column'];
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

