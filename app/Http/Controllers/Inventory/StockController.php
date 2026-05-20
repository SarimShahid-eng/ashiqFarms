<?php

namespace App\Http\Controllers\Inventory;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Inventory\Employees;
use App\Inventory\Employees_type;
use App\Inventory\Stock;
use App\Inventory\StockConsume;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index($id = '')
    {
        $stock_update = '';
        if (!empty($id)) {
            $stock_update = Stock::find($id);
        }
        $stock_consumes=StockConsume::all();
        $employees = Employees::with('type')->get();
        $stock_employees = Stock::with('employees.type')->get();

        return view('inventory.stock.index', compact('employees', 'stock_employees', 'stock_update','stock_consumes'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->update_id) {
            Stock::where('id', $request->update_id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'qty' => $request->qty,
                'stock_consume_id' => $request->stock_consume_id,
                'employees_id' => $request->employees_id
            ]);
            return response([
                'success'   => 'Employee Updated successfully',
                'redirect'  =>   route('inventory.stock.index'),
            ]);
        }
        Stock::create($request->all());
        return response()->json([
            'success'   => 'Stock Added successfully',
            'redirect'  => route('inventory.stock.index'),
        ]);
    }
    public function  delete($id)
    {
        Stock::destroy($id);
        return response()->json([
            'success'   => 'Stock Deleted successfully',
            'redirect'  => route('inventory.stock.index'),
        ]);
    }
    public function stock_consume($id = '')
    {
        $stock_consumes = StockConsume::all();
        $stock_consume_upd = '';
        if (!empty($id)) {
            $stock_consume_upd = StockConsume::find($id);
        }
        return view('inventory.stock.stock_consume', compact('stock_consumes', 'stock_consume_upd'));
    }
    public function stock_consume_store(Request $request)
    {
        if ($request->update_id) {
            StockConsume::where('id', $request->update_id)->update([
                'stock_consume' => $request->stock_consume
            ]);
            return response()->json([
                'success'   => 'Stock Updated successfully',
                'redirect'  => route('inventory.stock.stock_consume'),
            ]);
        }
        StockConsume::create($request->all());
        return response()->json([
            'success'   => 'Stock Added successfully',
            'redirect'  => route('inventory.stock.stock_consume'),
        ]);
    }
    public function stock_consume_delete($id)
    {
        StockConsume::destroy($id);
        return response()->json([
            'success'   => 'Stock Deleted successfully',
            'redirect'  => route('inventory.stock.stock_consume'),
        ]);
    }
}
