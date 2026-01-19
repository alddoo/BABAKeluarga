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
      ['username'=>'Umi'],
      ['name'=>'Umi Aci','email'=>'Umik@baba.test','password'=>Hash::make('123456'),'role'=>'admin']
    );
    User::updateOrCreate(
      ['username'=>'Baba'],
      ['name'=>'BaBa Wira','email'=>'KelaurgaBaba@baba.test','password'=>Hash::make('12321'),'role'=>'admin']
    );
    User::updateOrCreate(
      ['username'=>'admin2'],
      ['name'=>'baba','email'=>'admin@baba.test','password'=>Hash::make('123'),'role'=>'admin']
    );

    User::updateOrCreate(
      ['username'=>'pm'],
      ['name'=>'Nagieb','email'=>'pm@baba.test','password'=>Hash::make('pm123'),'role'=>'pm']
    );

    User::updateOrCreate(
      ['username'=>'wa1'],
      ['name'=>'veren','email'=>'veren@baba.test','password'=>Hash::make('123'),'role'=>'wa']
    );
    User::updateOrCreate(
      ['username'=>'wa2'],
      ['name'=>'nabilah','email'=>'nabilah@baba.test','password'=>Hash::make('wa123'),'role'=>'wa']
    );
  }
}
