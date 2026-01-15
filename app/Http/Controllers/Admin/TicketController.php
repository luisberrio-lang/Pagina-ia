<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function index(): View
    {
        $tickets = SupportTicket::with('user')
            ->latest()
            ->paginate(10);
        return view('admin.tickets', compact('tickets'));
    }
}
