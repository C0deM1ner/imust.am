<?php

namespace App\Support\Translator;

class Translator
{
    public function array($array, $locale = null): array|string|null
    {
        return $this->translateArray($array, $this->getLocale($locale));
    }

    protected function translateValue($value, $locale = null): mixed
    {
        if ($this->isJson($value)) {
            return json_decode($value, true)[$locale] ?? json_decode($value, true);
        }

        return $value;
    }

    protected function translateArray($array, $locale): mixed
    {
        if ($this->isJson($array)) {
            $array = json_decode($array, true);
        }

        if (is_null($array)) {
            return null;
        }

        if (is_object($array)) {
            $array = (array) $array;
        }

        if (! is_array($array)) {
            return $array;
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->translateArray($value, $locale);
            } elseif ($key === $locale && is_null($value)) {
                $array = null;
            } elseif ($key === $locale && is_string($value)) {
                $array = $value;
            }
        }

        return $array;
    }

    protected function isJson($value): bool
    {
        if (! is_string($value) || trim($value) === '') {
            return false;
        }

        json_decode($value);

        return json_last_error() === JSON_ERROR_NONE;
    }

    protected function getLocale($locale = null): string
    {
        return $locale ?? app()->getLocale();
    }
}
