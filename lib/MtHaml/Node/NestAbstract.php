<?php

namespace MtHaml\Node;

use MtHaml\Exception;
use MtHaml\NodeVisitor\NodeVisitorInterface;

abstract class NestAbstract extends NodeAbstract implements NestInterface
{
    private $content;
    private $children = array();

    public function addChild(NodeAbstract $node)
    {
        if (!$this->allowsNestingAndContent() && $this->hasContent()) {
            throw new Exception('A node cannot have both content and nested nodes');
        }
        if (null !== $parent = $node->getParent()) {
            $parent->removeChild($node);
        }

        $prev = end($this->children) ?: null;

        $this->children[] = $node;
        $node->setParent($this);

        if ($prev) {
            $prev->setNextSibling($node);
        }
        $node->setPreviousSibling($prev);
        $node->setNextSibling(null);
    }

    public function removeChild(NodeAbstract $node)
    {
        if (false === $key = array_search($node, $this->children, true)) {
            return;
        }

        unset($this->children[$key]);

        $prev = $node->getPreviousSibling();
        $next = $node->getNextSibling();

        if ($prev) {
            $prev->setNextSibling($next);
        }
        if ($next) {
            $next->setPreviousSibling($prev);
        }

        $node->setParent(null);
        $node->setPreviousSibling(null);
        $node->setNextSibling(null);
    }

    public function hasChilds()
    {
        return 0 < count($this->children);
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getFirstChild()
    {
        if (false !== $child = reset($this->children)) {
            return $child;
        }
    }

    public function getLastChild()
    {
        if (false !== $child = end($this->children)) {
            return $child;
        }
    }

    public function setContent($content)
    {
        if (!$this->allowsNestingAndContent() && $this->hasChilds()) {
            throw new Exception('A node cannot have both content and nested nodes');
        }
        $this->content = $content;
    }

    public function hasContent()
    {
        return null !== $this->content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function allowsNestingAndContent()
    {
        return false;
    }

    public function visitContent(NodeVisitorInterface $visitor)
    {
        if ($this->hasContent()) {
            $this->getContent()->accept($visitor);
        }
    }

    public function visitChilds(NodeVisitorInterface $visitor)
    {
        foreach($this->getChildren() as $child) {
            $child->accept($visitor);
        }
    }
}

