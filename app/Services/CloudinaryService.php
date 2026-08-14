<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    protected ?Cloudinary $cloudinary = null;

    public function __construct()
    {
        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        $apiSecret = config('cloudinary.api_secret');

        // لا نرمي استثناء هنا — سنتحقق عند الرفع فقط
        if ($cloudName && $apiKey && $apiSecret) {
            try {
                $this->cloudinary = new Cloudinary([
                    'cloud_name' => $cloudName,
                    'api_key' => $apiKey,
                    'api_secret' => $apiSecret,
                ]);
                \Log::info('Cloudinary initialized successfully');
            } catch (\Exception $e) {
                \Log::warning('Failed to initialize Cloudinary', ['error' => $e->getMessage()]);
                $this->cloudinary = null;
            }
        } else {
            \Log::warning('Cloudinary credentials not configured', [
                'cloud_name' => $cloudName ? '***' : 'MISSING',
                'api_key' => $apiKey ? '***' : 'MISSING',
                'api_secret' => $apiSecret ? '***' : 'MISSING',
            ]);
            $this->cloudinary = null;
        }
    }

    /**
     * رفع صورة إلى Cloudinary
     *
     * @param UploadedFile $file
     * @param string $folder اسم المجلد
     * @return string رابط الصورة
     */
    public function upload(UploadedFile $file, string $folder = 'investment-platform'): string
    {
        try {
            // التحقق من وجود Cloudinary
            if (!$this->cloudinary) {
                \Log::warning('Cloudinary not initialized, using local storage');
                return $this->uploadLocal($file, $folder);
            }

            // التحقق من البيانات الأساسية
            if (!config('cloudinary.cloud_name') || config('cloudinary.cloud_name') === 'your_cloud_name') {
                \Log::warning('Cloudinary credentials not configured, using local storage');
                return $this->uploadLocal($file, $folder);
            }

            $config = config('cloudinary.upload');

            $uploadOptions = [
                'folder' => "{$folder}/properties",
                'resource_type' => 'auto',
                'quality' => 'auto',
                'fetch_format' => 'auto',
                'timeout' => 60, // 60 ثانية timeout
            ];

            // إضافة التحويلات إذا كانت موجودة
            if (isset($config['transformation'])) {
                $uploadOptions['transformation'] = [$config['transformation']];
            }

            \Log::info('Attempting to upload to Cloudinary', [
                'file' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'folder' => $uploadOptions['folder'],
            ]);

            $response = $this->cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                $uploadOptions
            );

            $imageUrl = $response['secure_url'];

            \Log::info('Successfully uploaded to Cloudinary', [
                'url' => $imageUrl,
                'public_id' => $response['public_id'] ?? 'N/A',
            ]);

            return $imageUrl;
        } catch (\Exception $e) {
            \Log::error('Cloudinary Upload Error', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'code' => $e->getCode(),
            ]);

            // رجوع للتخزين المحلي كـ fallback
            \Log::info('Falling back to local storage after Cloudinary failure');
            return $this->uploadLocal($file, $folder);
        }
    }

    /**
     * رفع محلي بديل (للتطوير أو كـ fallback)
     */
    private function uploadLocal(UploadedFile $file, string $folder = 'investment-platform'): string
    {
        try {
            $path = $file->store("{$folder}/properties", 'public');

            \Log::info('Uploaded to local storage', [
                'path' => $path,
            ]);

            return $path;
        } catch (\Exception $e) {
            \Log::error('Local storage upload failed', [
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('❌ فشل رفع الصورة محلياً أيضاً: ' . $e->getMessage());
        }
    }

    /**
     * حذف صورة من Cloudinary
     *
     * @param string $imageUrl رابط الصورة أو public_id
     * @return bool
     */
    public function delete(string $imageUrl): bool
    {
        try {
            // تحقق إذا كانت صورة محلية
            if (strpos($imageUrl, 'storage/') !== false) {
                return $this->deleteLocal($imageUrl);
            }

            // تحقق من وجود Cloudinary
            if (!$this->cloudinary) {
                \Log::warning('Cloudinary not initialized, skipping delete');
                return false;
            }

            // استخراج public_id من الرابط
            $publicId = $this->extractPublicId($imageUrl);

            if (!$publicId) {
                \Log::warning('Could not extract public_id from URL', ['url' => $imageUrl]);
                return false;
            }

            $this->cloudinary->uploadApi()->destroy($publicId);

            \Log::info('Deleted from Cloudinary', ['public_id' => $publicId]);
            return true;
        } catch (\Exception $e) {
            \Log::error('Cloudinary Delete Error', [
                'error' => $e->getMessage(),
                'url' => $imageUrl,
            ]);
            return false;
        }
    }

    /**
     * حذف صورة محلية
     */
    private function deleteLocal(string $imageUrl): bool
    {
        try {
            // استخراج المسار من الـ URL
            $path = str_replace(url('storage/') . '/', '', $imageUrl);
            $fullPath = storage_path('app/public/' . $path);

            if (file_exists($fullPath)) {
                unlink($fullPath);
                \Log::info('Deleted local file', ['path' => $path]);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Local file delete error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * استخراج public_id من رابط الصورة
     *
     * @param string $imageUrl
     * @return string|null
     */
    private function extractPublicId(string $imageUrl): ?string
    {
        // معالجة الرابط للحصول على public_id
        // مثال: https://res.cloudinary.com/xxxxx/image/upload/v123456/investment-platform/properties/abc123.jpg
        if (preg_match('/\/([^\/]+)\/([^\/]+)\./', $imageUrl, $matches)) {
            return $matches[1] . '/' . $matches[2];
        }

        return null;
    }

    /**
     * الحصول على رابط معدّل من صورة موجودة
     *
     * @param string $imageUrl رابط الصورة الأصلي
     * @param array $transformation التحويلات المطلوبة
     * @return string الرابط المعدّل
     */
    public function transformUrl(string $imageUrl, array $transformation = []): string
    {
        if (empty($transformation)) {
            $transformation = config('cloudinary.upload.transformation', []);
        }

        // يمكن استخدام Cloudinary SDK للتحويلات المعقدة
        // للآن نرجع الرابط الأصلي
        return $imageUrl;
    }
}
