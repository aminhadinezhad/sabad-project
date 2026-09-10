<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Brand;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('اطلاعات محصول')
                    ->description('تمام فیلدهای این پنل، الزامی هستند.')
                    ->columns(3)
                    ->columnSpanFull()
                    ->components([
                        TextInput::make('name')
                            ->label('نام محصول')
                            ->required()
                            ->dehydrateStateUsing(fn($state) => trim($state))
                            ->rules([
                                fn($record) => function (string $attribute, $value, \Closure $fail) use ($record) {
                                    $exists = Product::where('name', trim($value))
                                        ->when($record, fn($q) => $q->where('id', '!=', $record->id))
                                        ->exists();

                                    if ($exists) {
                                        $fail('محصولی با این نام از قبل وجود دارد.');
                                    }
                                },
                            ]),

                        TextInput::make('code')
                            ->label('کدینگ')
                            ->required()
                            ->numeric()
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'کدینگ باید منحصر به فرد باشد.',
                            ])
                            ->default(fn() => (Product::max('code') ?? 0) + 1),

                        Select::make('category')
                            ->label('دسته‌بندی')
                            ->required()
                            ->options([
                                'rice' => 'برنج',
                                'legumes' => 'حبوبات',
                                'groceries' => 'خواربار',
                            ]),

                        Select::make('brand_id')
                            ->label('برند/سازنده')
                            ->required()
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->validationMessages([
                                'required' => 'انتخاب برند/سازنده الزامی است.',
                            ])
                            ->default(fn() => Brand::where('name', 'ساخت ایران')->first()?->id),

                        Select::make('unit')
                            ->label('واحد')
                            ->required()
                            ->options([
                                'بسته' => 'بسته',
                                'بطری' => 'بطری',
                                'جعبه' => 'جعبه',
                                'جین' => 'جین',
                                'دستگاه' => 'دستگاه',
                                'عدد' => 'عدد',
                                'کارتن' => 'کارتن',
                                'کیلوگرم' => 'کیلوگرم',
                                'گالن' => 'گالن',
                            ]),

                        TextInput::make('price')
                            ->label('قیمت')
                            ->required()
                            ->numeric(),

                        Toggle::make('vat_enabled')
                            ->label('قیمت با مالیات بر ارزش افزوده باشد؟')
                            ->helperText('در صورت فعال بودن، مالیات بر ارزش افزوده به قیمت پایه اضافه می‌شود.')
                            ->live(),

                        TextInput::make('vat_percentage')
                            ->label('درصد مالیات بر ارزش افزوده')
                            ->numeric()
                            ->suffix('%')
                            ->visible(fn($get) => $get('vat_enabled')),
                    ]),

                Section::make('عکس های محصول')
                    ->columnSpanFull()
                    ->components([
                        FileUpload::make('image')
                            ->label('تصویر محصول')
                            ->image()
                            ->disk('public')
                            ->directory('products'),
                    ]),
            ]);
    }
}
