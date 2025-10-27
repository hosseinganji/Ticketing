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
    
*   Node.js و npm (در صورت نیاز به ساخت assetها)
    
*   Git
    

### ۲. کلون و نصب پکیج‌ها

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   git clone https://github.com/yourusername/ticketing.git  cd ticketing  composer install   `

### ۳. تنظیم فایل محیطی .env

فایل .env.example را کپی کرده و به .env تغییر نام دهید:

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   cp .env.example .env   `

مقادیر مهم برای این پروژه:

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   APP_NAME="Ticketing System"  APP_ENV=local  APP_KEY=  APP_DEBUG=true  APP_URL=http://localhost:8000  DB_CONNECTION=mysql  DB_HOST=127.0.0.1  DB_PORT=3306  DB_DATABASE=ticketing  DB_USERNAME=root  DB_PASSWORD=  QUEUE_CONNECTION=database  MAIL_MAILER=log   `

سپس کلید اپلیکیشن را بساز:

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan key:generate   `

### ۴. ساخت جدول‌ها و لینک storage

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan migrate  php artisan storage:link   `

### ۵. ساخت ادمین‌ها

Seeder مخصوص ادمین‌ها را اجرا کن:

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan db:seed --class=AdminsSeeder   `

اکنون دو ادمین پیش‌فرض ساخته می‌شوند 👇

نقشایمیلرمز عبورسطحAdmin 1admin1@gmail.com123456سطح ۱Admin 2admin2@gmail.com123456سطح ۲

### ۶. اجرای سرویس‌ها

**اجرای سرور اصلی:**

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan serve   `

**اجرای صف (Queue Worker):**

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan queue:work   `

**اجرای زمان‌بندی (Scheduler):**

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan schedule:work   `

### ۷. اجرای تست‌ها

برای اطمینان از صحت عملکرد گردش کار تیکت:

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan test   `

🧩 ساختار پروژه
---------------

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   app/   ├── Enums/              # شامل Enum وضعیت تیکت‌ها   ├── Http/   │    ├── Controllers/   # کنترلرهای اصلی سیستم   │    ├── Middleware/   ├── Models/             # مدل‌های اصلی مثل Ticket, User   └── ...  database/   ├── factories/          # فایل‌های فکتوری برای داده‌های تستی   ├── seeders/            # ایجاد داده اولیه (AdminsSeeder)  resources/   ├── views/              # قالب‌ها (پنل ادمین، تیکت‌ها)   └── ...  routes/   ├── web.php             # مسیرهای وب   └── api.php             # مسیرهای API در صورت وجود   `

⚙️ معماری و منطق گردش کار
-------------------------

1.  **کاربر** تیکت ایجاد می‌کند (وضعیت: draft → submitted)
    
2.  **ادمین ۱** تیکت را بررسی می‌کند:
    
    *   اگر تایید کند → approved\_by\_admin1
        
    *   اگر رد کند → rejected\_by\_admin1
        
3.  **ادمین ۲** در صورت تایید Admin1 تیکت را بررسی می‌کند:
    
    *   تایید → approved\_by\_admin2
        
    *   رد → rejected\_by\_admin2
        
4.  در نهایت، تیکت در صورت تایید کامل به وب‌سرویس ارسال می‌شود (sent\_to\_webservice).
    

🧠 فهرست قابلیت‌ها
------------------

*   احراز هویت کاربران و ادمین‌ها
    
*   سطوح دسترسی چندمرحله‌ای (Admin1, Admin2)
    
*   ایجاد، مشاهده، و مدیریت تیکت‌ها
    
*   آپلود فایل ضمیمه
    
*   صف (Queue) برای وظایف پس‌زمینه
    
*   سیستم زمان‌بندی (Scheduler)
    
*   نمایش وضعیت هر تیکت بر اساس Enum
    
*   تست واحد (Unit Test) برای منطق گردش کار تیکت‌ها
    
*   رابط کاربری با Bootstrap 5 و فونت فارسی Vazir
    

💡 فرضیات طراحی
---------------

*   هر تیکت ابتدا توسط Admin1 بررسی می‌شود و تنها در صورت تایید به Admin2 می‌رسد.
    
*   فقط Admin2 می‌تواند تصمیم نهایی را بگیرد.
    
*   تمام عملیات حساس (تغییر وضعیت، تایید، رد) در سطح سرور انجام می‌شود.
    
*   فایل‌ها در مسیر storage/app/public ذخیره و با php artisan storage:link در دسترس قرار می‌گیرند.
    
*   ارتباط بین Laravel و پایگاه داده از نوع MySQL است، ولی می‌توان آن را تغییر داد.
