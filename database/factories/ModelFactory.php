<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    $date = $faker->dateTimeThisMonth;

    return [
        'title' => $faker->sentence(),
        'content' => $faker->paragraph(),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

$factory->define(App\Attachment::class, function (Faker $faker){
   return [
     'filename' => sprintf("%s.%s",
         str_random(),
         $faker->randomElement(['jpg','png','zip','tar'])
     )
   ];
});

$factory->define(App\Comment::class, function(Faker $faker){

    $articleIds = App\Article::pluck('id')->toArray();
    $userIds = App\User::pluck('id')->toArray();

    return [
      'content' => $faker->paragraph,
      'commentable_type' => App\Article::class,
      'commentable_id' => function () use ($faker, $articleIds){
        return $faker->randomElement($articleIds);
      },
      'user_id' => function () use ($faker, $userIds){
        return $faker->randomElement($userIds);
      },
    ];
});

$factory->define(App\Vote::class, function (Faker $faker){
    $up = $faker->randomElement([true, false]);
    $down = ! $up;
    $userIds = App\User::pluck('id')->toArray();

    return [
        'up' => $up ? 1 : null,
        'down' => $down ? 1 : null,
        'user_id' => function () use ($faker, $userIds){
            return $faker->randomElement($userIds);
        }
    ];
});
