<?php

namespace App\Controller;

class PostController{
  public function index(){
    return "all posts";
  }

  public function show($id){
    return "Post your id $id";
  }
}