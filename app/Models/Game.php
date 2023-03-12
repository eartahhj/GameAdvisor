<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Game extends BaseModel
{
    use HasFactory;

    const IMAGE_MIN_WIDTH = 800;
    const IMAGE_MAX_WIDTH = 800;
    const IMAGE_MIN_HEIGHT = 600;
    const IMAGE_MAX_HEIGHT = 600;

    protected $fillable = [
        'title_it',
        'title_en',
        'description_it',
        'description_en',
        'platform_id',
        'image',
        'year',
        'publisher_id',
        'developer_id'
    ];

    protected static array $multiLingualFields = [
        'title',
        'description'
    ];

    public static function returnImageValidationString(): string
    {
        return parent::returnImageValidationString() . '|dimensions:ratio=4/3';
    }

    public static function getOrderBy(): array
    {
        $orderBy = ['column' => 'created_at', 'order' => 'DESC'];

        if (!empty($_GET['order'])) {
            $orderBy = match ($_GET['order']) {
                'date_asc' => ['column' => 'created_at', 'order' => 'ASC'],
                'title_asc' => ['column' => 'title_' . getLanguage(), 'order' => 'ASC'],
                'title_desc' => ['column' => 'title_' . getLanguage(), 'order' => 'DESC'],
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
            'title_asc' => _('A to Z'),
            'title_desc' => _('Z to A')
        ];
    }
}
