<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PromotionController extends Controller
{

    public function index()
    {
        $promotions = Promotion::with('menu')->get();
        return response()->json([
            'status' => 'success',
            'data' => $promotions
        ], 200);
    }

    public function store(Request $request)
    {

        Log::info('Request data:', $request->all());


        $validated = $request->validate([
            'menu_id' => 'required|integer',
            'discount' => 'required|numeric|min:0|max:100',
            'show_on_dashboard' => 'required|string|in:Tampilkan,Tidak Ditampilkan',
        ]);


        $menu = Menu::find($validated['menu_id']);
        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak Ditemukan.'
            ], 404);
        }


        $promotion = Promotion::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $promotion,
        ], 201);
    }




    public function show($id)
    {
        $promotion = Promotion::with('menu')->find($id);

        if (!$promotion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promotion not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $promotion
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $promotion = Promotion::find($id);

        if (!$promotion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promotion not found'
            ], 404);
        }


        $validated = $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'show_on_dashboard' => 'required|boolean',
            'discount' => 'required|numeric|min:0|max:100',
        ]);


        $promotion->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Promotion updated successfully',
            'data' => $promotion
        ], 200);
    }


    public function destroy($id)
    {
        $promotion = Promotion::find($id);

        if (!$promotion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promotion not found'
            ], 404);
        }

        $promotion->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Promotion deleted successfully'
        ], 200);
    }
}
