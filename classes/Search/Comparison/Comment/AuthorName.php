<?php

namespace ACP\Search\Comparison\Comment;

use ACP\Helper\Select;
use ACP\Search\Operators;

class AuthorName extends Field
{

    public function __construct()
    {
        $operators = new Operators([
            Operators::EQ,
            Operators::CONTAINS,
            Operators::NOT_CONTAINS,
            Operators::BEGINS_WITH,
            Operators::ENDS_WITH,
        ]);

        parent::__construct($operators);
    }

    protected function get_field(): string
    {
        return 'comment_author';
    }

}