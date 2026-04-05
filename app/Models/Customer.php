<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * @package App\Models
 * @property int    $id
 * @property string $name
 * @property string $email
 * @property string $phone
 */
class Customer extends Model
{
    use HasFactory;

    public $table = 'customers';
    protected $fillable = ['name', 'email', 'phone'];
}
