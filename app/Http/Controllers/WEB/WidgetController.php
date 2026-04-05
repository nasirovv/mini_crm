<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;

/**
 * Class WidgetController
 * @package App\Http\Controllers
 */
class WidgetController extends Controller
{
    public function index()
    {
        return view('widget');
    }
}
