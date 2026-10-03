<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with(['user','agent', 'kategori', 'departemen',])->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $tickets
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori_kendalas,id',
            'departemen_id' => 'required|exists:departemen_tujuans,id',
            'subjek' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'prioritas' => 'in:low,medium,high,urgent',
            'lampiran' => 'nullable|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors() 
            ],422);
        }

        $ticketCode = 'TICK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

        $ticket = Ticket::create([
            'ticket_code' => $ticketCode,
            'user_id' => $request->user()->id,
            'kategori_id' => $request->kategori_id,
            'departemen_id' => $request->departemen_id,
            'subjek' => $request->subjek,
            'deskripsi' => $request->deskripsi,
            'prioritas' => $request->prioritas ?? 'medium',
            'status' => 'open',
            'lampiran' => $request->lampiran
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tiket berhasil dibuat',
            'data' => $ticket
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'agent', 'kategori', 'departemen', 'replies.user'])->findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => $ticket
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update([

            'status' => $request->status ?? $ticket->status,
            'assigned_to' => $request->assigned_to ?? $ticket->assigned_to,
            'prioritas' => $request->prioritas ?? $ticket->prioritas
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tiket berhasil diperbarui',
            'data' => $ticket
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tiket berhasil dihapus'
        ], 200);
    }
}
