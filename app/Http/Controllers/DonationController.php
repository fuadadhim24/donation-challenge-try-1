<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount'     => 'required|numeric|min:1000',
            'message'    => 'nullable|string|max:500',
        ]);

        $project = Project::findOrFail($validated['project_id']);

        $donation = Donation::create([
            'user_id'    => Auth::id(),
            'project_id' => $validated['project_id'],
            'amount'     => $validated['amount'],
            'message'    => $validated['message'],
            'currency' => 'IDR',
        ]);

        $project->increment('collection_amount', $validated['amount']);

        $donation->project->increment('collection_amount', $donation->amount);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil, terima kasih telah berdonasi!',
            'project' => $project->fresh(),
        ]);
    }
}
