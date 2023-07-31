<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HAsFactory;
    protected $table = 'invoices';
    protected $fillable = [
        'supplier_name', 'term_line_id', 'document', 'due_days',
        'expense_code', 'currency', 'amount_type', 'percentage_to_pay',
        'payment_method', 'note',
    ];

}
