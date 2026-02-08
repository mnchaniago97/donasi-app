<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BankAccountController extends Controller
{
    /**
     * Tampilkan daftar rekening bank
     */
    public function index()
    {
        $bankAccounts = BankAccount::all();
        return view('bank-accounts.index', compact('bankAccounts'));
    }

    /**
     * Tampilkan form tambah rekening
     */
    public function create()
    {
        return view('bank-accounts.create');
    }

    /**
     * Simpan rekening baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255|unique:bank_accounts',
            'account_holder_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qris_merchant_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle file upload untuk QRIS merchant
        if ($request->hasFile('qris_merchant_file')) {
            $file = $request->file('qris_merchant_file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/qris', $filename);
            $validated['qris_merchant_file'] = 'qris/' . $filename;
        }

        BankAccount::create($validated);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit rekening
     */
    public function edit(BankAccount $bankAccount)
    {
        return view('bank-accounts.edit', compact('bankAccount'));
    }

    /**
     * Update rekening
     */
    public function update(Request $request, BankAccount $bankAccount): RedirectResponse
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255|unique:bank_accounts,account_number,' . $bankAccount->id,
            'account_holder_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qris_merchant_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle file upload untuk QRIS merchant
        if ($request->hasFile('qris_merchant_file')) {
            // Delete old file jika ada
            if ($bankAccount->qris_merchant_file) {
                \Storage::disk('public')->delete($bankAccount->qris_merchant_file);
            }

            $file = $request->file('qris_merchant_file');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/qris', $filename);
            $validated['qris_merchant_file'] = 'qris/' . $filename;
        }

        $bankAccount->update($validated);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil diperbarui');
    }

    /**
     * Hapus rekening
     */
    public function destroy(BankAccount $bankAccount): RedirectResponse
    {
        $bankAccount->delete();
        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil dihapus');
    }
}
