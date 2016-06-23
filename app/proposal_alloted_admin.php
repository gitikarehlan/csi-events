<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proposal_alloted_admin extends Model
{
    protected $fillable = ['proposal_id'];

    public function allottedProposal()
	{
		return $this->hasMany('App\Proposal','proposal_id','id');
	}



}
