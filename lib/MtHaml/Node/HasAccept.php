<?php

namespace MtHaml\Node;

use MtHaml\NodeVisitor\NodeVisitorInterface;

interface HasAccept
{
    public function accept(NodeVisitorInterface $visitor);
} 