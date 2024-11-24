<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;
class HomeController{
  public function index(){

    // User::create([
    //   'name' => 'John doe',
    //   'email' => 'er.johndoe@gmail.com',
    //   'role' => 'admin',
    //   'password' => password_hash('admin', PASSWORD_DEFAULT)
    // ]);

    User::create([
      'name' => "Naveen Kumar",
      'email' => 'er.crackerjack@gmail.com',
      'role' => 'admn',
      'password' => password_hash('naveen@6', PASSWORD_DEFAULT)
    ]);

    return View::render(
      template:'home/index',
      data:['message'=>'hello naveen'],
      layout: 'layouts/main');
  }
}