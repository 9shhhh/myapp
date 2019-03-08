<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::pattern('foo','[0-9a-zA-Z]{3}');

//Route::get('/{foo?}', function ($foo="bar") {
//    return $foo;
//})->where('foo','[0-9a-zA-Z]{3}');

//Route::get('/', [
//   'as' => 'home',
//   function () {
//        return '제 이름은 성환 입니다.';
//   }
//]);
//// 루트로 실행 하면 클로저 함수 실행됨. ->  return '제 이름은 성환 입니다.'
//
//
//Route::get('/home',function(){
//   return redirect(route('home'));
//});
//// /home로 실행 하면 'home' 이라는 이름을 가진 route를 찾아서 실행
//// route() : http://localhost:8000 또는 http://호스트:포트 문자열을 반환 한다.

//Route::get('/',function(){
//   return view('welcome') -> with([    with() 메서드를 체인한다.
//       'name' => 'Foo',
//       'greeting' => '안녕갑세요?',
//   ]);
//});

//Route::get('/',function(){
//   return view('welcome',[          // view() 함수 두번째 인자로 값을 넘긴다. (실전에서 많이 쓰는 방법)
//       'name' => 'Foo',
//       'greeting' => '안녕갑세요????',
//   ]);
//});

//Route::get('/',function(){
//   $items = ['apple', 'banana', 'tomato']; // 실헙을 위한 데이터 하드코딩, #뷰 코드에서도 php 코드 사용 가능!!#
//
//   return view('welcome', ['items'=>$items]);
//});

Route::get('/', function () {
    return view('auth/login');
});

//Route::get('/', 'WelcomeController@index');

//Route::resource('articles', 'ArticlesController');

////
//Route::get('auth/login', function (){
//    $credentials = [
//        'email' => 'john@example.com',
//        'password' => 'password'
//    ];
//
//    if (!auth()->attempt($credentials)){
//        return '로그인 정보가 정확하지 않습니다.';
//    }
//
//    return redirect('protected');
//});
//
//Route::get('protected',['middleware' => 'auth', function (){
//    dump(session()->all());
//
//    return '어서오세요' . auth()->user()->name;
//}]);
//
//Route::get('auth/logout',function () {
//    auth()->logout();
//
//    return '또 봐요~';
//});
Auth::routes();
//
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('articles', 'ArticlesController');

//DB::listen(function ($query){
//   var_dump($query->sql);
//});

//Event::listen('article.created',function ($article){
//    var_dump('이벤트를 받았습니다. 받은 데이터(상태)는 다음과 같습니다.');
//    var_dump($article->toArray());
//});
Route::get('markdown',function (){
    $text =<<<EOT
    #마크 다운 예제 1 
    
    이 문서는 [마크다운][1]으로 썼습니다. 화면에는 HTML로 변환 되어 출력됩니다.
    
    ## 순서 없는 목록
    
    - 첫 번째 항목
    - 두 번째 항목[^1]
    
    [1]: http://daringfireball.net/pojects/markdown
    
    [^1]: 두번째 항목_ http://google.com
EOT;

    return app(ParsedownExtra::class)->text($text);
});

//Route::get('docs/{file?}',function ($file = null){
//    $text = (new App\Documentation)->get($file);
//
//    return app(ParsedownExtra::class)->text($text);
//});

Route::get('docs/{file?}','DocsController@show');