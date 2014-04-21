<?php

namespace MtHaml\Filter;

use MtHaml\NodeVisitor\RendererAbstract as Renderer;
use MtHaml\Node\Filter;
use MtHaml\Node\EscapableAbstract;

class Escaped extends Plain
{
    public function optimize(Renderer $renderer, Filter $node, $options)
    {
        foreach ($node->getChildren() as $child) {
            foreach ($child->getContent()->getChildren() as $item) {
                if ($item instanceof EscapableAbstract) {
                    $item->getEscaping()->setEnabled(true);
                }
            }
            $child->accept($renderer);
        }
    }
}
