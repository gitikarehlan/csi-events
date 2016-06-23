<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class proposal_version extends Model
{
	use SoftDeletes;

	//protected $softDelete=true;

	protected $dates = ['deleted_at'];

	protected $fillable = ['version_number',
							#'field', 
                            'title',
                            'version_path',
                            'proposal_id',
                            'team_members', 
                            'research_place',
                            'research_status', 
                            'proposed_amount',
                            'granted_amount',
                            'date_of_approval',
                            'description',
                            'duration_of_research',
                            'admin_description',
                            ];

    public function proposal()
	{
		return $this->belongsTo('App\Proposal','id','proposal_id');
	}
   static public function statuschange($v)
    {
        $arr=proposal_version::join('proposals','proposals.id','=','proposal_versions.proposal_id')->where('proposal_versions.id','=',$v)->get();
        return $arr;
    }

	public function versionComments()
	{
		return $this->hasMany('App\proposal_comment','proposal_version_id','id');

	}
    public static function getVersion($p_id,$ver_num)
    {
        $arr=DB::table('proposal_versions')->where('proposal_id','=',$p_id)->where('version_number','=',$ver_num)->
        get();
        return $arr;
    }

    public function getAdminDescriptionAttribute($admin_description){
        return (is_null($admin_description))?"":$admin_description;
    }
     public static function scopeFilterByProposalAndDeletedAt($query,$p_id)
    {
        return $query->where('proposal_id','=',$p_id);
    }
    public static function scopeFilterByProposalAndVersion($query, $p_id,$v_num)
    {
        return $query->where('proposal_id','=',$p_id)->where('version_number','=',$v_num)->withTrashed();
    }

}
