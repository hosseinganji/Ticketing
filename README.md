سامانه تیکتینگ Laravel
=========================

این پروژه یک سامانه تیکتینگ (مدیریت درخواست‌ها) است که با فریم‌ورک **Laravel** توسعه داده شده است.کاربران می‌توانند تیکت ارسال کنند و دو سطح ادمین (Admin1 و Admin2) وظیفه‌ی بررسی، تأیید یا رد تیکت‌ها را دارند.

راهنمای نصب و اجرا
---------------------

### ۱. پیش‌نیازها

اطمینان حاصل کنید که موارد زیر روی سیستم شما نصب هستند:

*   PHP >= 8.1
*   Composer
*   MySQL یا MariaDB
*   Git
    

### ۲. کلون و نصب پکیج‌ها

`git clone https://github.com/hosseinganji/Ticketing.git  cd ticketing  composer install`

### ۳. تنظیم فایل محیطی .env

فایل .env.example را کپی کرده و به .env تغییر نام دهید:

`cp .env.example .env`

مقادیر مهم برای این پروژه:

`QUEUE_CONNECTION=databas`
`MAIL_MAILER=log`

سپس کلید اپلیکیشن را بساز:

`php artisan key:generate`

### ۴. ساخت جدول‌ها و لینک storage

`php artisan migrate  php artisan storage:link`

### ۵. ساخت ادمین‌ها

Seeder مخصوص ادمین‌ها را اجرا کن:

`php artisan db:seed --class=AdminsSeeder`

اکنون دو ادمین پیش‌فرض ساخته می‌شوند 👇

Admin 1
email: admin1@gmail.com
password: 123456
----------
Admin 2
gmail: admin2@gmail.com
password: 123456

### ۶. اجرای سرویس‌ها

**اجرای سرور اصلی:**

`php artisan serve`

**اجرای صف (Queue Worker):**

`php artisan queue:work`

**اجرای زمان‌بندی (Scheduler):**

`php artisan schedule:work`

### ۷. اجرای تست‌ها

برای اطمینان از صحت عملکرد گردش کار تیکت:

`php artisan test`

⚙️ معماری و منطق گردش کار
-------------------------

1.  **کاربر** تیکت ایجاد می‌کند (وضعیت: draft → submitted)
    
2.  **ادمین ۱** تیکت را بررسی می‌کند:
    
اگر تایید کند → approved\_by\_admin1
        
اگر رد کند → rejected\_by\_admin1
        
3.  **ادمین ۲** در صورت تایید Admin1 تیکت را بررسی می‌کند:
    
تایید → approved\_by\_admin2
        
رد → rejected\_by\_admin2
        
4.  در نهایت، تیکت در صورت تایید کامل به وب‌سرویس ارسال می‌شود (sent\_to\_webservice).
    

    

💡 فرضیات طراحی
---------------

*   هر تیکت ابتدا توسط Admin1 بررسی می‌شود و تنها در صورت تایید به Admin2 می‌رسد.
    
*   فقط Admin2 می‌تواند تصمیم نهایی را بگیرد.
    
*   تمام عملیات حساس (تغییر وضعیت، تایید، رد) در سطح سرور انجام می‌شود.
    
*   فایل‌ها در مسیر storage/app/public ذخیره و با php artisan storage:link در دسترس قرار می‌گیرند.
    
*   ارتباط بین Laravel و پایگاه داده از نوع MySQL است، ولی می‌توان آن را تغییر داد.
