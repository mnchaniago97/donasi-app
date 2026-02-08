<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    /**
     * Display a listing of campaigns.
     */
    public function index()
    {
        $campaigns = Campaign::active()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Display campaign detail.
     */
    public function show(Campaign $campaign)
    {
        $campaign->load('donations.campaign', 'updates');
        $topDonors = $campaign->getTopDonors(5);
        $donorCount = $campaign->getDonorCount();

        return view('campaigns.show', compact('campaign', 'topDonors', 'donorCount'));
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create()
    {
        $categories = [
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'bencana' => 'Bencana Alam',
            'kemanusiaan' => 'Kemanusiaan',
            'yatim-piatu' => 'Anak Yatim/Piatu',
            'pesantren' => 'Pesantren/Sekolah',
            'lainnya' => 'Lainnya',
        ];

        return view('campaigns.create', compact('categories'));
    }

    /**
     * Store a newly created campaign in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'story' => 'required|string|min:50',
            'category' => 'required|in:kesehatan,pendidikan,bencana,kemanusiaan,yatim-piatu,pesantren,lainnya',
            'target_amount' => 'required|numeric|min:100000',
            'deadline' => 'required|date|after:now',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'recipient_name' => 'required|string|max:255',
            'recipient_info' => 'required|string|min:20',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('campaigns', 'public');
            $validated['image'] = $path;
        }

        $validated['current_amount'] = 0;
        $validated['status'] = 'active';

        Campaign::create($validated);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign berhasil dibuat!');
    }

    /**
     * Show the form for editing the campaign.
     */
    public function edit(Campaign $campaign)
    {
        $categories = [
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'bencana' => 'Bencana Alam',
            'kemanusiaan' => 'Kemanusiaan',
            'yatim-piatu' => 'Anak Yatim/Piatu',
            'pesantren' => 'Pesantren/Sekolah',
            'lainnya' => 'Lainnya',
        ];

        return view('campaigns.edit', compact('campaign', 'categories'));
    }

    /**
     * Update the campaign in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'story' => 'required|string|min:50',
            'category' => 'required|in:kesehatan,pendidikan,bencana,kemanusiaan,yatim-piatu,pesantren,lainnya',
            'target_amount' => 'required|numeric|min:100000',
            'deadline' => 'required|date|after:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'recipient_name' => 'required|string|max:255',
            'recipient_info' => 'required|string|min:20',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        if ($request->hasFile('image')) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            $path = $request->file('image')->store('campaigns', 'public');
            $validated['image'] = $path;
        }

        $campaign->update($validated);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campaign berhasil diupdate!');
    }

    /**
     * Delete the campaign.
     */
    public function destroy(Campaign $campaign)
    {
        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }

        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign berhasil dihapus!');
    }

    /**
     * Store campaign update.
     */
    public function storeUpdate(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:20',
        ]);

        $campaign->updates()->create($validated);

        return back()->with('success', 'Update campaign berhasil ditambahkan!');
    }
}
