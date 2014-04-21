<?php

namespace MtHaml\Node;

use MtHaml\Helpers\Position;

class InterpolatedStringStatement extends Statement
{
    /**
     * @var InterpolatedString
     */
    protected $content;

    public function __construct(Position $position, InterpolatedString $content)
    {
        parent::__construct($position, $content);
    }

    public function getContent()
    {
        return $this->content;
    }

}
