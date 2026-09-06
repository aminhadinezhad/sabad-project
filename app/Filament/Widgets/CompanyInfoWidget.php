<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CompanyInfoWidget extends Widget
{
    protected string $view = 'filament.widgets.company-info-widget';

    protected int|string|array $columnSpan = 1;
}
