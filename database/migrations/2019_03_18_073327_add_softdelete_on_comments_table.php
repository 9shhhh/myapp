<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/***********************************************************

 * @params

 * @description 댓글 소프트 삭제

 * @method
 *
 * @return

 ***********************************************************/
class AddSoftdeleteOnCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments',function (Blueprint $table){
           $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments',function (Blueprint $table){
           $table->dropSoftDeletes();
        });
    }
}
