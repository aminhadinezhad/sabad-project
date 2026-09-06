<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AnalyticsHeading extends Widget
{
    protected string $view = 'filament.widgets.analytics-heading';

    protected int|string|array $columnSpan = 'full';
}
