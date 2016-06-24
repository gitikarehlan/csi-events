<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller; 
use Auth;
use Input;
use DB;
use Response;
use \App\Proposals;
use \App\proposal_version;
use App\proposal_comment;
use Illuminate\Pagination\Paginator;
use Flash;
use App\Http\Requests\CreateResearchGrantRequest;
use App\Http\Requests\UpdateResearchGrantRequest;
use App\Http\Requests\CreateNewResearchVersionRequest;


class ResearchGrantController extends Controller
{
  public function allgrants()
  {
   $users = Auth::user()->user();
   $arr = Proposals::myQuery($users);
   return view('frontend.researchgrant.allresearchgrants',compact('users','arr'));
 } 

 public function grantversions($prop_id)
 {
  $a=new Proposals;
  $users = Auth::user()->user();
  $arr=Proposals::getGrantVersion($prop_id);
  
  $comments=proposal_comment::where('proposal_version_id','=',$prop_id)->get();
  return view('frontend.researchgrant.grantversions',compact('arr','comments'));
}

public function newversion($prop_id,UpdateResearchGrantRequest $request)
{
 $var=INPUT::all();
 $user = Auth::user()->user();

 if($var['durationList']=="weeks")
 {
  $duration = $var['duration']*7;
}
else 
  if($var['durationList']=="days")
  {
    $duration = $var['duration'];
  }
  else 
  {
   $duration = $var['duration']*30;
 }

 $ver=proposal_version::FilterByProposalAndDeletedAt($prop_id)->first();
 $ver_num=$ver->version_number;
 $ver_num+=1;
 $a=\App\Proposals::find($prop_id);
 $filename = $user['id'].'_'.$ver->title.'_'.$ver_num.'.';
 $filename.=$var['grantProposal']->getClientOriginalExtension();
 $var['grantProposal']->move(storage_path('uploads/grant_proposals'), $filename);

 $obj= new \App\proposal_version;
 
 $obj::create([  'version_number'=>$ver_num,
  'version_path'=>$filename,
  'proposal_id'=>$prop_id,
  'title'=>$var['title_g'],
  'team_members'=>$var['teamMembers'],
  'research_place'=>$var['researchPlace'],
  'duration_of_research'=>$duration,
  'description'=>$var['propDescription'],
  'proposed_amount'=>$var['grantNeeded']
  ]);

 $ver->destroy($ver->id);
 $ver->research_status=0;
 $a->status=$ver->research_status;
 $a->save();
    		//	 });

 return redirect()->action('ResearchGrantController@allgrants');

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

public function showversions($p_id)
{
  $temp=Proposals::find(['proposal_id'=>$p_id])->first();
  return view('frontend.researchgrant.showversions',compact('temp'));
}

public function comments($id,$ver_num)
{
  $var=Input::all();
  $obj=new proposal_comment;

  $var=Input::all();
  $obj=new proposal_comment;

  $mod=proposal_version::FilterByProposalAndVersion($id,$ver_num)->first();

  if($var['comments']=='')
    $var['comments']='No comments for the current version.';
  $obj->comments=$var['comments'];
  $obj->type=0;
  $obj->proposal_version_id=$mod->id;
  $obj->save();

  return redirect()->back();
}
public function showcomments($p_id,$v_num)
{
  $a=proposal_version::FilterByProposalAndVersion($p_id,$v_num)->first();
  $arr=proposal_version::FilterByProposalAndDeletedAt($p_id)->first();
  if($arr->version_number==$v_num){
    return view('frontend.researchgrant.addcomments',compact('a'));
  }else{
    return view('frontend.researchgrant.showcomments',compact('a'));
  }

}


public function grantsform()
{

 return view('frontend.researchgrant.grantsform');
}

public function grantsform_thankyou(CreateResearchGrantRequest $request)
{ 
 $this->StoreProposal($request);
 return redirect()->action('ResearchGrantController@allgrants');
}

public function newpage($p_id)
{
  return view('newpage');
}

private function StoreProposal(CreateResearchGrantRequest $request)
{
 $obj=DB::transaction(function($connection) {
  $var=INPUT::all();
  $user = Auth::user()->user();
  $filename = $user['id'].'_'.$var['title_g'].'.';
  $filename.=$var['grantProposal']->getClientOriginalExtension();
  $var['grantProposal']->move(storage_path('uploads/grant_proposals'), $filename);

  if($var['durationList']=="weeks")
  {
    $duration = $var['duration']*7;
  }
  else 
    if($var['durationList']=="days")
    {
      $duration = $var['duration'];
    }
    else 
    {
      $duration = $var['duration']*30;
    }

    $resProposalRequest = Proposals::create([
      'status' => 0,
      'field' => $var['fieldName'],
      'user_id' => $user->id,
      'reopen_flag' => 0
      ]);    

    $resProposalVersion = proposal_version::create([
      'version_number' => 1,
      'title' => $var['title_g'],
      'version_path' => $filename,
      'team_members' => $var['teamMembers'],
      'proposal_id' => $resProposalRequest->id,
      'research_place' => $var['researchPlace'],
      'research_status' => 0,
      'proposed_amount' => $var['grantNeeded'],
      'granted_amount' => 0,
      'duration_of_research' => $duration,
      'date_of_approval' => '02/02/2002',
      'description' => $var['propDescription'],
      'admin_description' => 'NONE'
      ]);
  });
}
}