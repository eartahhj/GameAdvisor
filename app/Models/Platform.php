<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Platform extends BaseModel
{
    use HasFactory;

    const IMAGE_MIN_WIDTH = 800;
    const IMAGE_MAX_WIDTH = 800;
    const IMAGE_MIN_HEIGHT = 600;
    const IMAGE_MAX_HEIGHT = 600;

    protected $fillable = [
        'name_en',
        'name_it',
        'description_en',
        'description_it',
        'image'
    ];

    protected static array $multiLingualFields = [
        'name',
        'description'
    ];

    public static function returnImageValidationString(): string
    {
        return parent::returnImageValidationString() . '|ratio=4/3';
    }

    public static function getOrderBy(): array
    {
        $orderBy = ['column' => 'created_at', 'order' => 'DESC'];

        if (!empty($_GET['order'])) {
            $orderBy = match ($_GET['order']) {
                'date_asc' => ['column' => 'created_at', 'order' => 'ASC'],
                'name_asc' => ['column' => 'name_' . getLanguage(), 'order' => 'ASC'],
                'name_desc' => ['column' => 'name_' . getLanguage(), 'order' => 'DESC'],
                default => ['column' => 'created_at', 'order' => 'DESC']
            };
        }

        return $orderBy;
    }

    public static function getOrderByOptions(): array
    {
        return [
            '' => _('Newest first'),
            'date_asc' => _('Oldest first'),
            'name_asc' => _('A to Z'),
            'name_desc' => _('Z to A')
        ];
    }
}
