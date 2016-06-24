@extends('backend.master')
@section('title', 'Research Grant')
@section('main')
<section id="main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div>
          <h1 class="section-header-style">Research Proposals</h1>
        </div>
        <h3>Listing the Version Details</h3>

        @if ( $errors->any() )
        
        <ul class="list-unstyle">
         <li>
           @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
           @endforeach
         </li>
       </ul>
       @endif
       <div class="col-md-8">
        <h1 id="stepText"> <small id="stepSubText"></small></h1>
      </div>

      <div class="panel panel-default panel-list">
        <div class="panel-heading compact-pagination ">
          <div class="row">
            <div class="col-md-9">
              {{-- other content --}}
            </div>
            <div class="col-md-3">
            </div>
          </div>
        </div><!-- panel-header -->

        <div class="panel-body">
          @foreach ($temp->proposalversion as $a)
          <div style="border-bottom:1px solid #000; padding: 10px 20px">
            <!-- <div class="listing-items">-->
            <div class="row">
              <div class="col-md-10">
                <p>
                  <span>Version #{{$a->version_number}}
                    <br/><span>Field : {{$temp->field}}</span>, <span>Created At : {{$a->created_at}}</span>
                    <br/><span>Title: {{$a->title}}</span>  
                    <br/><span>Research Place: {{$a->research_place}}</span>
                    <br/><span>No. of Team Members: {{$a->team_members}}</span>
                    <br/><span>Updated At :{{$a->updated_at}}</span>
                    <br/><span>Deleted At : {{$a->deleted_at}}</span> 
                  </p>  
                </div>
                <div class="col-md-2">
                  <a class="btn btn-info" href="/admin/admin_showcomments/{{$a->proposal_id}}/{{$a->version_number}}"><span class="glyphicon glyphicon-comment"></span> View Comments</a>
                </div>
              </div>       
            </div>
            @endforeach
          </div>
          <div class="panel-footer compact-pagination">
            <div class="row">
              <div class="col-md-9">
                {{-- other content --}}
              </div>
              <div class="col-md-3">
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    @endsection