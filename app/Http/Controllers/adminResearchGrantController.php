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



  public function allgrants()
  {
    $cat_select_options = [
        0=>'Select',
        1 => 'Request ID',
        2 => 'Member ID',
        3 => 'Title',
        4 => 'Organization Name',
        5=>'Member Name'
    ];

    $rows = (Input::exists('rows'))?abs(Input::get('rows')): 15;         // how many rows for pagination
    $page = (Input::exists('page'))? abs(Input::get('page')): 1;
    $search=(Input::exists('searchlist'))?abs(Input::get('searchlist')):'' ;
    $search_text=(Input::exists('search'))?(Input::get('search')):'';
    $status=(Input::exists('status'))?(Input::get('status')):array();
    $fromDate=(Input::exists('date1'))?(Input::get('date1')):'';
    $toDate=(Input::exists('date2'))?(Input::get('date2')):'';

    //there is some search text){
    if($search){
      switch($search){
        case 1:
          $user= Proposals::where('id',$search_text)->latest()->paginate($rows);
          break;
        case 2:
          if(count($status)){
            $pid=proposal_version::whereIn('research_status',$status)->lists('proposal_id');
            $user=Proposals::where('user_id','=',$search_text)->whereIn('id',$pid)->paginate($rows);

          }else{
            $user=Proposals::where('user_id','=',$search_text)->paginate($rows);
          }
          break;
        case 3:
          if(count($status)){
            $pid=proposal_version::where('title','like','%'.$search_text.'%' )->whereIn('research_status',$status)->lists('proposal_id');
            $user=Proposals::whereIn('id',$pid)->paginate($rows);

          }else{
            $pid=proposal_version::where('title','like','%'.$search_text.'%' )->lists('proposal_id');
            $user=Proposals::whereIn('id',$pid)->paginate($rows);
          }
          break;
        case 4:
          if(count($status))  {
            $member_id=Institution::select('member_id')->where('name','like','%'.$search_text.'%')->get();
            $pid=proposal_version::whereIn('research_status',$status)->lists('proposal_id');
            $user=Proposals::whereIn('user_id','=',$member_id)->whereIn('id',$pid)->paginate($rows);
          }  else  {
            $member_id=Institution::select('member_id')->where('name','like','%'.$search_text.'%')->get();

            $user=Proposals::whereIn('user_id','=',$member_id)->paginate($rows);
          }
          break;
        case 5:
          if(count($status)){
            $member_id=Individual::select('member_id')->where('first_name','like','%'.$search_text.'%')->get();
            $pid=proposal_version::whereIn('research_status',$status)->lists('proposal_id');
            $user=Proposals::whereIn('user_id','=',$member_id)->whereIn('id',$pid)->paginate($rows);
          }else{
            $member_id=Individual::select('member_id')->where('first_name','like','%'.$search_text.'%')->get();

            $user=Proposals::whereIn('user_id','=',$member_id)->paginate($rows);
          }
          break;
      }

    }else {
      if (count($status)) {
        $pid = proposal_version::whereIn('research_status', $status)->lists('proposal_id');
        $user = Proposals::whereIn('id', $pid)->paginate($rows);
      } else {
        $pid = proposal_version::select('proposal_id')->distinct('proposal_id')->get();
        $user = Proposals::whereIn('id', $pid)->paginate($rows);

      }
    }

    //here you get status wise tuples, do query for dates
    $from_date_records = array();
    $to_date_records = array();
    foreach ($user as $key => $users) {
      if($fromDate){
        if($users->created_at <= $fromDate ){ //lower bound
          array_push($from_date_records, $key);
        }
      }
      if($toDate){
        if($users->created_at >= $toDate ){ //upper bound
          array_push($to_date_records, $key);
        }
      }
      if(!empty($fromDate)){
        //we need intersection of both the filters
        $user->forget($from_date_records);
      }
      if(!empty($toDate)){
        $user->forget($to_date_records);
      }
    }
    return view('backend.researchgrant.allproposals_admin',compact('user','cat_select_options','status','search','search_text','fromDate','toDate'));
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
