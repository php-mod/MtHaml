<?php

namespace MtHaml\Filter;

use MtHaml\NodeVisitor\RendererAbstract as Renderer;
use MtHaml\Node\Filter;
use MtHaml\Node\Insert;

abstract class AbstractFilter implements FilterInterface
{
    public function isOptimizable(Renderer $renderer, Filter $node, $options)
    {
        foreach ($node->getChildren() as $line) {
            foreach ($line->getContent()->getChildren() as $child) {
                if ($child instanceof Insert) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function renderFilter(Renderer $renderer, Filter $node)
    {
        foreach($node->getChildren() as $child) {
            $child->accept($renderer);
        }
    }

    protected function getContent(Filter $node)
    {
        $content = '';
        foreach ($node->getChildren() as $line) {
            foreach ($line->getContent()->getChildren() as $child) {
                $content .= $child->getContent();
            }
            $content .= "\n";
        }

        return $content;
    }
}
