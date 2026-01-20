<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    User::updateOrCreate(
      ['username'=>'Umik'],
      ['name'=>'Umik Aci','email'=>'Umik@gmail.com','password'=>Hash::make('Umik@321'),'role'=>'admin']
    );
    User::updateOrCreate(
      ['username'=>'Baba'],
      ['name'=>'BaBa Wira','email'=>'Baba@gmail.com','password'=>Hash::make('Baba@321'),'role'=>'admin']
    );
    User::updateOrCreate(
      ['username'=>'HRD'],
      ['name'=>'HR Keluarga Baba','email'=>'HR_keluargaBaBa@gmail.com','password'=>Hash::make('#HRD_baba'),'role'=>'admin']
    );

    User::updateOrCreate(
      ['username'=>'Yasser'],
      ['name'=>'Yasser','email'=>'Yasser@email.com','password'=>Hash::make('*Yasser1'),'role'=>'pm']
    );
    User::updateOrCreate(
      ['username'=>'Thoha'],
      ['name'=>'Thoha','email'=>'Thoha@gmail.com','password'=>Hash::make('Thoha*2'),'role'=>'pm']
    );
    User::updateOrCreate(
      ['username'=>'Julio'],
      ['name'=>'Julio','email'=>'Julio@gmail.com','password'=>Hash::make('!Jullio'),'role'=>'pm']
    );
    User::updateOrCreate(
      ['username'=>'Firli'],
      ['name'=>'Firli','email'=>'Firli@gmail.com','password'=>Hash::make('Firli!1'),'role'=>'pm']
    );
    User::updateOrCreate(
      ['username'=>'Toti'],
      ['name'=>'Toti','email'=>'Toti@gmail.com','password'=>Hash::make('T0ti4'),'role'=>'pm']
    );
    User::updateOrCreate(
      ['username'=>'Nagieb'],
      ['name'=>'Nagieb','email'=>'Nagieb@gamil.com','password'=>Hash::make('GG@Nagieb'),'role'=>'pm']
    );
    User::updateOrCreate(
      ['username'=>'BABA wira'],
      ['name'=>'BaBa Wira','email'=>'BaBaWira@gmail.com','password'=>Hash::make('B@BaWir4'),'role'=>'pm']
    );

    User::updateOrCreate(
      ['username'=>'Verenanda'],
      ['name'=>'Verenanda','email'=>'Verenanda@gmail.com','password'=>Hash::make('@verenanda'),'role'=>'wa']
    );
    User::updateOrCreate(
      ['username'=>'Latifah'],
      ['name'=>'Latifah','email'=>'Latifah@gmail.com','password'=>Hash::make('*Latifah'),'role'=>'wa']
    );
    User::updateOrCreate(
      ['username'=>'Wa3'],
      ['name'=>'User','email'=>'User@gmail.com','password'=>Hash::make('*User'),'role'=>'wa']
    );
  }
}
