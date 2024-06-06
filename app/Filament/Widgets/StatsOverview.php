<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

  protected static ?int $sort = 0;
  protected function getStats(): array
  {
    $ordersCount = Order::where('status', 'paid')->count();
    $revenue = number_format(Order::where('status', 'paid')->sum('amount') / 100, 2);
    $averageOrderValue = $ordersCount > 0 ? number_format($revenue / $ordersCount, 2) : 0;

    return [
      Stat::make('Total Orders', $ordersCount),
      Stat::make('Total Revenue', "$$revenue"),
      Stat::make('Average Order Value', $averageOrderValue),
    ];
  }
}
