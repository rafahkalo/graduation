<?php

namespace App\Repositories;

use App\Models\FinancialTransaction;

class FinancialTransactionsRepo extends CoreRepository
{

    public function __construct(FinancialTransaction $model)
    {
        parent::__construct($model);
    }
}
