<?php

namespace MtHaml\Node;

use MtHaml\Helpers\Position;
use MtHaml\NodeVisitor\NodeVisitorInterface;

class Filter extends NodeAbstract implements HasChildren
{
    /**
     * @var InterpolatedStringStatement[]
     */
    private $children = array();
    private $filter;

    public function __construct(Position $position, $filter)
    {
        parent::__construct($position);
        $this->filter = $filter;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function addChild(InterpolatedStringStatement $node)
    {
        $this->children[] = $node;
    }

    /**
     * @return InterpolatedStringStatement[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function getNodeName()
    {
        return 'filter';
    }

    public function accept(NodeVisitorInterface $visitor)
    {
        if (false !== $visitor->enterFilter($this)) {
            
            if (false !== $visitor->enterFilterChilds($this)) {
                foreach($this->getChildren() as $child) {
                    $child->accept($visitor);
                }
            }
            $visitor->leaveFilterChilds($this);
        }
        $visitor->leaveFilter($this);
    }
}

