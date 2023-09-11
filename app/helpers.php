<?php

if (!function_exists('getImage')) {
    function getImage($image, $size)
    {
        if ($image) {
            return asset($image);
        }

        return asset("/images/no-photo.png");
    }
}

if (!function_exists('getImageUrl')) {
    function getImageUrl($imageUrl)
    {
        try {
            if ($imageUrl && fitle_exists(public_path($imageUrl)) && isset($imageUrl)) {
                return "href=".asset($imageUrl)." target=_blank";
            }

            return 'href=javascript:void(0)';
        } catch (\Throwable $th) {}
    }
}
