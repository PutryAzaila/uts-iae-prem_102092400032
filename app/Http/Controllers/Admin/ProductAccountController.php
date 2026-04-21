<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductAccountController extends Controller
{
    public function index(Product $product): JsonResponse
    {
        $accounts = $product->accounts()->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $accounts,
        ]);
    }

    public function store(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'in:available,sold'],
        ]);

        if (empty($validated['email']) && empty($validated['username'])) {
            return response()->json([
                'message' => 'Email atau username wajib diisi salah satu.'
            ], 422);
        }

        $account = $product->accounts()->create([
            'email' => $validated['email'] ?? null,
            'username' => $validated['username'] ?? null,
            'password' => $validated['password'],
            'status' => $validated['status'] ?? 'available',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Account berhasil ditambahkan.',
            'data' => $account,
        ], 201);
    }

    public function bulkStore(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'accounts' => ['required', 'array', 'min:1'],
            'accounts.*.email' => ['nullable', 'string', 'max:255'],
            'accounts.*.username' => ['nullable', 'string', 'max:255'],
            'accounts.*.password' => ['required', 'string', 'max:255'],
            'accounts.*.status' => ['nullable', 'in:available,sold'],
        ]);

        $created = [];

        foreach ($validated['accounts'] as $item) {
            if (empty($item['email']) && empty($item['username'])) {
                continue;
            }

            $created[] = $product->accounts()->create([
                'email' => $item['email'] ?? null,
                'username' => $item['username'] ?? null,
                'password' => $item['password'],
                'status' => $item['status'] ?? 'available',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Bulk account berhasil ditambahkan.',
            'data' => $created,
        ], 201);
    }

    public function update(Request $request, ProductAccount $account): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'in:available,sold'],
        ]);

        if (empty($validated['email']) && empty($validated['username'])) {
            return response()->json([
                'message' => 'Email atau username wajib diisi salah satu.'
            ], 422);
        }

        $account->update([
            'email' => $validated['email'] ?? null,
            'username' => $validated['username'] ?? null,
            'password' => $validated['password'],
            'status' => $validated['status'] ?? $account->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Account berhasil diupdate.',
            'data' => $account->fresh(),
        ]);
    }

    public function destroy(ProductAccount $account): JsonResponse
    {
        $account->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Account berhasil dihapus.',
        ]);
    }
}