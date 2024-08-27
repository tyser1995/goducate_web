<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessPermit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'business_permits';

    public const BUSINESS_TYPE = [
        'priority' => 'Priority',
        'small' => 'Small',
        'medium' => 'Medium'
    ];
}
