@extends('backend.master')

@section('page-header')

<h4>Research Grants</h4>
@endsection
<style type="text/css">
.ui-datepicker {
	background-color: #fff;
	border: 1px solid #66AFE9;
	border-radius: 4px;
	box-shadow: 0 0 8px rgba(102,175,233,.6);
	display: none;
	margin-top: 4px;
	padding: 10px;
	width: 240px;
}
.ui-datepicker a,
.ui-datepicker a:hover {
	text-decoration: none;
}
.ui-datepicker a:hover,
.ui-datepicker td:hover a {
	color: #2A6496;
	-webkit-transition: color 0.1s ease-in-out;
	-moz-transition: color 0.1s ease-in-out;
	-o-transition: color 0.1s ease-in-out;
	transition: color 0.1s ease-in-out;
}
.ui-datepicker .ui-datepicker-header {
	margin-bottom: 4px;
	text-align: center;
}
.ui-datepicker .ui-datepicker-title {
	font-weight: 700;
}
.ui-datepicker .ui-datepicker-prev,
.ui-datepicker .ui-datepicker-next {
	cursor: default;
	font-family: 'Glyphicons Halflings';
	-webkit-font-smoothing: antialiased;
	font-style: normal;
	font-weight: normal;
	height: 20px;
	line-height: 1;
	margin-top: 2px;
	width: 30px;
}
.ui-datepicker .ui-datepicker-prev {
	float: left;
	text-align: left;
}
.ui-datepicker .ui-datepicker-next {
	float: right;
	text-align: right;
}
.ui-datepicker .ui-datepicker-prev:before {
	content: "\e079";
}
.ui-datepicker .ui-datepicker-next:before {
	content: "\e080";
}
.ui-datepicker .ui-icon {
	display: none;
}
.ui-datepicker .ui-datepicker-calendar {
	table-layout: fixed;
	width: 100%;
}
.ui-datepicker .ui-datepicker-calendar th,
.ui-datepicker .ui-datepicker-calendar td {
	text-align: center;
	padding: 4px 0;
}
.ui-datepicker .ui-datepicker-calendar td {
	border-radius: 4px;
	-webkit-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
	-moz-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
	-o-transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
	transition: background-color 0.1s ease-in-out, color 0.1s ease-in-out;
}
.ui-datepicker .ui-datepicker-calendar td:hover {
	background-color: #eee;
	cursor: pointer;
}
.ui-datepicker .ui-datepicker-calendar td a {
	text-decoration: none;
}
.ui-datepicker .ui-datepicker-current-day {
	background-color: #4289cc;
}
.ui-datepicker .ui-datepicker-current-day a {
	color: #fff
}
.ui-datepicker .ui-datepicker-calendar .ui-datepicker-unselectable:hover {
	background-color: #fff;
	cursor: default;
}
</style>


@section('main')
<!--search filter-->
<div id="filter">
	<div class="row">
		<!--<div class="col-md-12">-->
		
		
		{!! Form::open(['route'=>'adminResearchGrantView','method' => 'get', 'class' => 'form-inline','files'=>true]) !!}
		

		<div class="form-group">
			<div class="checkbox">
				<!--<p>Search:</p>-->

				Status:
				<label>
					<input type="checkbox" name="status[]" id = "status" value=0> New/Pending
				</label>

				<label>
					<input type="checkbox" name="status[]" id = "status" value=1> Changes Required
				</label>

				<label>
					<input type="checkbox" name="status[]" id = "status" value=2> Accepted
				</label>

				<label>
					<input type="checkbox" name="status[]" id = "status" value=3> Rejected
				</label>
			</div>

			{!! Form::select('searchlist', $cat_select_options,$search) !!}

			<input type="text" class="form-control" name="search" id="search_text" value="{{$search_text}}" placeholder="Enter text">

			<!--<div class="form-group">-->
			<!-- <label for="start_date">Start Date</label>-->
			{!! Form::text('start_date', $fromDate, ['class'=>'form-control', 'id'=>'start_date' ,'placeholder'=>'Select Start Date'])!!}
			

			
			<!--<label for="end_date">End Date</label>-->
			{!! Form::text('end_date', $toDate, ['class'=>'form-control', 'id'=>'end_date' ,'placeholder'=>'Select End Date'])!!}
			
			<button type="submit" class="btn btn-warning pull-right btn-sm"><span class="glyphicon glyphicon-search" area-hidden="true"></span> SEARCH</button>
			<!-- </div>-->
			{!! Form::close() !!}
		</div>
		<!--</div>-->
	</div>
</div> 
<!--search ends-->
<h3 class="section-header-style">Research Grants Requests</h3>
<div class="panel panel-default panel-list">
	<div class="panel-heading compact-pagination ">
		<div class="row">
			<div class="col-md-3">
				{{-- other content --}}
			</div>
			
			<div class="col-md-4">
				
			</div>
		</div>
	</div>

	<!-- panel-body -->
	<div class="panel-body">
		@if(!($user->isEmpty()))
		@foreach($user as $u)
		{!! Form::open(['files' =>true,'method' => 'get','class' => 'form-inline']) !!}
		
		<div class="card">
			<div class="row">
				<div class="col-md-6">
					<p>
						<span>MemberId: {{$u->user_id}}</span>
						<br/><span>Title: {{$u->proposalversion->first()->title}}</span>
						<br/><span>Member Email Id: {{$u->memberProposal->email}}</span>
						@if($u->memberProposal->membership_id==1)
						<br/><span>Institution Name: {{$u->memberProposal->institution->name}}</span>
						@else
						<br/><span>Member Name: {{$u->memberProposal->individual->first_name}} with MemberID{{$u->memberProposal->individual->member_id}}</span>
						@endif
					</p>
				</div>
				
				<div class="col-md-2" style="margin-top:20px;">
					@if($u->proposalversion->first()->research_status==2)
					<h5 class="label label-success"><span <span class="glyphicon glyphicon-ok"></span><b> Accepted</b></h5>
					@elseif($u->proposalversion->first()->research_status==3)
					<h5 class="label label-danger"><span class="glyphicon glyphicon-remove"></span><b> Rejected</b></h5>
					@elseif($u->proposalversion->first()->research_status==0)
					<h5 class="label label-primary"><span class="glyphicon glyphicon-asterisk"></span><b> New/Pending</b></h5> 
					@elseif($u->proposalversion->first()->research_status==1)
					<h5 class="label label-warning"><span class="glyphicon glyphicon-repeat"></span><b> Changes Required</h5>
					@endif
					<br>
				</div>

				<div class="col-md-2" style="padding-top: 15px;">
					<!--<ul class="list-unstyled" style="font-size: 16px">-->
					@if(($u->proposalversion->first()->research_status==0)||($u->proposalversion->first()->research_status==1))
					<a href="{{action('adminResearchGrantController@commentsandstatus',[$u->proposalversion->first()->id])}}" class="btn btn-info"><span class="glyphicon glyphicon-check"></span> Verify Version</a>
					@endif		
					<!--</ul>-->
				</div>
				<div class="col-md-2" style="padding-top: 15px;">
					<a class="btn btn-warning" href="admin_showversions/{{$u->id}}">View Version</a>
				</div>
			</div>
		</div>
		
		
		@endforeach
		@else
		<p>No records</p>
		@endif	
	</div>   


	
	<!-- panel-footer -->

	<div class="panel-footer compact-pagination">
		<div class="row">
			<div class="col-md-3">
				{{-- other content --}}
			</div>
			<div class="col-md-9">
				
			</div>
		</div>
	</div>
	
	@endsection 
	@section('footer-scripts')
	<script>
	$(function() {

		$( "#start_date" ).datepicker({
			dateFormat : 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		}).val();

		$( "#end_date" ).datepicker({
			dateFormat : 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
		}).val();
	});
	</script>
	<script src={{ asset("js/validateit.js") }}></script>
	@endsection
