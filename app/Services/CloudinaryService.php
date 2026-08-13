<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    protected Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary([
            'cloud_name' => config('cloudinary.cloud_name'),
            'api_key' => config('cloudinary.api_key'),
            'api_secret' => config('cloudinary.api_secret'),
        ]);
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
            $config = config('cloudinary.upload');

            $uploadOptions = [
                'folder' => "{$folder}/properties",
                'resource_type' => 'auto',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ];

            // إضافة التحويلات إذا كانت موجودة
            if (isset($config['transformation'])) {
                $uploadOptions['transformation'] = [$config['transformation']];
            }

            $response = $this->cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                $uploadOptions
            );

            return $response['secure_url'];
        } catch (\Exception $e) {
            \Log::error('Cloudinary Upload Error: ' . $e->getMessage());
            throw $e;
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
            // استخراج public_id من الرابط
            $publicId = $this->extractPublicId($imageUrl);

            if (!$publicId) {
                return false;
            }

            $this->cloudinary->uploadApi()->destroy($publicId);

            return true;
        } catch (\Exception $e) {
            \Log::error('Cloudinary Delete Error: ' . $e->getMessage());
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
