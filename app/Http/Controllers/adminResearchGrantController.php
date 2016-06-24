<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proposals;
use App\Individual;
use App\Institution;
use App\proposal_comment;
use App\proposal_version;
use App\Http\Requests\VerifyResearchGrantRequest;
use Response;
use Auth;
use DB;
use Input;
class adminResearchGrantController extends Controller
{
 public function commentsandstatus($v)
 {
  $arr=proposal_version::StatusChange($v);
  return view('backend.researchgrant.verify',compact('arr','v'));
}

public function searchfile(Request $r)
{
  $new=$r->new;
  $accept=$r->accept;
  $reject=$r->reject;
  $changes=$r->changes;
  $word=$r->search;
  $val=$r->searchlist;
  $date1=$r->date1;
  $date2=$r->date2;
  
  $user=collect();

  if($val=='rid' && $word != '')
  {
    $user=Proposals::where('id',$word)->get();
    return view('backend.researchgrant.allproposals_admin')->with('user',$user);
  }

  else if($val=='id' && $word != '')
  {
    $user=Proposals::where('user_id','=',$word)->get();
    return view('backend.researchgrant.allproposals_admin')->with('user',$user);
  }

  else if($date1 != '' && $date2 !='')
  {
    
    $user=Proposals::where('created_at','>=',$date1)
    ->where('created_at','<=',$date2)
    ->get();
    if(!($new == '' && $accept== '' && $reject=='' && $changes==''))
    {
     if($new=='')
     {
      $pid=proposal_version::where('research_status','=','0')->lists('proposal_id');

      $uid=Proposals::whereIn('id',$pid)->get();
      $user= $user->diff($uid);
    }

    if($accept=='')
    { 
      $pid=proposal_version::where('research_status','=','2')->lists('proposal_id');
      $uid=Proposals::whereIn('id',$pid)->get();
      $user= $user->diff($uid);
    }

    if($changes=='')
    { 
      $pid=proposal_version::where('research_status','=','1')->lists('proposal_id');
      $uid=Proposals::whereIn('id',$pid)->get();
      $user= $user->diff($uid);
    }

    if($reject=='')
    {
      $pid=proposal_version::where('research_status','=','3')->lists('proposal_id');
      $uid=Proposals::whereIn('id',$pid)->get();
      $user= $user->diff($uid);
    }
  }
}

if($new != '')
{
  $pid=proposal_version::where('research_status','=','0')->lists('proposal_id');
  $user=Proposals::whereIn('id',$pid)->get();
}

if($changes != '')
{
  $pid=proposal_version::where('research_status','=','1')->lists('proposal_id');
  $uid=Proposals::whereIn('id',$pid)->get();
  $user=$user->merge($uid);
}

if($accept != '')
{
  $pid=proposal_version::where('research_status','=','2')->lists('proposal_id');     
  $uid=Proposals::whereIn('id',$pid)->get();
  $user=$user->merge($uid);
}

if($reject != '')
{
  $pid=proposal_version::where('research_status','=','3')->lists('proposal_id');
  $uid=Proposals::whereIn('id',$pid)->get();
  $user=$user->merge($uid);
}

if($val=='name' && $word != '')
{
  $uid=Individual::where('individuals.first_name','like','%'.$word.'%' )->lists('member_id');
  $member=Proposals::whereIn('user_id',$uid)->get();
  
  if($date1!='' && $date2!='')
  {
    $user=$user->intersect($member);
  }
  else
  {
    $user=$user->merge($member);
  }
}

if($val=='title' && $word != '')
{
  $uid=proposal_version::where('title','like','%'.$word.'%' )->lists('proposal_id');
  $member=Proposals::whereIn('id',$uid)->get();

  if($date1!='' && $date2!='')
  {
    $user=$user->intersect($member);
  }
  else
  {
    $user=$user->merge($member);
  }
}

if($val=='orgname' && $word != '')
{
  $uid=Institution::where('institutions.name','like','%'.$word.'%' )->lists('member_id');
  $member=Proposals::whereIn('user_id',$uid)->get();
  if($date1!='' && $date2!='')
  {
    $user=$user->intersect($member);
  }

  else
  {
    $user=$user->merge($member);
  }
}
return view('backend.researchgrant.allproposals_admin')->with('user',$user);

}

public function allgrants()
{
  $user=Proposals::all();
  return view('backend.researchgrant.allproposals_admin',compact('user'));
}

public function admin_showversions($p_id)
{  
  $temp=Proposals::find(['proposal_id'=>$p_id])->first();
  return view('backend.researchgrant.adminshowversions',compact('temp'));  
}

public function comments($id,$ver_num)
{
  $var=Input::all();
  $obj=new proposal_comment;
  $mod=proposal_version::FilterByProposalAndVersion($id,$ver_num)->first();
  
  if($var['comments']=='')
    $var['comments']='No comments for the current version.';
  
  $obj->comments=$var['comments'];
  $obj->type=1;
  $obj->proposal_version_id=$mod->id;
  $obj->save();
  return redirect()->back();

}

public function showcomments($p_id,$v_num)
{
  $a=proposal_version::FilterByProposalAndVersion($p_id,$v_num)->first();
  $arr=proposal_version::FilterByProposalAndDeletedAt($p_id)->first();
  
  if($arr->version_number==$v_num){
    return view('backend.researchgrant.adminaddcomments',compact('a'));
  }
  else{
    return view('backend.researchgrant.adminshowcomments',compact('a'));
  }
}

public function viewfile($id)
{
  $filename = $id;
  $path = storage_path().'/uploads/grant_proposals/'.$filename;
  $response=Response::make(file_get_contents($path), 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; '.$filename,
    ]);
  return $response;
}


public function makechanges(VerifyResearchGrantRequest $request,$id)
{
  $var=INPUT::all();
  $obj1=new proposal_version;
  $obj=DB::table('proposals')->where('id',$id);

  $mod=Proposals::join('proposal_versions','proposals.id','=','proposal_versions.proposal_id')
  ->where('proposals.id','=',$id)->orderby('proposal_versions.id','DESC')
  ->select('proposal_versions.id')
  ->first();
  
  $obj1=$obj1::find($mod->id);
  $obj1->research_status=$var['status'];
  $obj1->admin_description=$var['message'];
  $obj->status=$obj1->status;
  $obj1->save();
  
  return redirect()->action('adminResearchGrantController@allgrants');
  
}
}
