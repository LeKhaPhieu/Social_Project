<?php

namespace App\Service\Admin;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HomeService
{
    public function filter(array $data, string $type): array
    {
        $endDate = isset($data['end_date']) 
            ? Carbon::parse($data['end_date']) : Carbon::now();
        $startDate = isset($data['start_date']) 
            ? Carbon::parse($data['start_date']) : $endDate->copy()
            ->subDays(config('length.default_time_period'));
        return $this->statistics($type, $startDate, $endDate);
    }

    public function statistics(string $type, $startDate, $endDate): array
    {
        $result = [];
        $dateRange = Carbon::parse($startDate)->range($endDate)->toArray();
        foreach ($dateRange as $date) {
            $day = $date->format('Y-m-d');
            $result[$day] = ['day' => $day, $type => 0];
        }
        $model = $type === 'posts' ? Post::class : User::class;
        $items = $model::select('created_at')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        foreach ($items as $item) {
            $day = Carbon::parse($item->created_at)->format('Y-m-d');
            if (isset($result[$day])) {
                $result[$day][$type]++;
            }
        }
        return array_values($result);
    }
}
