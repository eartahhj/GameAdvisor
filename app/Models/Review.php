<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends BaseModel
{
    use HasFactory;

    // const IMAGE_MIN_WIDTH = 200;
    // const IMAGE_MAX_WIDTH = 2560;
    // const IMAGE_MIN_HEIGHT = 200;
    // const IMAGE_MAX_HEIGHT = 1440;
    // const IMAGE_MAX_SIZE = 500;
    // const IMAGE_MIMETYPES = 'image/jpeg,image/png,image/webp,image/avif';

    const PREVIEW_MAX_LENGTH = 200;

    protected $fillable = [
        'author_name',
        'author_email',
        'user_id',
        'title',
        'text',
        'approved',
        'rating',
        'game_id',
        'image',
        'hours_played'
    ];

    public static function getOrderBy(): array
    {
        $orderBy = ['column' => 'created_at', 'order' => 'ASC'];

        if (!empty($_GET['order'])) {
            $orderBy = match ($_GET['order']) {
                'date_desc' => ['column' => 'created_at', 'order' => 'DESC'],
                'author_asc' => ['column' => 'author_name', 'order' => 'ASC'],
                'author_desc' => ['column' => 'author_name', 'order' => 'DESC'],
                'rating_desc' => ['column' => 'rating', 'order' => 'DESC'],
                'rating_asc' => ['column' => 'rating', 'order' => 'ASC'],
                default => ['column' => 'created_at', 'order' => 'ASC']
            };
        }

        return $orderBy;
    }

    public static function getOrderByOptions(): array
    {
        return [
            '' => _('Oldest first'),
            'date_desc' => _('Newest first'),
            'author_asc' => _('Author (A to Z)'),
            'author_desc' => _('Author (Z to A)'),
            'rating_desc' => _('Best rating first'),
            'rating_asc' => _('Worst rating first')
        ];
    }

    public static function getRatings(): array
    {
        return [
            1  => sprintf('%d star', 1),
            2  => sprintf('%d stars', 2),
            3  => sprintf('%d stars', 3),
            4  => sprintf('%d stars', 4),
            5  => sprintf('%d stars', 5)
        ];
    }

    public function getPreviewText()
    {
        if (mb_strlen($this->text) > self::PREVIEW_MAX_LENGTH) {
            return mb_substr($this->text, 0, self::PREVIEW_MAX_LENGTH) . ' ' . _('[...]');
        }

        return $this->text;
    }
}
