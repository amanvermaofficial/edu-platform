<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TradeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTradeRequest;
use App\Http\Requests\Admin\TradeUpdateRequest;
use App\Models\Trade;
use App\Services\Admin\TradeService;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    protected $service;

    public function __construct(TradeService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(TradeDataTable $dataTable)
    {
        return $dataTable->render('admin.trades.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTradeRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.trades.index')->with('success', 'Trade created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trade $trade)
    {
        return view('admin.trades.edit', compact('trade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TradeUpdateRequest $request, Trade $trade)
    {
        $this->service->update($trade, $request->validated());
        return redirect()->route('admin.trades.index')->with('success', 'Trade updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trade $trade)
    {
        $this->service->delete($trade);
        return redirect()->route('admin.trades.index')->with('success', 'Trade deleted successfully.');
    }
}
