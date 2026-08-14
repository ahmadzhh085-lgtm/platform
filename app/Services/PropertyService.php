<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyService
{
    protected ?CloudinaryService $cloudinary = null;

    protected function getCloudinaryService(): CloudinaryService
    {
        if ($this->cloudinary === null) {
            $this->cloudinary = new CloudinaryService();
        }
        return $this->cloudinary;
    }

    public function list(Request $request)
    {
        return Property::with('project')
            ->when($request->query('project_id'), function ($query, $projectId) {
                $query->where('project_id', $projectId);
            })
            ->when($request->query('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->query('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($request->query('per_page', 15));
    }

    public function create(array $data)
    {
        // معالجة الصورة إذا كانت موجودة في البيانات
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            try {
                $data['image'] = $this->getCloudinaryService()->upload($data['image']);
            } catch (\Exception $e) {
                \Log::error('Failed to upload image: ' . $e->getMessage());
                unset($data['image']);
            }
        }

        return Property::create($data);
    }

    public function update(Property $property, array $data)
    {
        // معالجة الصورة الجديدة إذا كانت موجودة
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            try {
                // حذف الصورة القديمة
                if ($property->image) {
                    $this->getCloudinaryService()->delete($property->image);
                }
                
                // رفع الصورة الجديدة
                $data['image'] = $this->getCloudinaryService()->upload($data['image']);
            } catch (\Exception $e) {
                \Log::error('Failed to upload image: ' . $e->getMessage());
                unset($data['image']);
            }
        }

        $property->update($data);
        return $property;
    }

    public function delete(Property $property)
    {
        // حذف الصورة من Cloudinary
        if ($property->image) {
            try {
                $this->getCloudinaryService()->delete($property->image);
            } catch (\Exception $e) {
                \Log::warning('Failed to delete image from Cloudinary: ' . $e->getMessage());
            }
        }

        $property->delete();
    }
}
