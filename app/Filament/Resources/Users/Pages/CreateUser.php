<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // پسورد تصادفی و موقت — بعداً از دکمه «پسورد ریست» جایگزین میشه
        $data['password'] = Hash::make(Str::random(32));

        return $data;
    }
}
