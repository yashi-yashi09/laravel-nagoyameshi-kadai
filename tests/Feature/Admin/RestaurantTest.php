<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

     // 未ログインのユーザーは管理者側の店舗一覧ページにアクセスできない
     public function test_guest_cannot_access_admin_restaurants_index()
     {

         $response = $this->get(route('admin.restaurants.index'));
 
         $response->assertRedirect(route('admin.login'));
     }
 
     // ログイン済みの一般ユーザーは管理者側の店舗一覧ページにアクセスできない
     public function test_user_cannot_access_admin_restaurants_index()
     {

         $user = User::factory()->create();
           
         $response = $this->actingAs($user)->get(route('admin.restaurants.index'));
 
         $response->assertRedirect(route('admin.login'));
     }
 
     // ログイン済みの管理者は管理者側の店舗一覧ページにアクセスできる
     public function test_admin_can_access_admin_restaurants_index()
     {

         $admin = new Admin();
         $admin->email = 'admin@example.com';
         $admin->password = Hash::make('nagoyameshi');
         $admin->save();
 
         $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.index'));
 
         $response->assertStatus(200);
     }
 
     // 未ログインのユーザーは管理者側の店舗詳細ページにアクセスできない
     public function test_guest_cannot_access_admin_restaurants_show()
     {
        $restaurant = Restaurant::factory()->create();

 
         $response = $this->get(route('admin.restaurants.show', $restaurant));

         $response->assertRedirect(route('admin.login'));
     }
 
     // ログイン済みの一般ユーザーは管理者側の店舗詳細ページにアクセスできない
     public function test_user_cannot_access_admin_restaurants_show()
     {
        $restaurant = Restaurant::factory()->create();

         $user = User::factory()->create();
 
         $response = $this->actingAs($user)->get(route('admin.restaurants.show', $restaurant));
 
         $response->assertRedirect(route('admin.login'));
     }
 
     // ログイン済みの管理者は管理者側の店舗詳細ページにアクセスできる
     public function test_admin_can_access_admin_restaurants_show()
     {

        $restaurant = Restaurant::factory()->create();

         $admin = new Admin();
         $admin->email = 'admin@example.com';
         $admin->password = Hash::make('nagoyameshi');
         $admin->save();
 
 
         $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.show', $restaurant));
 
         $response->assertStatus(200);
     }

      // 未ログインのユーザーは管理者側の店舗登録ページにアクセスできない
      public function test_guest_cannot_access_admin_restaurants_create()
      {
  
          $response = $this->get(route('admin.restaurants.create'));
  
          $response->assertRedirect(route('admin.login'));
      }
  
      // ログイン済みの一般ユーザーは管理者側の店舗登録ページにアクセスできない
      public function test_user_cannot_access_admin_restaurants_create()
      { 
          $user = User::factory()->create();
  
          $response = $this->actingAs($user)->get(route('admin.restaurants.create'));
  
          $response->assertRedirect(route('admin.login'));
      }
  
      // ログイン済みの管理者は管理者側の店舗登録ページにアクセスできる
      public function test_admin_can_access_admin_restaurants_create()
      {
 
 
          $admin = new Admin();
          $admin->email = 'admin@example.com';
          $admin->password = Hash::make('nagoyameshi');
          $admin->save();
  
  
          $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.create'));
  
          $response->assertStatus(200);
      }

       // 未ログインのユーザーは店舗を登録できない
       public function test_guest_cannot_access_admin_restaurants_store()
       {
          $restaurant = Restaurant::factory()->create();
   
           $response = $this->get(route('admin.restaurants.store', $restaurant));
   
           $response->assertRedirect(route('admin.login'));
       }

       
   
       // ログイン済みの一般ユーザーは店舗を登録できない
       public function test_user_cannot_access_admin_restaurants_store()
       {
          $restaurant = Restaurant::factory()->create();
  
           $user = User::factory()->create();
   
           $response = $this->actingAs($user)->get(route('admin.restaurants.store', $restaurant));
   
           $response->assertRedirect(route('admin.login'));
       }

       // ログイン済みの管理者は店舗を登録できる
      public function test_admin_can_access_admin_restaurants_store()
      {
 
         $restaurant = Restaurant::factory()->create();
 
          $admin = new Admin();
          $admin->email = 'admin@example.com';
          $admin->password = Hash::make('nagoyameshi');
          $admin->save();
  
  
          $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.create', $restaurant ));
  
          $response->assertStatus(200);
      }
   
       // 未ログインのユーザーは管理者側の店舗編集ページにアクセスできない
       public function test_guest_cannot_access_admin_restaurants_edit()
       {
           $restaurant = Restaurant::factory()->create();
    
           $response = $this->get(route('admin.restaurants.edit', $restaurant));
   
           $response->assertRedirect(route('admin.login'));
       }
   
       // ログイン済みの一般ユーザーは管理者側の店舗編集ページにアクセスできない
       public function test_user_cannot_access_admin_restaurants_edit()
       {
           $restaurant = Restaurant::factory()->create();
  
           $user = User::factory()->create();
   
           $response = $this->actingAs($user)->get(route('admin.restaurants.edit', $restaurant));
   
           $response->assertRedirect(route('admin.login'));
       }
   
       // ログイン済みの管理者は管理者側の店舗編集ページにアクセスできる
       public function test_admin_can_access_admin_restaurants_edit()
       {
  
           $restaurant = Restaurant::factory()->create();
  
           $admin = new Admin();
           $admin->email = 'admin@example.com';
           $admin->password = Hash::make('nagoyameshi');
           $admin->save();
   
           $response = $this->actingAs($admin, 'admin')->get(route('admin.restaurants.edit',  $restaurant));
   
           $response->assertStatus(200);
       }

       // 未ログインのユーザーは店舗を更新できない
       public function test_guest_cannot_update_restaurants()
       {
           $restaurant = Restaurant::factory()->create();
  
   
           $response = $this->patch(route('admin.restaurants.update', $restaurant));
   
           $response->assertRedirect(route('admin.login'));
       }
   
       //ログイン済みの一般ユーザーは店舗を更新できない
       public function test_user_cannot_update_restaurants()
       {
           $restaurant = Restaurant::factory()->create();
  
           $user = User::factory()->create();
   
           $response = $this->actingAs($user)->patch(route('admin.restaurants.update', $restaurant));
   
           $response->assertRedirect(route('admin.login'));
       }
   
       // ログイン済みの管理者は店舗を更新できる
       public function test_admin_can_update_restaurants()
       {
  
           $restaurant = Restaurant::factory()->create();
  
           $admin = new Admin();
           $admin->email = 'admin@example.com';
           $admin->password = Hash::make('nagoyameshi');
           $admin->save();

           $updateData = [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50,
        ];
   
           $response = $this->actingAs($admin, 'admin')->patch(route('admin.restaurants.update', ['restaurant' => $restaurant->id]),$updateData);
   
           $response->assertRedirect(route('admin.restaurants.show', ['restaurant' => $restaurant->id])); // リダイレクト先を検証
           $response->assertStatus(302);
       }

       // 未ログインのユーザーは店舗を削除できない
       public function test_guest_cannot_destroy_restaurant()
       {
           $restaurant = Restaurant::factory()->create();
  
           $user = User::factory()->create();
   
           $response = $this->delete(route('admin.restaurants.destroy', $restaurant));
   
           $this->assertDatabaseHas('restaurants', ['id' => $restaurant->id]);
           $response->assertRedirect(route('admin.login'));
       }
   
       //ログイン済みの一般ユーザーは店舗を削除できない
       public function test_user_cannot_destroy_restaurant()
       {
           $restaurant = Restaurant::factory()->create();
  
           $user = User::factory()->create();
   
           $response = $this->actingAs($user)->delete(route('admin.restaurants.destroy', $restaurant));
   
           $this->assertDatabaseHas('restaurants', ['id' => $restaurant->id]);
           $response->assertRedirect(route('admin.login'));
       }
   
       // ログイン済みの管理者は店舗を削除できる
       public function test_admin_can_destroy_restaurant()
       {
  
           $restaurant = Restaurant::factory()->create();
  
           $admin = new Admin();
           $admin->email = 'admin@example.com';
           $admin->password = Hash::make('nagoyameshi');
           $admin->save();
   
   
           $response = $this->actingAs($admin, 'admin')->delete(route('admin.restaurants.destroy', $restaurant));
           $this->assertDatabaseMissing('restaurants', ['id' => $restaurant->id]);

           $response->assertRedirect(route('admin.restaurants.index'));   

           $response->assertStatus(302);

       }
}
