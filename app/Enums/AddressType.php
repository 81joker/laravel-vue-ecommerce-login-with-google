<?php

namespace App\Enums;
// https://stackoverflow.com/questions/25705878/where-to-put-how-to-handle-enums-in-laravel
enum AddressType: string
{
    case Billing = 'billing';
    case Shipping = 'shipping';
}

/**
 * لماذا نستخدم Enum؟
✅ يمنع الأخطاء: بدلاً من استخدام سلاسل نصية عشوائية مثل "billing", "ship", فإن Enum يضمن أن القيم صحيحة.
✅ يُحسِّن القابلية للقراءة: يجعل الكود أكثر وضوحًا وسهل الفهم.
✅ يُسهل الصيانة: إذا أردت تغيير القيم، يمكنك تعديل Enum بدلاً من البحث في كل مكان في الكود.

💡 متى نستخدمه؟
عند التعامل مع بيانات ذات قيم ثابتة مثل:
✔️ أنواع الدفع (Credit Card, PayPal)
✔️ أدوار المستخدم (Admin, User, Guest)
✔️ حالات الطلبات (Pending, Shipped, Delivered)


 */