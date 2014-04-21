<?php

namespace MtHaml\Node;

use MtHaml\Exception;
use MtHaml\Helpers\Position;
use MtHaml\NodeVisitor\NodeVisitorInterface;

/**
 * InterpolatedString Node
 *
 * Represents a ruby-like interpolated string. Children are Text and Insert
 * nodes.
 */
class InterpolatedString extends NodeAbstract implements String, HasChildren
{
    /**
     * @var HasContent[]
     */
    protected $children = array();

    public function __construct(Position $position, array $children = array())
    {
        parent::__construct($position);
        foreach($children as $child)
        {
            $this->addChild($child);
        }
    }

    /**
     * @param HasContent $child Child
     * @throws \InvalidArgumentException
     */
    public function addChild(HasContent $child)
    {

        if (!$child instanceof Text && !$child instanceof Insert) {
            throw new \InvalidArgumentException(sprintf('Argument 1 passed to %s() must be an instance of MtHaml\Node\Text or MtHaml\Node\Insert, instance of %s given', __METHOD__, get_class($child)));
        }

        $this->children[] = $child;
    }

    /**
     * @return HasContent[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function getNodeName()
    {
        return 'interpolated string';
    }

    public function accept(NodeVisitorInterface $visitor)
    {
        if (false !== $visitor->enterInterpolatedString($this)) {

            if (false !== $visitor->enterInterpolatedStringChilds($this)) {
                foreach($this->getChildren() as $child) {
                    $child->accept($visitor);
                }
                $visitor->leaveInterpolatedStringChilds($this);
            }
            $visitor->leaveInterpolatedString($this);
        }
    }

    public function isConst()
    {
        foreach ($this->children as $child) {
            if (!$child->isConst()) {
                return false;
            }
        }

        return true;
    }
}
