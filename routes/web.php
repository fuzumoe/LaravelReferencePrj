<?php

use App\Photo;
use  App\Post;
use App\Tag;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test',function(){
    return "Test page";
});

Route::get("/about",function(){
     return "Abouit page";
});

Route::get("/contact","PostController@contact");


Route::get('/contact/names',array('as'=>'admin.home','uses',function(){
         $url = route('admin.home');
         return  "this url is ".$url;
}));

Route::get("/contact/{id}/{name}",function($id,$name){
    return "this is your id ".$id." name ".$name;
});

Route::get("/post",'PostController@index');

Route::get("/post/{id}/{name}",'PostController@showPost');

/*========== ELEQUANT ==================*/
   /**** ORM OF LARAVEL *****/
/*=====================================*/
Route::get("/read",function(){
//  $posts = Post::all();
//    foreach( $posts as $post){
//        return $post->title;
//    }
    //RETURN ALL AS JSON
//    $post = Post::find(2)->get();
    $post = Post::find(2)->title;
    return $post;

});


Route::get('findwhere',function(){
    $post = Post::where('id',1)->orderBy('id','desc')->take(1)->get();
    return $post;
});

Route::get('findmore',function(){
    $post = Post::findOrFail(4);
    return $post;
});

Route::get('/basicinsert',function(){
    //new ORM object
    $post = new  Post;
    // ORM objec instance from a row
//    $post = new  Post::find(2);
    $post->title = "new ORM Title";
    $post->body =" Wow elequent is really cool, look at this content";
    $post->is_admin =0;
    $post->save();

});
//insert to RDBMS
Route::get('/create',function(){
    //mass exucution => for this method to exute filable method must be overriden
    Post::create(['title'=>'create mehtod','body'=>'Now I am learning',"is_admin"=>"1"]);
});
// conditional get  from RDBMS
Route::get('/update',function(){
    Post::where('id',1)->where('is_admin',0)->update(['title'=>"new title",'body'=>'i love my instructor Edwin']);
});
//delete  from RDBMS
Route::get('/delete',function(){
    Post::find(1)->delete();
});
//destroy data from RDBMS
Route::get('/destroy',function(){
   Post::destroy([2,3]);
//    ->Where('is_admin',0);
});

/*________________________________________________________
 |
 |   ELOQUANT RELATIONS "ORM  BASED"
 |________________________________________________________
 */
//One to One relationship DIRECT [belongsTo]
Route::get('/user/{id}/post',function ($id){
    return User::find($id)->post;
});

//One to One relationship Inverse [hasOne]
Route::get('/posts/{id}/user',function ($id){
    return Post::find($id);
});

//Many to many relationship/ [belongsToMany]
Route::get('/user/{id}/roles',function($id){
     $user = User::find($id);
    foreach ($user->roles as $role){
      echo $role->name;
    }
});
//Many to many crossection relation [hasManyThrough]
Route::get('/user/country',function(){
    $country = \App\Country::find(1);

    foreach ($country->post as $post)
        return $post->title;
});

//Many to Many intermidiate table [pivot table]
Route::get('user/pivot',function(){
      $user = User::find(2);
      foreach($user->roles as $role)
          return $role->pivot;
});

//polymorphic relations
Route::get('/user/photo',function(){
      $user = User::find(1);
    foreach($user->photos as $photo)
        return $photo->path;
});

//Many to Many intermidiate table [pivot table]
Route::get('user/pivot',function(){
    $user = User::find(2);
    foreach($user->roles as $role)
        return $role->pivot;
});

//polymorphic relations
Route::get('/post/photo',function(){
    $post = Post::find(1);
    foreach($post->photos as $photo)
        return $photo->path;
});

//polymorphic relations INVERSE
Route::get('/photo',function(){
    $photo = Photo::findOrFail(1);
    return $photo->imageable;
//    foreach($photo->photos as $photo)
//        return $photo->path;
});

//polymorphic many to many direct []
Route::get('/post/tag',function (){
    $post = Post::find(1);
    foreach ($post->tags as $tag)
        echo $tag->name;

});
//polymorphic many to many Inverse [owner]

Route::get('/tag/post',function(){
    $tag = Tag::find(2);
//    return $tag;
    foreach($tag->posts as $post)
        echo $post;

});