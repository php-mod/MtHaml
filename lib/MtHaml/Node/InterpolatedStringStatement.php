<?php

namespace MtHaml\Node;

class InterpolatedStringStatement extends Statement
{
    /**
     * @var InterpolatedString
     */
    protected $content;

    public function __construct(array $position, InterpolatedString $content)
    {
        parent::__construct($position, $content);
    }

    public function getContent()
    {
        return $this->content;
    }

}
