<?php

namespace App\Http\Controllers;

use App\Models\IncomeAndOutcome;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(IncomeAndOutcome $incomeAndOutcome)
    {
        $totalIncomes = $incomeAndOutcome->getTotalAmount('income');
        $totalOutcomes = $incomeAndOutcome->getTotalAmount('outcome');

        $dayArray = $incomeAndOutcome->getDayArray('day');
        $incomeAmount = $incomeAndOutcome->getDayArray('income');
        $outcomeAmount = $incomeAndOutcome->getDayArray('outcome');

        $data = $incomeAndOutcome->orderBy('id', 'desc')->paginate(3);
        return view('home', compact('data', 'totalIncomes', 'totalOutcomes', 'dayArray', 'incomeAmount', 'outcomeAmount'));
    }

    public function store(IncomeAndOutcome $incomeAndOutcome, Request $request)
    {
        $data = $request->validate([
            'topic' => 'required|max:255',
            'date' => 'required|date',
            'type' => 'required',
            'amount' => 'required|integer'
        ]);
        $incomeAndOutcome->create($data);
        return redirect()->back()->with('success', 'Data stored!');
    }
}
