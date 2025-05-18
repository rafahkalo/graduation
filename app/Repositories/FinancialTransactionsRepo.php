<?php

namespace App\Repositories;

use App\Models\FinancialTransactions;

class FinancialTransactionsRepo extends CoreRepository
{

    public function __construct(FinancialTransactions $model)
    {
        parent::__construct($model);
    }
}
