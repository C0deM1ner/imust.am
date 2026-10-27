<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\Storage;

trait CopiesSeedImages
{
    /**
     * Copies database/seeders/images/{$file} to the public disk under $folder and returns it as a
     * file manager value, so seeded photos show up in the Nova file manager like uploaded ones.
     */
    protected function image(string $file, string $folder = 'pages'): array
    {
        $path = $folder.'/'.basename($file);
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            $disk->put($path, file_get_contents(database_path("seeders/images/{$file}")));
        }

        return ['disk' => 'public', 'path' => $path];
    }
}
