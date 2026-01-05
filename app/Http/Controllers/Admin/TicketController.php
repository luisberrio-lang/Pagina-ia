<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::latest()->paginate(10);
        return view('admin.tickets', compact('tickets'));
    }
}
