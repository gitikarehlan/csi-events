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
          //  $table->integer('duration_of_research');
            
            $table->bigInteger('user_id')->unsigned();
            
            $table->integer('reopen_flag');
            
           
            $table->timestamps();

            /*
            $table->date('date_of_approval');
            $table->integer('granted_amount')->unsigned()->nullable();
            
            Shifted to Proposal Versions
            
            // $table->bigInteger('request_service_id')->unsigned();
            
            $table->integer('proposed_amount')->unsigned();
            $table->string('description',1024);
            
            Shifted to Proposal Versions
            

            $table->string('field',254);
            $table->string('title',254);            

            $table->integer('team_members')->unsigned();
            $table->string('research_place',254);
            $table->date('start_date_of_proposal');

            Shifted to Proposal_versions
            
            $table->foreign('request_service_id')->references('id')->on('request_services')->onDelete('CASCADE')->onUpdate('CASCADE');*/

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
