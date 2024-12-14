<?php

namespace Modules\DebtsAndReceivables\Features;

class Receivable
{
    public $name = 'receivable';

    public function resolve(): mixed
    {
        return true;
    }
}
