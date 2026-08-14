<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;
use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;

class MigrateImagesToCloudinary extends Command
{
    protected $signature = 'migrate:images
                            {--dry-run : Do not perform uploads, only show what would happen}
                            {--delete-local : Delete local files after successful upload}
                            {--model=Property : Model to migrate (Property)}';

    protected $description = 'Migrate existing local image files to Cloudinary for the specified model';

    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        parent::__construct();
        $this->cloudinary = $cloudinary;
    }

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $deleteLocal = $this->option('delete-local');

        $this->info('Starting migration of images to Cloudinary');

        $query = Property::query();
        $total = $query->count();

        if ($total === 0) {
            $this->info('No records found.');
            return 0;
        }

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($query->cursor() as $property) {
            $original = $property->getRawOriginal('image');

            if (empty($original)) {
                $bar->advance();
                continue;
            }

            // Skip if already a Cloudinary URL
            if (filter_var($original, FILTER_VALIDATE_URL) && str_contains($original, 'res.cloudinary.com')) {
                $bar->advance();
                continue;
            }

            // Determine local storage relative path
            $relative = $this->extractRelativePath($original);

            if (!$relative) {
                $bar->advance();
                continue;
            }

            $fullPath = storage_path('app/public/' . ltrim($relative, '/'));

            if (!file_exists($fullPath)) {
                \Log::warning('Local file for migration not found', ['path' => $fullPath, 'property_id' => $property->id]);
                $bar->advance();
                continue;
            }

            if ($dryRun) {
                $this->line("[DRY] Would upload: {$fullPath} for property {$property->id}");
                $bar->advance();
                continue;
            }

            try {
                $uploadedFile = new UploadedFile($fullPath, basename($fullPath), null, null, true);

                $result = $this->cloudinary->upload($uploadedFile, 'investment-platform');

                // update DB only if result looks like a URL or path
                if ($result) {
                    $property->image = $result;
                    $property->save();

                    if ($deleteLocal) {
                        @unlink($fullPath);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Migration upload failed', ['error' => $e->getMessage(), 'property_id' => $property->id]);
                $this->error('Failed to migrate property: ' . $property->id);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Migration completed.');

        return 0;
    }

    protected function extractRelativePath(string $value): ?string
    {
        // If value is a full URL pointing to our app storage, extract the storage path
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $storageBase = url('storage/') . '/';
            if (str_starts_with($value, $storageBase)) {
                return substr($value, strlen($storageBase));
            }

            // If it's another absolute URL not Cloudinary, we can't migrate
            return null;
        }

        // If it already starts with storage/ or is a relative path
        if (str_starts_with($value, 'storage/')) {
            return preg_replace('#^storage/#', '', $value);
        }

        return ltrim($value, '/');
    }
}
