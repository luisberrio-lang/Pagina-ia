<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupportTicketRequest;
use App\Models\SupportTicket;

class SupportTicketController extends Controller
{
    public function store(StoreSupportTicketRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        SupportTicket::create($data);

        return back()->with('ok', '✅ Ticket enviado correctamente.');
    }
}
