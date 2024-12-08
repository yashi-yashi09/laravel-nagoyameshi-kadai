<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;


class RestaurantController extends Controller
{

     //店舗一覧ページ
    public function index(Request $request)
    {
        // 検索ボックスに入力されたキーワードを取得する
        $keyword = $request->input('keyword');
 
        // キーワードが存在すれば検索を行い、そうでなければ全件取得する
        if ($keyword !== null) {
            $restaurants = Restaurant::where('name', 'like', "%{$keyword}%")->paginate(15);
        } else {
            $restaurants = Restaurant::paginate(15);
        }

        $total = $restaurants->total();

        return view('admin.restaurants.index', compact('restaurants', 'keyword', 'total'));
    }

    //店舗詳細ページ
    public function show(Restaurant $restaurant) {
        return view('admin.restaurants.show', compact('restaurant'));
    }


    //店舗登録ページ
    public function create()
    {
        return view('admin.restaurants.create');
    }


    //店舗登録機能
    public function store(Request $request)
    {
             $request->validate([
                'name' => 'required',
                'image' => 'image|max:2048',
                'description' => 'required',
                'lowest_price' => 'required|numeric|min:0|lte:highest_price',
                'highest_price' => 'required|numeric|min:0|gte:lowest_price',
                'postal_code' => 'required|numeric|digits:7',
                'address' => 'required', 
                'opening_time' => 'required|before:closing_time',
                'closing_time' => 'required|after:opening_time',
                'seating_capacity' => 'required|numeric|min:0',
        ]);

        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        $restaurant->description = $request->input('description'); 
        $restaurant->lowest_price = $request->input('lowest_price');
        $restaurant->highest_price = $request->input('highest_price');
        $restaurant->postal_code = $request->input('postal_code');
        $restaurant->address = $request->input('address');
        $restaurant->opening_time = $request->input('opening_time');
        $restaurant->closing_time = $request->input('closing_time');
        $restaurant->seating_capacity = $request->input('seating_capacity');

        if($request->hasFile('image')) {
            $image_path = $request->file('image')->store('public/restaurants');
            $restaurant->image = basename($image_path);
        } else {
            $restaurant->image = '';
        }
        
        $restaurant->save();

        return redirect()->route('admin.restaurants.index')->with('flash_message', '店舗を登録しました。');
    }

    /**
     * Show the form for editing the specified resource.
     */
    //店舗編集ページ
    public function edit(Restaurant $restaurant)
    {
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    // 店舗更新機能
    public function update(Request $request, Restaurant $restaurant)
    {
             $request->validate([
            'name' => 'required',
            'image' => 'image|max:2048',
            'description' => 'required',
            'lowest_price' => 'required|numeric|min:0|lte:highest_price',
            'highest_price' => 'required|numeric|min:0|gte:lowest_price',
            'postal_code' => 'required|numeric|digits:7',
            'address' => 'required', 
            'opening_time' => 'required|before:closing_time',
            'closing_time' => 'required|after:opening_time',
            'seating_capacity' => 'required|numeric|min:0',
        ]);

        
        $restaurant->name = $request->input('name');
        if($request->hasFile('image')) {
            $image_path = $request->file('image')->store('public/restaurants');
            $restaurant->image = basename($image_path);;
        }
        $restaurant->description = $request->input('description');
        $restaurant->lowest_price = $request->input('lowest_price');
        $restaurant->highest_price = $request->input('highest_price');
        $restaurant->postal_code = $request->input('postal_code');
        $restaurant->address = $request->input('address');
        $restaurant->opening_time = $request->input('opening_time');
        $restaurant->closing_time = $request->input('closing_time');
        $restaurant->seating_capacity = $request->input('seating_capacity');
        
        $restaurant->save();

        return redirect()->route('admin.restaurants.show', ['restaurant' => $restaurant->id])->with('flash_message', '店舗を編集しました。');
    }
    
    //店舗削除機能
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')->with('flash_message', '店舗を削除しました。');
    }
}
