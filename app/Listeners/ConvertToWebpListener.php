<?php

namespace App\Listeners;

use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;
use Oneduo\NovaFileManager\Events\FileUploaded;

class ConvertToWebpListener
{
    public function handle(FileUploaded $event): void
    {
        $path = $event->path;

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            return;
        }

        if ($ext === 'webp') {
            return;
        }

        // Use the Filesystem instance from the event directly — $event->disk is a
        // nova-file-manager virtual identifier, not a real Laravel filesystem disk
        // name, so Storage::disk($event->disk) would fail to resolve the file.
        $filesystem = $event->filesystem;
        $content = $filesystem->get($path);

        if ($content === null) {
            return;
        }

        $image = Image::read($content)->encode(new WebpEncoder(90));

        $webpPath = preg_replace('/\.\w+$/', '.webp', $path);

        $filesystem->put($webpPath, $image);
        $filesystem->delete($path);
    }
}
