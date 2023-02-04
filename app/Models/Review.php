<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'author_email',
        'user_id',
        'title',
        'text',
        'approved',
        'rating',
        'game_id'
    ];

    public static function getOrderBy(): array
    {
        $orderBy = ['column' => 'created_at', 'order' => 'ASC'];

        if (!empty($_GET['order'])) {
            $orderBy = match ($_GET['order']) {
                'date_desc' => ['column' => 'created_at', 'order' => 'DESC'],
                'author_asc' => ['column' => 'author', 'order' => 'ASC'],
                'author_desc' => ['column' => 'author', 'order' => 'DESC'],
                'rating_desc' => ['column' => 'rating', 'order' => 'DESC'],
                'rating_asc' => ['column' => 'rating', 'order' => 'DESC']
            };
        }

        return $orderBy;
    }
}
