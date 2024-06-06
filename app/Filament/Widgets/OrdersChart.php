<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class OrdersChart extends ChartWidget
{
  protected static ?string $heading = 'Paid Orders (Last 7 days)';
  protected static ?int $sort = 1;

  protected function getData(): array
  {
    $orders = Order::where('boughtAt', '>=', now()->subDays(7))->where('status', 'paid')->get();

    $data = [];
    foreach ($orders as $order) {
      $date = Carbon::parse($order->boughtAt)->format('d F Y');

      if (!isset($data[$date])) {
        $data[$date] = 0;
      }

      $data[$date]++;
    }

    return [
      'datasets' => [
        [
          'label' => 'Orders',
          'data' => $data,
        ],
      ],
      'labels' => array_keys($data),
      'plugins' => [
        'legend' => [
          'display' => false,
        ],
      ],
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }
}
