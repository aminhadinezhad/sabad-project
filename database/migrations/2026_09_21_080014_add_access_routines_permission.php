<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * دسترسی «روتین‌های فروشگاه آنلاین» را به فهرست دسترسی‌های ادمین‌ها اضافه می‌کند.
     * فقط یک ردیف در جدول permissions می‌سازد (اگر از قبل نباشد) و به هیچ کاربری داده نمی‌شود؛
     * از بخش «ادمین‌ها» برای هر کس لازم است تیک زده می‌شود.
     */
    public function up(): void
    {
        Permission::findOrCreate('access_routines', 'web');
    }

    public function down(): void
    {
        Permission::where('name', 'access_routines')->where('guard_name', 'web')->first()?->delete();
    }
};
