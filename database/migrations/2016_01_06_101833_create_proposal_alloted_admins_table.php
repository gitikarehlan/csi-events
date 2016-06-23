<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalAllotedAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
          Schema::create('proposal_alloted_admins', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('proposal_id')->unsigned();
            $table->integer('admin_id')->unsigned();
    
            $table->timestamps();

            

          $table->foreign('proposal_id')
                    ->references('id')->on('proposals')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE'); 

            $table->foreign('admin_id')
                    ->references('id')->on('admins')
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
    Schema::drop('proposal_alloted_admins');
    }
}
