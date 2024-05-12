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
            $result[$day] = ['day' => $day, 'posts' => 0, 'users' => 0, 'approved' => 0, 'activated' => 0]; 
        }
        if ($type === 'posts') {
            $posts = Post::select('created_at', 'status')
                ->where('status', Post::APPROVED) 
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
            foreach ($posts as $post) {
                $day = Carbon::parse($post->created_at)->format('Y-m-d');
                if (isset($result[$day])) {
                    $result[$day]['posts']++;
                    $result[$day]['approved']++; 
                }
            }
        } elseif ($type === 'users') {
            $users = User::select('created_at', 'status')
                ->where('status', User::ACTIVATED) 
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            foreach ($users as $user) {
                $day = Carbon::parse($user->created_at)->format('Y-m-d');
                if (isset($result[$day])) {
                    $result[$day]['users']++;
                    $result[$day]['activated']++; 
                }
            }
        }
        return array_values($result);
    }
}
