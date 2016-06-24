<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\PaginationServiceProvider;
class Proposal extends Model
{
  protected $fillable = ['status', 
  'field',
  'reopen_flag', 
  'user_id',
  ];

   

  public function proposalversion()
  {
    return $this->hasMany('App\proposal_version','proposal_id','id');
  }

  public function allottedAdmin()
  {
    return $this->belongsTo('App\ProposalAllottedAdmin','id','proposal_id');
  }

  public function memberProposal()
  {
    return $this->belongsTo('App\Member','id', 'user_id');
  }

}
