<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class proposal_comment extends Model
{
    protected $fillable = ['comments'];

    public function commentVersion()
	{
		return $this->belongsTo('App\proposal_version','proposal_id','id');
	}
	public static function getallcomments($p_id,$ver_num)
	{
		$arr=DB::table('proposals')->join('proposal_versions','proposals.id','=','proposal_versions.proposal_id')
                                ->join('proposal_comments','proposal_comments.proposal_version_id','=', 'proposal_versions.id')
                                ->where('proposal_versions.proposal_id','=',$p_id)
                                ->where('proposal_versions.version_number','=',$ver_num)
                                ->orderby('proposal_versions.version_number','DESC')
                                ->get();

                               return $arr;
    }
}
