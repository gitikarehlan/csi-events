<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_versions', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id')->unsigned();
            $table->integer('version_number')->unsigned();
            $table->string('title',254);
            $table->string('version_path',500);
            $table->integer('team_members')->unsigned();
            $table->bigInteger('proposal_id')->unsigned();
            $table->string('research_place',254);
            $table->tinyInteger('research_status')->unsigned();
            $table->integer('proposed_amount')->unsigned();
            $table->integer('granted_amount')->unsigned()->nullable();
            $table->integer('duration_of_research');
            $table->date('date_of_approval');
            $table->text('description');                //description added for each proposal version
            $table->text('admin_description');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('proposal_id')
            ->references('id')->on('proposals')
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
        Schema::drop('proposal_versions');        
    }
}
