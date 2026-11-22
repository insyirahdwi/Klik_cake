<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Networking;
use Illuminate\View\View;

class NetworkingController extends Controller
{
    public function index(): View
    {
        $outlets = Networking::outlets()->get();
        $partners = Networking::partners()->get();
        $socials = Networking::social()->get();

        return view('shop.networkings.index', compact('outlets', 'partners', 'socials'));
    }
}
