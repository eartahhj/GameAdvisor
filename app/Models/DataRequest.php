<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'email',
        'description',
        'notes'
    ];

    public static function getTypes()
    {
        return [
            1 => _('Developer'),
            2 => _('Game'),
            3 => _('Platform'),
            4 => _('Publisher'),
            5 => _('Other')
        ];
    }

}
