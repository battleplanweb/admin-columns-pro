<?php

declare(strict_types=1);

namespace ACP\Nonce;

use AC\Form\Nonce;

class ImportFileNonce extends Nonce
{

    public function __construct()
    {
        parent::__construct('acp-import-file', '_acnonce');
    }
}