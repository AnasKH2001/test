<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitsChart extends ChartWidget
{
    protected static ?string $heading = ' Monthly Profits ( last 12 month )';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Appointment::query()
            ->join('services', 'appointments.service_id', '=', 'services.id')

            ->where('appointments.status', 'completed')

            ->where('appointments.appointment_date', '>=', Carbon::now()->subYear())

            ->groupBy('month')

            ->orderBy('month', 'asc')

            ->select(
                DB::raw("DATE_FORMAT(appointment_date, '%Y-%m') as month"),
                DB::raw("SUM(services.cost) as total_profit")
            )
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'الأرباح',
                    'data' => $data->pluck('total_profit')->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                ],
            ],
            'labels' => $data->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // يمكنك تغييره إلى 'line' إذا أردت مخططاً خطياً
    }
}
