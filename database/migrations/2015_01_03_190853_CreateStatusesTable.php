<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Status;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title', 50);
          $table->string('slug', 10);
          $table->timestamps();
        });

        $s = new Status;
        $s->title = "Active";
        $s->slug = 'active';
        $s->save();

        $s = new Status;
        $s->title = "Pending Activation";
        $s->slug = 'pend_act';
        $s->save();

        $s = new Status;
        $s->title = "Pending Deletion";
        $s->slug = 'pend_del';
        $s->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statuses', function (Blueprint $table) {
            Schema::drop('statuses');
        });
    }
}
