<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id')->unsigned();
            $table->string('comments');
            $table->bigInteger('proposal_version_id')->unsigned();
            $table->tinyInteger('type');
            
            
            $table->timestamps();

            

            $table->foreign('proposal_version_id')
            ->references('id')->on('proposal_versions')
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
        Schema::drop('proposal_comments');

    }
}
