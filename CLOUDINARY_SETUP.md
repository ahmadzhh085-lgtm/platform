## ⚠️ REQUIRED: Railway Environment Variables

Before images will upload to Cloudinary, you **must** set the following environment variables on the `zoological-flow` service in Railway (Project → Service → Variables):

```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

`CloudinaryService` checks for these three variables at runtime. If any of them are missing, uploads silently fall back to local disk storage (`storage/app/public`).

### Fallback behavior (local storage)

If Cloudinary credentials are not configured:

- Images are stored on the container's local filesystem under `storage/app/public` and served through the `public/storage` symlink.
- The symlink is created automatically on every deploy/boot via `php artisan storage:link` (see `boot.sh` and the Railway start command), so images uploaded during a session will display correctly.
- **This is not recommended for production.** Railway's filesystem is ephemeral — any new deployment, restart, or redeploy replaces the container's filesystem, so previously uploaded images will be lost unless a persistent volume is mounted at `/app/storage`.
- Treat local storage as a temporary fallback only. Set the Cloudinary environment variables above as soon as possible for reliable, persistent image storage.

---

# ✅ حل مشكلة تخزين الصور على Railway

## المشكلة

الصور لا تظهر في Production (Railway) لأن التخزين المحلي لا يعمل في بيئة سحابية Stateless.

### السبب

- كل deployment على Railway يحصل على نظام ملفات جديد منفصل
- الملفات المحفوظة في deployment القديم تختفي

---

## ✅ الحل: استخدام Cloudinary (الأفضل للصور)

Cloudinary هو خدمة تخزين سحابي متخصصة في الصور مع ميزات متقدمة:

- ✅ رفع صور سهل وآمن
- ✅ تحويل الصور تلقائياً (resize, compress, format)
- ✅ سرعة عالية في التحميل
- ✅ خطة مجانية كافية للمشاريع الصغيرة

---

## 📝 خطوات الإعداد

### 1️⃣ إنشاء حساب Cloudinary

1. اذهب إلى [Cloudinary](https://cloudinary.com)
2. اضغط "Sign Up for Free"
3. أكمل البيانات
4. تأكيد البريد الإلكتروني

### 2️⃣ الحصول على بيانات الاعتماد

بعد التسجيل:

1. اذهب إلى Dashboard
2. انسخ هذه البيانات:
    - **Cloud Name**
    - **API Key**
    - **API Secret**

### 3️⃣ إضافة المتغيرات في Railway

في لوحة تحكم Railway:

```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
```

### 4️⃣ في بيئة التطوير المحلية

عدّل `.env` في جهازك:

```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

---

## 🔧 التحديثات المنجزة

### الملفات المُضافة:

- ✅ `config/cloudinary.php` - تكوين Cloudinary
- ✅ `app/Services/CloudinaryService.php` - Service للتعامل مع الصور

### الملفات المُعدَّلة:

- ✅ `app/Http/Controllers/Admin/PropertyController.php` - استخدام Cloudinary
- ✅ `app/Http/Controllers/Api/PropertyController.php` - دعم API
- ✅ `app/Services/PropertyService.php` - معالجة الصور
- ✅ `app/Http/Requests/PropertyRequest.php` - تحديث validation
- ✅ `.env` - متغيرات Cloudinary
- ✅ `.env.production.example` - متغيرات البيئة للـ production

---

## 🚀 كيفية الاستخدام

### إضافة صورة (Admin Panel):

```php
// الكود يعمل تلقائياً الآن!
// عند رفع صورة:
// 1. تُرفع لـ Cloudinary
// 2. يُحفظ الرابط في قاعدة البيانات
// 3. الصورة تظهر فوراً على الموقع
```

### API (JSON):

```bash
POST /api/properties
Content-Type: multipart/form-data

project_id: 1
title: "Property Name"
type: "Apartment"
price: 100000
status: "available"
image: [file]  # الملف يُرفع تلقائياً لـ Cloudinary
```

---

## 🆘 حل المشاكل

### الخطأ: "Unauthorized"

- **السبب**: بيانات Cloudinary غير صحيحة
- **الحل**: تحقق من Cloud Name و API Key و API Secret

### الصور لا تُرفع

- **السبب**: الملف كبير جداً أو صيغة غير مدعومة
- **الحل**: اختر صورة JPG/PNG أصغر من 5MB

### الصور القديمة لا تظهر

- **السبب**: كانت مخزنة محلياً في deployment القديم
- **الحل**: أعد رفع الصور باستخدام الـ admin panel

---

## 📚 موارد إضافية

- [Cloudinary Documentation](https://cloudinary.com/documentation)
- [Cloudinary PHP SDK](https://github.com/cloudinary/cloudinary_php)
- [Laravel File Upload Best Practices](https://laravel.com/docs/11.x/requests#files)

---

## 🔄 الخطوات التالية

1. ✅ تحقق من أن `composer require cloudinary/cloudinary_php` تم تثبيته
2. ✅ أضف متغيرات البيئة في Railway
3. ✅ Push التحديثات إلى GitHub
4. ✅ اختبر إضافة صورة جديدة في الـ admin panel
5. ✅ تحقق من ظهور الصورة بدون خطأ 404

---

## 🔄 البدائل (اختياري)

إذا كنت تفضل استخدام AWS S3 بدلاً من Cloudinary:

### متغيرات S3:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
AWS_URL=https://your-bucket.s3.amazonaws.com
```

**ملاحظة**: إذا غيّرت إلى S3، يجب تعديل الكود في `PropertyController` و `PropertyService` للعودة إلى استخدام `Storage` بدلاً من `CloudinaryService`.
