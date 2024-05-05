<?php

namespace App\Http\Controllers;

use App\Action\PaydayAction;
use Illuminate\Http\Request;

class PaydayController extends Controller
{
    public function __construct(private readonly PaydayAction $payday) {}

    public function store(Request $request)
    {
        $this->payday->execute();
        return response()->noContent();
    }
}
