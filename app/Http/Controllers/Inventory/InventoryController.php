<?php

namespace App\Http\Controllers\Inventory;
use App\Http\Controllers\Controller;

use DB;
class InventoryController extends Controller
{
    function index(){
return view('inventory.index');
    }
}
