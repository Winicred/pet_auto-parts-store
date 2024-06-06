<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class NewUsersChart extends ChartWidget
{
  protected static ?string $heading = 'Registrations (Last 7 days)';
  protected static ?int $sort = 1;

  protected function getData(): array
  {
    $users = User::where('createdAt', '>=', now()->subDays(7))->get();

    $data = [];
    foreach ($users as $user) {
      $date = Carbon::parse($user->createdAt)->format('d F Y');

      if (!isset($data[$date])) {
        $data[$date] = 0;
      }

      $data[$date]++;
    }

    return [
      'datasets' => [
        [
          'label' => 'New Users',
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
