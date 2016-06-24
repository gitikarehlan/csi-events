<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('proposals', function (Blueprint $table) {
      $table->engine = 'InnoDB';

      $table->bigIncrements('id')->unsigned();
      $table->text('status');
      $table->string('field',254);
       

      $table->bigInteger('user_id')->unsigned();

      $table->integer('reopen_flag');


      $table->timestamps();

            

            $table->foreign('user_id')
            ->references('id')->on('members')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');

          }); 

}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('proposals');  
    }
  }
