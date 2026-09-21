<?php

namespace Tests\Feature;

use App\Filament\Pages\OnlineStoreRoutines;
use App\Models\Product;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Reader\XLSX\Reader;
use OpenSpout\Writer\XLSX\Writer;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class OnlineStoreRoutinesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('admin');
        // the access_routines permission itself comes from its migration
    }

    private function admin(bool $canUseRoutines = true): User
    {
        $user = User::factory()->create(['has_access' => true]);

        if ($canUseRoutines) {
            $user->givePermissionTo('access_routines');
        }

        return $user;
    }

    private function product(string $name, int $price): Product
    {
        return Product::create(['name' => $name, 'category' => 'rice', 'price' => $price]);
    }

    /**
     * @param  list<list<mixed>>  $rows  سطرهای بعد از عنوان
     */
    private function excel(array $rows): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'test').'.xlsx';
        $writer = new Writer;
        $writer->openToFile($path);
        $writer->addRow(Row::fromValues(OnlineStoreRoutines::HEADINGS));
        foreach ($rows as $row) {
            $writer->addRow(Row::fromValues($row));
        }
        $writer->close();

        return UploadedFile::fake()->createWithContent('prices.xlsx', file_get_contents($path));
    }

    public function test_page_is_reachable_only_with_routines_permission(): void
    {
        $this->actingAs($this->admin())->get('/admin/routines')
            ->assertOk()
            ->assertSee('بروز رسانی قیمت کالا - بالک');

        $this->actingAs($this->admin(canUseRoutines: false))->get('/admin/routines')
            ->assertForbidden();
    }

    public function test_routines_permission_is_a_tickable_option_in_the_admins_form(): void
    {
        $admin = User::factory()->create(['has_access' => true]);
        $admin->givePermissionTo(Permission::findOrCreate('access_admins', 'web'));

        $this->actingAs($admin)->get('/admin/users/create')
            ->assertOk()
            ->assertSee('دسترسی به روتین‌های فروشگاه آنلاین');
    }

    public function test_export_lists_every_product_with_its_price(): void
    {
        $this->actingAs($this->admin());
        $rice = $this->product('برنج هاشمی', 150000);
        $beans = $this->product('لوبیا قرمز', 90000);

        $response = Livewire::test(OnlineStoreRoutines::class)->call('exportPrices');
        $response->assertFileDownloaded();

        $file = $response->effects['download'];
        $path = tempnam(sys_get_temp_dir(), 'dl').'.xlsx';
        file_put_contents($path, base64_decode($file['content']));

        $reader = new Reader;
        $reader->open($path);
        $rows = [];
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $rows[] = $row->toArray();
            }
        }
        $reader->close();

        $this->assertSame(OnlineStoreRoutines::HEADINGS, $rows[0]);
        $this->assertEquals([$rice->id, 'ندارد', 'برنج هاشمی', 150000], $rows[1]);
        $this->assertEquals([$beans->id, 'ندارد', 'لوبیا قرمز', 90000], $rows[2]);
    }

    public function test_import_updates_prices_from_fourth_column(): void
    {
        $this->actingAs($this->admin());
        $rice = $this->product('برنج هاشمی', 150000);
        $beans = $this->product('لوبیا قرمز', 90000);
        $lentils = $this->product('عدس', 70000);

        Livewire::test(OnlineStoreRoutines::class)
            ->set('excelFile', $this->excel([
                [$rice->id, 'ندارد', 'برنج هاشمی', 175000],
                [$beans->id, 'ندارد', 'لوبیا قرمز', '۹۵,۰۰۰'],
                [$lentils->id, 'ندارد', 'عدس', 70000],
                ['', '', '', ''],
            ]))
            ->call('importPrices')
            ->assertHasNoErrors()
            ->assertSet('importErrors', [])
            ->assertNotified('قیمت‌ها بروزرسانی شد');

        $this->assertSame(175000, (int) $rice->fresh()->price);
        $this->assertSame(95000, (int) $beans->fresh()->price);
        $this->assertSame(70000, (int) $lentils->fresh()->price);
    }

    public function test_a_single_bad_row_changes_nothing(): void
    {
        $this->actingAs($this->admin());
        $rice = $this->product('برنج هاشمی', 150000);
        $beans = $this->product('لوبیا قرمز', 90000);

        Livewire::test(OnlineStoreRoutines::class)
            ->set('excelFile', $this->excel([
                [$rice->id, 'ندارد', 'برنج هاشمی', 175000],
                [$beans->id, 'ندارد', 'لوبیا قرمز', 'نامشخص'],
                [99999, 'ندارد', 'کالای ناموجود', 1000],
                [$rice->id, 'ندارد', 'برنج هاشمی', 180000],
                [$beans->id, 'ندارد', 'لوبیا قرمز', 0],
            ]))
            ->call('importPrices')
            ->assertSet('importErrors', [
                'سطر ۳: قیمت در ستون چهارم باید یک عدد صحیح بیشتر از صفر باشد.',
                'سطر ۵: این کالا در فایل تکراری است.',
                'سطر ۶: قیمت در ستون چهارم باید یک عدد صحیح بیشتر از صفر باشد.',
            ])
            ->assertNotified('هیچ قیمتی تغییر نکرد');

        $this->assertSame(150000, (int) $rice->fresh()->price);
        $this->assertSame(90000, (int) $beans->fresh()->price);
    }

    public function test_rows_of_deleted_products_are_skipped_like_the_main_site(): void
    {
        $this->actingAs($this->admin());
        $rice = $this->product('برنج هاشمی', 150000);
        $removed = $this->product('کالای حذف‌شده', 50000);
        $removedId = $removed->id;
        $removed->delete();

        Livewire::test(OnlineStoreRoutines::class)
            ->set('excelFile', $this->excel([
                [$rice->id, 'ندارد', 'برنج هاشمی', 175000],
                [$removedId, 'ندارد', 'کالای حذف‌شده', 60000],
            ]))
            ->call('importPrices')
            ->assertSet('importErrors', [])
            ->assertNotified(
                Notification::make()
                    ->title('قیمت‌ها بروزرسانی شد')
                    ->body('قیمت ۱ کالا تغییر کرد و ۰ کالا بدون تغییر ماند. ۱ سطر مربوط به کالای حذف‌شده بود و نادیده گرفته شد (سطر ۳).')
                    ->success()
                    ->persistent()
            );

        $this->assertSame(175000, (int) $rice->fresh()->price);
        $this->assertNull(Product::find($removedId));
    }

    public function test_file_with_only_deleted_products_changes_nothing(): void
    {
        $this->actingAs($this->admin());
        $rice = $this->product('برنج هاشمی', 150000);

        Livewire::test(OnlineStoreRoutines::class)
            ->set('excelFile', $this->excel([[99999, 'ندارد', 'کالای ناموجود', 1000]]))
            ->call('importPrices')
            ->assertSet('importErrors', ['هیچ‌کدام از کالاهای فایل در سبد وجود ندارند؛ فایل را دوباره از همین صفحه دانلود کنید.']);

        $this->assertSame(150000, (int) $rice->fresh()->price);
    }

    public function test_each_successful_import_replaces_the_saved_file(): void
    {
        Storage::fake('local');
        $this->actingAs($this->admin());
        $rice = $this->product('برنج هاشمی', 150000);

        $first = $this->excel([[$rice->id, 'ندارد', 'برنج هاشمی', 160000]]);
        $second = $this->excel([[$rice->id, 'ندارد', 'برنج هاشمی', 170000]]);

        Livewire::test(OnlineStoreRoutines::class)->set('excelFile', $first)->call('importPrices');
        Livewire::test(OnlineStoreRoutines::class)->set('excelFile', $second)->call('importPrices');

        Storage::disk('local')->assertExists(OnlineStoreRoutines::LAST_IMPORT_PATH);
        $this->assertSame([OnlineStoreRoutines::LAST_IMPORT_PATH], Storage::disk('local')->files('price-imports'));
        $this->assertSame(file_get_contents($second->getRealPath()), Storage::disk('local')->get(OnlineStoreRoutines::LAST_IMPORT_PATH));

        // A rejected file changes no price and leaves the saved file alone.
        Livewire::test(OnlineStoreRoutines::class)
            ->set('excelFile', $this->excel([[$rice->id, 'ندارد', 'برنج هاشمی', 'نامشخص']]))
            ->call('importPrices');

        $this->assertSame(file_get_contents($second->getRealPath()), Storage::disk('local')->get(OnlineStoreRoutines::LAST_IMPORT_PATH));
        $this->assertSame(170000, (int) $rice->fresh()->price);
    }

    public function test_import_requires_an_xlsx_file(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(OnlineStoreRoutines::class)
            ->call('importPrices')
            ->assertHasErrors(['excelFile' => 'required']);

        Livewire::test(OnlineStoreRoutines::class)
            ->set('excelFile', UploadedFile::fake()->createWithContent('prices.csv', "1,x,y,100\n"))
            ->call('importPrices')
            ->assertHasErrors(['excelFile' => 'mimes']);
    }
}
