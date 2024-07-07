<?php

declare(strict_types=1);

namespace ACA\GravityForms\Filtering\Table;

use AC\Registerable;
use ACP\Filtering\View\FilterContainer;

class Entry implements Registerable
{

    private $column_name;

    public function __construct(string $column_name)
    {
        $this->column_name = $column_name;
    }

    public function register(): void
    {
        add_action('gform_pre_entry_list', [$this, 'render'], 11);
    }

    public function render(): void
    {
        echo new FilterContainer($this->column_name);
    }

}