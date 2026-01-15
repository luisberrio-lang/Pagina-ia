<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\SupportTicket;

class SupportTicketController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'subject' => ['required', 'string', 'max:140'],
            'message' => ['required', 'string'],
        ]);

        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
        }

        $data['status'] = 'abierto';

        SupportTicket::create($data);

        return back()->with('ok', '✅ Ticket enviado. Te responderemos pronto.');
    }
}
