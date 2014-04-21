<?php

namespace MtHaml\Node;

use MtHaml\NodeVisitor\NodeVisitorInterface;

interface Node {
    public function accept(NodeVisitorInterface $visitor);
}
