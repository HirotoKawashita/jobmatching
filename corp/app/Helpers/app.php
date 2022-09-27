<?php declare(strict_types=1);

if (!function_exists('hello')) {
    /**
     * @return string
     */
    function hello(): string
    {
        return 'Hello World.';
    }
}

if (!function_exists('getAge')) {
    /**
     * @params object entity
     * @return int
     */
    function getAge($entity): int
    {
        try {
            if ($entity->birth_date) {
                $now = date('Ymd');

                $birthDate = (int)floor(($now - str_replace("-", "", $entity->birth_date)) / 10000);
            }
            return $birthDate;

        } catch (\Exception $e) {
            return 0;
        }
        return 0;
    }
}

if (!function_exists('decodeImagePath')) {
    /**
     * @params object entity
     * @return string
     */
    function decodeImagePath($entity): ?string
    {
        try {
            $imagePath = null;
            if ($entity->image_path) {
                $imagePath = json_decode($entity->image_path, true)['small'];
            }
            return $imagePath;

        } catch (\Exception $e) {
            return null;
        }
    }
}