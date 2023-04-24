<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeAndOutcome extends Model
{
    use HasFactory;

    protected $fillable = ['topic', 'date', 'amount', 'type'];

    public function getTotalAmount($params)
    {
        $totalIncomes = 0;
        $totalOutcomes = 0;
        $currentDate = now()->format('Y-m-d');
        $incomeAndOutcomes = $this->where('date', $currentDate)->get();
        foreach ($incomeAndOutcomes as $inAndOut) {
            if ($inAndOut->type == 'income' && $params == 'income') {
                $totalIncomes += $inAndOut->amount;
            } else {
                $totalOutcomes += $inAndOut->amount;
            }
        }
        if ($params == 'income') {
            return $totalIncomes;
        }
        return $totalOutcomes;
    }

    public function getDayArray($params): array
    {
        $dayArray = [date('D')];
        $yearArray = [
            [
                'year' => date('Y'),
                'month' => date('m'),
                'day' => date('d'),
            ]
        ];

        for ($i = 1; $i <= 6; $i++) {
            $dayArray[] = date('D', strtotime("-$i day"));

            $newYear = [
                'year' => date('Y', strtotime("-$i day")),
                'month' => date('m', strtotime("-$i day")),
                'day' => date('d', strtotime("-$i day")),
            ];
            $yearArray[] = $newYear;
        }

        foreach ($yearArray as $y) {
            $incomeAmount[] = $this->whereYear('date', $y['year'])
                ->whereMonth('date', $y['month'])
                ->whereDay('date', $y['day'])
                ->whereType('income')
                ->sum('amount');
            $outcomeAmount[] = $this->whereYear('date', $y['year'])
                ->whereMonth('date', $y['month'])
                ->whereDay('date', $y['day'])
                ->whereType('outcome')
                ->sum('amount');
        }

        if ($params == 'day') {
            return $dayArray;
        } elseif ($params == 'income') {
            return $incomeAmount;
        }
        return $outcomeAmount;
    }
}
