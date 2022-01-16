<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine='MyISAM';
            $table->increments('link_id');
            $table->string('link_name')->default('')->comment('名称');
            $table->string('link_title')->default('')->comment('描述');
            $table->string('link_url')->default('')->comment('链接');
            $table->integer('link_order')->default('')->comment('排名');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
