<?php

use App\Models\Page;
use Illuminate\Support\Str;

if (!function_exists('getPageIdByUrl')) {
    function getPageIdByUrl(string $url, int $maxDigits = 10): int
    {
        if (!preg_match('/^([1-9]{1}[0-9]{0,' . $maxDigits - 1 . '})/', $url, $matches)) {
            return 0;
        }

        return $matches[0];
    }
}

if (!function_exists('getPageByUri')) {
    function getPageByUri(string $uri): ?Page
    {
        if (!isPageUrlFormatValid(url: $uri)) {
            return null;
        }        
        
        if (!$id = getPageIdByUrl(url: $uri)) {
            return null;
        }

        return Page::findOrFail($id);
    }
}

if (!function_exists('getPageUrlById')) {
    function getPageUrlById(int $pageId): string
    {
        $locale = App::currentLocale();

        $reverseRoute = route('pages.show', $pageId);

        $page = Page::find($pageId);

        if (!$page) {
            return '#';
        }

        $url = $reverseRoute . '-' . $page->{'url_' . $locale};

        return $url;
    }
}

if (!function_exists('getPageUrlByUri')) {
    function getPageUrlByUri(string $uri, string $separator = '-'): string
    {
        if ($separator) {
            $position = stripos($uri, $separator);
            if (!$position) {
                return '';
            }

            return substr($uri, $position + strlen($separator));
        }
    }
}

if (!function_exists('isPageUrlFormatValid')) {
    function isPageUrlFormatValid(string $url, string $separator = '-', int $maxDigits = 10): bool
    {
        if ($separator) {
            if (!stripos($url, $separator)) {
                return false;
            }
        }

        if (!getPageIdByUrl($url, $maxDigits)) {
            return false;
        }

        if (!getPageUrlByUri($url, $separator)) {
            return false;
        }
    
        return true;
    }
}

if (!function_exists('page_url')) {
    function page_url($id)
    {
        return getPageUrlById(intval($id));
    }
}

if (!function_exists('loadGettext')) {
    function loadGettext(string $language)
    {
        if (env('APP_ENV') == 'local') {
            $domain = 'gameadvisor_' . $language;
        } elseif (env('APP_ENV') == 'production') {
            $domain = 'gameadvisor';
            // Converting language codes for Unix
            $language = match ($language) {
                'en' => 'en_US',
                'it' => 'it_IT'
            };
        }

        if (defined('LC_ALL')) {
            setlocale(LC_ALL, $language);
        }

        if (defined('LC_CTYPE')) {
            setlocale(LC_CTYPE, $language);
        }

        if (defined('LC_MESSAGES')) {
            setlocale(LC_MESSAGES, $language);
        }

        if (defined('LC_TIME')) {
            setlocale(LC_TIME, $language);
        }
        
        bindtextdomain($domain, base_path() . '/lang/locale');
        textdomain($domain);
        bind_textdomain_codeset($domain, 'UTF-8');
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $date->format(_('m/d/Y H:i'));
    }
}

if (!function_exists('formatUrl')) {
    function formatUrl(string $title, string $separator = '-')
    {
        return $slug = Str::of($title)->slug($separator)->value;
    }
}

if (!function_exists('uploadImage')) {
    function uploadImage(
        string $newFileName, string $fileFolder = 'images', string $inputName = 'image'
    ): string
    {
        
        if (request()->hasFile($inputName)) {
            $file = request()->file($inputName);
            $newFileName .= '.' . $file->extension();

            return Storage::putFileAs($fileFolder, $file, $newFileName);
        }

        return '';
    }
}

if (!function_exists('getLibravatar')) {
    function getLibravatar(string $email, int $size = 80): string
    {
        if ($size < 80) {
            $size = 80;
        }
        
        if ($size > 2048) {
            $size = 2048;
        }
        
        return 'https://seccdn.libravatar.org/avatar/' . md5(strtolower(trim($email))) . "?s={$size}&d=mp";
    }
}

if (!function_exists('getLanguages')) {
    function getLanguages(): array
    {
        return config('app')['languages'];
    }
}

if (!function_exists('getLanguage')) {
    function getLanguage(): string
    {
        return App::currentLocale();
    }
}

if (!function_exists('adsEnabled')) {
    function adsEnabled(): int|false
    {
        $cookiesConsent = $_COOKIE['cookiesConsent'] ?? '';

        if (strpos($cookiesConsent, 'ads')) {
            return true;
        }

        return false;
    }
}