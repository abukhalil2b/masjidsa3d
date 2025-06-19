<?php

return [

    /*
    |--------------------------------------------------------------------------
    | سطور اللغة للتحقق
    |--------------------------------------------------------------------------
    |
    | تحتوي السطور التالي على رسائل الخطأ الإفتراضية التي يتم استخدامها
    | بواسطة محقق Laravel. بعضها يحتوي على عدة نسخ حسب القاعدة.
    |
    */

    'accepted' => 'حقل :attribute يجب الموافقة عليه.',
    'accepted_if' => 'حقل :attribute يجب الموافقة عليه عندما :other هو :value.',
    'active_url' => 'حقل :attribute يجب أن يحتوي على رابط صحيح.',
    'after' => 'حقل :attribute يجب أن يحتوي على تاريخ بعد :date.',
    'after_or_equal' => 'حقل :attribute يجب أن يحتوي على تاريخ بعد أو يساوي :date.',
    'alpha' => 'حقل :attribute يجب أن يحتوي على حروف فقط.',
    'alpha_dash' => 'حقل :attribute يجب أن يحتوي على حروف، أرقام، شرطات، أو شرطة سفلية فقط.',
    'alpha_num' => 'حقل :attribute يجب أن يحتوي على حروف وأرقام فقط.',
    'any_of' => 'حقل :attribute غير صالح.',
    'array' => 'حقل :attribute يجب أن يكون مصفوفة.',
    'ascii' => 'حقل :attribute يجب أن يحتوي على حروف وأرقام أو رموز من الترميز ASCII فقط.',
    'before' => 'حقل :attribute يجب أن يحتوي على تاريخ قبل :date.',
    'before_or_equal' => 'حقل :attribute يجب أن يحتوي على تاريخ قبل أو يساوي :date.',
    'between' => [
        'array' => 'حقل :attribute يجب أن يحتوي على عدد عناصر بين :min و :max.',
        'file' => 'حقل :attribute يجب أن يكون حجمه بين :min و :max كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون بين :min و :max.',
        'string' => 'حقل :attribute يجب أن يحتوي على عدد أحرف بين :min و :max.',
    ],
    'boolean' => 'حقل :attribute يجب أن يكون صحيحًا أو خطأ.',
    'can' => 'حقل :attribute يحتوي على قيمة غير مصرح بها.',
    'confirmed' => 'حقل :attribute وتأكيده غير متطابقين.',
    'contains' => 'حقل :attribute مفقود منه قيمة مطلوبة.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'حقل :attribute يجب أن يحتوي على تاريخ صحيح.',
    'date_equals' => 'حقل :attribute يجب أن يحتوي على تاريخ مساوٍ لـ :date.',
    'date_format' => 'حقل :attribute يجب أن يطابق التنسيق :format.',
    'decimal' => 'حقل :attribute يجب أن يحتوي على :decimal خانات عشرية.',
    'declined' => 'حقل :attribute يجب رفضه.',
    'declined_if' => 'حقل :attribute يجب رفضه عندما :other هو :value.',
    'different' => 'حقل :attribute و :other يجب أن يكونا مختلفين.',
    'digits' => 'حقل :attribute يجب أن يحتوي على :digits أرقام.',
    'digits_between' => 'حقل :attribute يجب أن يحتوي على عدد أرقام بين :min و :max.',
    'dimensions' => 'حقل :attribute يحتوي على أبعاد صورة غير صحيحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_end_with' => 'حقل :attribute يجب ألا ينتهي بواحد من: :values.',
    'doesnt_start_with' => 'حقل :attribute يجب ألا يبدأ بواحد من: :values.',
    'email' => 'حقل :attribute يجب أن يحتوي على بريد إلكتروني صحيح.',
    'ends_with' => 'حقل :attribute يجب أن ينتهي بواحد من: :values.',
    'enum' => 'القيمة المختارة للحقل :attribute غير صحيحة.',
    'exists' => 'القيمة المختارة للحقل :attribute غير موجودة.',
    'extensions' => 'حقل :attribute يجب أن يحتوي على أحد الامتدادات التالية: :values.',
    'file' => 'حقل :attribute يجب أن يحتوي على ملف.',
    'filled' => 'حقل :attribute مطلوب.',
    'gt' => [
        'array' => 'حقل :attribute يجب أن يحتوي على أكثر من :value عناصر.',
        'file' => 'حقل :attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أكبر من :value.',
        'string' => 'حقل :attribute يجب أن يحتوي على عدد أحرف أكبر من :value.',
    ],
    'gte' => [
        'array' => 'حقل :attribute يجب أن يحتوي على :value عنصر أو أكثر.',
        'file' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي :value.',
        'string' => 'حقل :attribute يجب أن يحتوي على عدد أحرف أكبر من أو يساوي :value.',
    ],
    'hex_color' => 'حقل :attribute يجب أن يحتوي على لون بنظام HEX صحيح.',
    'image' => 'حقل :attribute يجب أن يحتوي على صورة.',
    'in' => 'القيمة المختارة للحقل :attribute غير صحيحة.',
    'in_array' => 'حقل :attribute يجب أن يحتوي على قيمة موجودة ضمن :other.',
    'in_array_keys' => 'حقل :attribute يجب أن يحتوي على أحد المفاتيح: :values.',
    'integer' => 'حقل :attribute يجب أن يحتوي على عدد صحيح.',
    'ip' => 'حقل :attribute يجب أن يحتوي على عنوان IP صحيح.',
    'ipv4' => 'حقل :attribute يجب أن يحتوي على عنوان IPv4 صحيح.',
    'ipv6' => 'حقل :attribute يجب أن يحتوي على عنوان IPv6 صحيح.',
    'json' => 'حقل :attribute يجب أن يحتوي على سلسلة JSON صحيحة.',
    'list' => 'حقل :attribute يجب أن يحتوي على قائمة.',
    'lowercase' => 'حقل :attribute يجب أن يحتوي على حروف صغيرة فقط.',
    'lt' => [
        'array' => 'حقل :attribute يجب أن يحتوي على أقل من :value عناصر.',
        'file' => 'حقل :attribute يجب أن يقل حجمه عن :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يقل عن :value.',
        'string' => 'حقل :attribute يجب أن يحتوي على أقل من :value أحرف.',
    ],
    'lte' => [
        'array' => 'حقل :attribute يجب ألا يحتوي على أكثر من :value عناصر.',
        'file' => 'حقل :attribute يجب ألا يزيد عن :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب ألا يزيد عن :value.',
        'string' => 'حقل :attribute يجب ألا يزيد عن :value أحرف.',
    ],
    'mac_address' => 'حقل :attribute يجب أن يحتوي على عنوان MAC صحيح.',
    'max' => [
        'array' => 'حقل :attribute يجب ألا يحتوي على أكثر من :max عناصر.',
        'file' => 'حقل :attribute يجب ألا يزيد حجمه عن :max كيلوبايت.',
        'numeric' => 'حقل :attribute يجب ألا يزيد عن :max.',
        'string' => 'حقل :attribute يجب ألا يزيد عن :max أحرف.',
    ],
    'max_digits' => 'حقل :attribute يجب ألا يحتوي على أكثر من :max أرقام.',
    'mimes' => 'حقل :attribute يجب أن يحتوي على ملف من نوع: :values.',
    'mimetypes' => 'حقل :attribute يجب أن يحتوي على ملف من نوع: :values.',
    'min' => [
        'array' => 'حقل :attribute يجب أن يحتوي على :min عناصر على الأقل.',
        'file' => 'حقل :attribute يجب أن يحتوي على :min كيلوبايت على الأقل.',
        'numeric' => 'حقل :attribute يجب أن يحتوي على :min على الأقل.',
        'string' => 'حقل :attribute يجب ألا يقل عن :min أحرف على الأقل.',
    ],
    'min_digits' => 'حقل :attribute يجب أن يحتوي على :min أرقام على الأقل.',
    'missing' => 'حقل :attribute يجب ألا يحتوي على قيمة.',
    'missing_if' => 'حقل :attribute يجب ألا يحتوي على قيمة عندما :other تساوي :value.',
    'missing_unless' => 'حقل :attribute يجب ألا يحتوي على قيمة إلا عندما :other تساوي :value.',
    'missing_with' => 'حقل :attribute يجب ألا يحتوي على قيمة عندما :values موجودة.',
    'missing_with_all' => 'حقل :attribute يجب ألا يحتوي على قيمة عندما :values كلها موجودة.',
    'multiple_of' => 'حقل :attribute يجب أن يكون مضاعفًا للعدد :value.',
    'not_in' => 'القيمة المختارة للحقل :attribute غير صحيحة.',
    'not_regex' => 'صيغة حقل :attribute غير صحيحة.',
    'numeric' => 'حقل :attribute يجب أن يحتوي على عدد.',
    'password' => [
        'letters' => 'حقل :attribute يجب أن يحتوي على حرف على الأقل.',
        'mixed' => 'حقل :attribute يجب أن يحتوي على حرف كبير وحرف صغير على الأقل.',
        'numbers' => 'حقل :attribute يجب أن يحتوي على رقم على الأقل.',
        'symbols' => 'حقل :attribute يجب أن يحتوي على رمز على الأقل.',
        'uncompromised' => 'تم العثور على كلمة المرور هذه ضمن تسريبات سابقة. الرجاء استخدام كلمة مرور مغايرة.',
    ],
    'present' => 'حقل :attribute يجب أن يحتوي على قيمة.',
    'present_if' => 'حقل :attribute يجب أن يحتوي على قيمة عندما :other تساوي :value.',
    'present_unless' => 'حقل :attribute يجب أن يحتوي على قيمة إلا عندما :other تساوي :value.',
    'present_with' => 'حقل :attribute يجب أن يحتوي على قيمة عندما :values موجودة.',
    'present_with_all' => 'حقل :attribute يجب أن يحتوي على قيمة عندما :values كلها موجودة.',
    'prohibited' => 'حقل :attribute محظور.',
    'prohibited_if' => 'حقل :attribute محظور عندما :other تساوي :value.',
    'prohibited_if_accepted' => 'حقل :attribute محظور عندما يتم قبول :other.',
    'prohibited_if_declined' => 'حقل :attribute محظور عندما يتم رفض :other.',
    'prohibited_unless' => 'حقل :attribute محظور إلا عندما :other تساوي :values.',
    'prohibits' => 'حقل :attribute يحظر وجود :other.',
    'regex' => 'صيغة حقل :attribute غير صحيحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'حقل :attribute يجب أن يحتوي على مفاتيح :values.',
    'required_if' => 'حقل :attribute مطلوب عندما :other تساوي :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما يتم قبول :other.',
    'required_if_declined' => 'حقل :attribute مطلوب عندما يتم رفض :other.',
    'required_unless' => 'حقل :attribute مطلوب إلا عندما :other تساوي :values.',
    'required_with' => 'حقل :attribute مطلوب عندما :values موجود.',
    'required_with_all' => 'حقل :attribute مطلوب عندما :values كلها موجودة.',
    'required_without' => 'حقل :attribute مطلوب عندما :values غير موجود.',
    'required_without_all' => 'حقل :attribute مطلوب عندما :values كلها غير موجودة.',
    'same' => 'حقل :attribute يجب أن يطابق :other.',
    'size' => [
        'array' => 'حقل :attribute يجب أن يحتوي على :size عنصر.',
        'file' => 'حقل :attribute يجب أن يحتوي على :size كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يحتوي على :size.',
        'string' => 'حقل :attribute يجب أن يحتوي على :size أحرف.',
    ],
    'starts_with' => 'حقل :attribute يجب أن يبدأ بواحد من القيم التالية: :values.',
    'string' => 'حقل :attribute يجب أن يحتوي على نص.',
    'timezone' => 'حقل :attribute يجب أن يحتوي على منطقة زمنية صحيحة.',
    'unique' => 'القيمة المختارة للحقل :attribute محجوزة مسبقًا.',
    'uploaded' => 'فشل رفع الملف :attribute.',
    'uppercase' => 'حقل :attribute يجب أن يحتوي على أحرف كبيرة فقط.',
    'url' => 'حقل :attribute يجب أن يحتوي على رابط صحيح.',
    'ulid' => 'حقل :attribute يجب أن يحتوي على معرف ULID صحيح.',
    'uuid' => 'حقل :attribute يجب أن يحتوي على معرف UUID صحيح.',

    /*
    |--------------------------------------------------------------------------
    | السطور المخصصة
    |--------------------------------------------------------------------------
    |
    | يمكن استخدام السطور أدناه لإعداد رسائل مخصصة لقواعد التحقق على
    | خاصية معينة على الفور.
    |
    */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'رسالة مخصصة',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | أسماء مخصصة للخصائص
    |--------------------------------------------------------------------------
    |
    | يتم استخدام السطور أدناه لاستبدال الأسماء الإفتراضية للحقول
    | بنصوص مفهومة لدى المستخدم النهائي.
    |
    */
    'attributes' => [],

];
