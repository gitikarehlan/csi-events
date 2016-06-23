<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\PaginationServiceProvider;
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

     public static function myQuery($users)
     {
	       $arr = \App\Proposal::join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')->where('proposals.user_id','=',$users->id)->whereNull('deleted_at')->orderby('proposals.id','DESC')->paginate(5);
        return $arr;
    }

    public static function scopeFilterByProposalId($query,$p_id)
    {
        return $query->where('id','=','$p_id');
    }

    public static function adminAllGrants()
    {
        $arr=\App\Proposal::join('members','proposals.user_id','=','members.id')
        ->join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')
        ->leftjoin('individuals','individuals.member_id','=','members.id')
        ->leftjoin('institutions','institutions.member_id', '=','members.id')
        ->whereNull('proposal_versions.deleted_at')
        ->orderby('proposals.id','DESC')
        ->paginate(2);

        return $arr;
    }


    public static function search_title($word)
    {
       $arr=DB::table('proposals')->join('members','proposals.user_id','=','members.id')
                                ->join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')
                                ->leftjoin('individuals','individuals.member_id','=','members.id')
                                ->leftjoin('institutions','institutions.member_id', '=','members.id')
                                ->whereNull('proposal_versions.deleted_at')
                                ->where('title','like','%'.$word.'%')  
                               ->orderby('proposals.id','DESC')->paginate(5);
                                return $arr;
                
    }


    public static function search_org($word)
    {

                $arr=DB::table('proposals')->join('members','proposals.user_id','=','members.id')
                                ->join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')
                                ->join('institutions','institutions.member_id', '=','members.id')
                                ->whereNull('proposal_versions.deleted_at')
                                ->where('institutions.name','like','%'.$word.'%')
                               ->orderby('proposals.id','DESC')->paginate(5);

                               return $arr;

    }

    public static function search_id($word)
    {
       $arr=DB::table('proposals')->join('members','proposals.user_id','=','members.id')
                                ->join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')
                                ->leftjoin('institutions','institutions.member_id', '=','members.id')
                                ->leftjoin('individuals','individuals.member_id','=','members.id')
                                ->whereNull('proposal_versions.deleted_at')
                                ->where('members.id',$word)
                               ->orderby('proposals.id','DESC')->get();

      return $arr;
    }


    public static function search_name($word)
    {
      $arr=DB::table('proposals')->join('members','proposals.user_id','=','members.id')
                                ->join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')
                                ->join('individuals','individuals.member_id','=','members.id')
                                ->whereNull('proposal_versions.deleted_at')
                                ->where('individuals.first_name','like','%'.$word.'%' )
                               ->orderby('proposals.id','DESC')->paginate(5);


      return $arr;
    }

    public static function search_status($val)
    {
      
      $arr=DB::table('proposals')->join('members','proposals.user_id','=','members.id')
                                ->join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')
                                ->leftjoin('institutions','institutions.member_id', '=','members.id')
                                ->leftjoin('individuals','individuals.member_id','=','members.id')
                                ->whereNull('proposal_versions.deleted_at')
                                ->where('proposal_versions.research_status',$val)
                               ->orderby('proposals.id','DESC')->paginate(5);



      return $arr;
    }



    public static function commentAndStatusChange($v)
    {
        $arr=\App\Proposal::join('proposal_versions','proposals.id','=','proposal_versions.proposal_id')->whereNull('deleted_at')->where('proposals.id','=',$v)->get();
            return $arr;
    }

    public static function getGrantVersion($prop_id)
    {
        $arr=\App\Proposal::join('proposal_versions','proposals.id','=', 'proposal_versions.proposal_id')
        ->where('proposal_versions.proposal_id','=',$prop_id) 
          ->whereNull('proposal_versions.deleted_at')->orderby('proposals.id','DESC')->get();
          return $arr;
    }
}
