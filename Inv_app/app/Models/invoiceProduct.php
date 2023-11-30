<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoiceProduct extends Model
{
    protected $fillable=['invoice_id','product_id','user_id','qty','sale_price'];
}
