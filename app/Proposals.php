<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\PaginationServiceProvider;
use App\proposal_version;
use App\Proposal;

class Proposals extends Model
{
    protected $fillable = ['status',
                           'field',
                            'user_id',
                            'reopen_flag'
                            ];

   // protected $hidden = ['date_of_approval', 'granted_amount'];

    public function proposalversion()
     {
        return $this->hasMany('App\proposal_version','proposal_id','id')->withTrashed()->orderby('version_number','DESC');
     }

     public function allottedAdmin()
	 {
		return $this->belongsTo('App\ProposalAllottedAdmin','id','proposal_id');
	 }

   public function memberProposal()
   {
      return $this->belongsTo('App\Member','user_id', 'id');
   }

   // public static function myQuery($users)
   //   {
   //      $arr=Proposals::where('user_id','=',$users->id)->paginate(5);
   //       //$arr =proposal_version::whereIn('proposal_id',$p_id)->latest()->paginate(5);
   //      return $arr;
   //  }

     public static function myQuery($users)
     {
	       $arr = Proposal::join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')->where('proposals.user_id','=',$users->id)->whereNull('deleted_at')->orderby('proposals.id','DESC')->paginate(5);
        return $arr;
    }

    public static function scopeFilterByProposalId($query,$p_id)
    {
        return $query->where('id','=','$p_id');
    }

    public static function getGrantVersion($prop_id)
    {
        $arr= Proposal::join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')
                        ->where('proposal_versions.proposal_id','=',$prop_id) 
                        ->whereNull('proposal_versions.deleted_at')->orderby('proposals.id','DESC')->get();
        return $arr;
    }

   
}
