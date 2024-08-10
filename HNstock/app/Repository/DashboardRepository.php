<?php

namespace App\Repository;

use App\Enums\TimeBreakdown;
use App\Models\Sale;

class DashboardRepository
{

    protected function salesQueryBase(TimeBreakdown $timeBreakdown)
    {
        $period = $timeBreakdown->getPeriod();
        return Sale::whereBetween('DateFact', [
            $period->start,
            $period->end,
        ]);
    }


    protected function getSalesSummary(TimeBreakdown $timeBreakdown): int
    {
        return $this
            ->salesQueryBase($timeBreakdown)
            ->get('mttc')
            ->sum('mttc') ?? 0;
    }

    protected function getOrders(TimeBreakdown $timeBreakdown): int
    {
        return $this->salesQueryBase($timeBreakdown)->count();
    }


    public function getSummary(TimeBreakdown $timeBreakdown): array
    {
        return [
            "sales" => $this->getSalesSummary($timeBreakdown),
            "orders" => $this->getOrders($timeBreakdown),
            "totalPurchases" => 0, // TODO : change when the provider is ready
            "purchases" => 0 // TODO : change when the provider is ready
        ];
    }
}
