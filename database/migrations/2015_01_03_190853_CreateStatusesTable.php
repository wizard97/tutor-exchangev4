<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Pending\Status;

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
        $s->title = "Accepted";
        $s->slug = 'accepted';
        $s->save();

        $s = new Status;
        $s->title = "Pending Accept";
        $s->slug = 'pend_acpt';
        $s->save();


        $s = new Status;
        $s->title = "Rejected";
        $s->slug = 'rejected';
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
