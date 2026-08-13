# ✅ قائمة التحقق من تطبيق Cloudinary

## قبل الـ Push

- [ ] هل قرأت ملف `CLOUDINARY_SETUP.md`?
- [ ] هل تم تثبيت `cloudinary/cloudinary_php`؟
- [ ] هل تم اختبار الكود محلياً (composer check)?
- [ ] هل جميع الملفات لا تحتوي على syntax errors؟

## عند الـ Push

```bash
# 1. تحقق من الملفات المُعدَّلة
git status

# 2. أضف الملفات
git add .

# 3. Commit
git commit -m "feat: Implement Cloudinary for image storage

- Add config/cloudinary.php
- Add CloudinaryService
- Update PropertyController
- Update PropertyService
- Update PropertyRequest validation
- Add Cloudinary env variables"

# 4. Push
git push origin main
```

## بعد الـ Push (في Railway)

- [ ] أضف متغيرات Cloudinary:
    - `CLOUDINARY_CLOUD_NAME`
    - `CLOUDINARY_API_KEY`
    - `CLOUDINARY_API_SECRET`
    - `CLOUDINARY_URL`

- [ ] Redeploy المشروع

## الاختبار

- [ ] أضف صورة جديدة من admin panel
- [ ] تحقق من ظهور الصورة بدون خطأ 404
- [ ] تحقق من وجود الصورة في Cloudinary Dashboard
- [ ] جرب حذف الصورة
- [ ] جرب تحديث الصورة (upload صورة جديدة)

## حل المشاكل

### الصور لا تُرفع

- [ ] تحقق من بيانات Cloudinary في Railway
- [ ] تحقق من صيغة الصورة (JPG/PNG)
- [ ] تحقق من حجم الصورة (< 5MB)
- [ ] اقرأ السجلات في `storage/logs/`

### الصور تُرفع لكن لا تظهر

- [ ] تحقق من الرابط (يجب أن يبدأ بـ `https://res.cloudinary.com`)
- [ ] تحقق من قاعدة البيانات (الرابط مخزن؟)
- [ ] تحقق من الـ view (تُعرض الصورة بشكل صحيح؟)

### تفاعل بطيء

- [ ] قد تحتاج إلى تحسين حجم الصور
- [ ] استخدم الحد الأقصى 5MB
- [ ] Cloudinary سيحسّن الصور تلقائياً

---

## 📞 المراجع السريعة

- Cloudinary Documentation: https://cloudinary.com/documentation
- Laravel File Upload: https://laravel.com/docs/11.x/requests#files
- Railway Variables: https://docs.railway.app/guides/variables

---

**تم إنجاز التحديث! ✅**
