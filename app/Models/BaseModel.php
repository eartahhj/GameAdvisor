<?php

namespace App\Models;

use Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    const IMAGE_MIN_WIDTH = 200;
    const IMAGE_MAX_WIDTH = 2560;
    const IMAGE_MIN_HEIGHT = 200;
    const IMAGE_MAX_HEIGHT = 1440;
    const IMAGE_MAX_SIZE = 500;
    const IMAGE_MIMETYPES = 'image/jpeg,image/png,image/webp,image/avif';

    protected static array $multiLingualFields = [];

    public function __get($key)
    {
        if (!empty(static::$multiLingualFields) and in_array($key, static::$multiLingualFields)) {
            return parent::__get($key . '_' . getLanguage());
        }

        return parent::__get($key);
    }

    public static function returnImageSupportedFormatsString(): string
    {
        return sprintf(
            _('Supported Formats: JPEG, PNG, WEBP or AVIF. Dimensions between %s and %s. Maximum size for each image: %s.'),
            static::IMAGE_MIN_WIDTH . 'x' . static::IMAGE_MIN_HEIGHT . 'px',
            static::IMAGE_MAX_WIDTH . 'x' . static::IMAGE_MAX_HEIGHT . 'px',
            static::IMAGE_MAX_SIZE . 'KB'
        );
    }

    public static function returnImageValidationString(): string
    {
        return 'file|between:1,' . static::IMAGE_MAX_WIDTH . '|mimetypes:' . static::IMAGE_MIMETYPES .'|dimensions:min_width=' . static::IMAGE_MIN_WIDTH . ',min_height=' . static::IMAGE_MIN_HEIGHT . ',max_width=' . static::IMAGE_MAX_WIDTH . ',max_height=' . static::IMAGE_MAX_HEIGHT;
    }

    public function uploadImage(): string
    {
        return uploadImage(
            fileFolder: 'images/' . mb_strtolower((new \ReflectionClass($this))->getShortName()) . 's',
            newFileName: mb_strtolower((new \ReflectionClass($this))->getShortName()) . '-' . $this->id . '-image'
        );
    }

    public function getImage() : ?\Intervention\Image\Image
    {
        if ($this->image) {
            return Image::make(Storage::disk('public')->path($this->image));
        }

        return null;
    }
}
