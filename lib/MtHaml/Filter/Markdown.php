<?php

namespace MtHaml\Filter;

use Michelf\Markdown as MarkdownTransformer;
use MtHaml\Helpers\Position;
use MtHaml\Node\InterpolatedString;
use MtHaml\NodeVisitor\RendererAbstract as Renderer;
use MtHaml\Node\Filter;
use MtHaml\Node\Text;

class Markdown extends AbstractFilter
{
    private $markdown;
    private $forceOptimization;

    public function __construct(MarkdownTransformer $markdown, $forceOptimization = false)
    {
        $this->markdown = $markdown;
        $this->forceOptimization = $forceOptimization;
    }

    public function isOptimizable(Renderer $renderer, Filter $node, $options)
    {
        if ($this->forceOptimization) {
            return true;
        }

        return parent::isOptimizable($renderer, $node, $options);
    }

    public function optimize(Renderer $renderer, Filter $node, $options)
    {
        $inserts = array();
        $content = '';
        foreach ($node->getChildren() as $child) {
            foreach ($child->getContent()->getChildren() as $item) {
                if ($item instanceof Text) {
                    $content .= $item->getContent();
                } else {
                    $hash = md5(mt_rand());
                    $inserts[$hash] = $item;
                    $content .= $hash;
                }
            }
            $content .= "\n";
        }

        $string = new InterpolatedString(new Position());
        $result = $this->markdown->transform($content);
        foreach ($inserts as $hash => $insert) {
            $parts = explode($hash, $result, 2);
            $string->addChild(new Text(new Position(), $parts[0]));
            $string->addChild($insert);
            $result = $parts[1];
        }
        $string->addChild(new Text(new Position(), $result));
        $string->accept($renderer);
    }

    public function filter($content, array $context, $options)
    {
        return $this->markdown->transform($content);
    }
}
