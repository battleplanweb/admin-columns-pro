<?php

namespace ACA\Pods\Field;

use ACA\Pods\Editing;
use ACA\Pods\Field;
use ACA\Pods\Sorting;
use ACP\Search;

class Phone extends Field
{

    use Editing\DefaultServiceTrait;
    use Sorting\DefaultSortingTrait;

}