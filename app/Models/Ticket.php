<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public $table = 'tickets';
    protected $fillable = ['customer_id', 'topic', 'description', 'status', 'answered_date', 'answered_by'];
}
