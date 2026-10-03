<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketReply;

class TicketReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string',
            'lampiran' => 'nullable|string'
        ]);

        $reply = TicketReply::create([
            'ticket_id' => $ticketId,
            'user_id' => $request->user()->id, // User yang mengirim balasan
            'pesan' => $request->pesan,
            'lampiran' => $request->lampiran
        ]);

        $reply->load('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Balasan terkirim',
            'data' => $reply
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
