<?php

namespace MtHaml\Helpers;

class Position
{

    /**
     * @var int
     */
    protected $lineNumber;

    /**
     * @var int
     */
    protected $column;

    public function __construct($lineNumber = 0, $column = 0)
    {
        $this->lineNumber = $lineNumber;
        $this->column = $column;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @return int
     */
    public function getColumn()
    {
        return $this->column;
    }
}
