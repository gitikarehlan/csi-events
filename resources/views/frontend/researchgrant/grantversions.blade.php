@extends('frontend.master')
@section('title', 'Update')
@section('main')
	<section id="main">
   		<div class="container">
   			<div class="row">
   				<div class="col-md-12">
   					<div>
					  	<h1 class="section-header-style">Updating research grant form</h1>
					  	
					</div>

					@if ( $errors->any() )
   						
   						<ul class="list-unstyle">
   						<li>
   						@foreach ($errors->all() as $error)
   							<li>{{ $error }}</li>
   						@endforeach
   						</ul>
   					@endif
   					<div class="page-header">
					  <div class="col-md-8">
					  	<h1 id="stepText"> <small id="stepSubText"></small></h1>
					  </div>
					  <div class="col-md-4">
					  	<p class="pull-right" style="    font-size: 14px;    margin: 35px 15px; color: RED;font-weight: bold;letter-spacing: 1px;">field with * are required</p>
					  </div>
					</div>
   					
   					@foreach($arr as $a)
   						{!! Form::open([action('ResearchGrantController@newversion',$a->id),'files' => true]) !!}
					  <div class="steps">
					  	@if($a->research_status==1)
                         <h3 style="color:DarkGray;">Status: Changes Required</h3>
                         @endif	
                         <br/>
						<div class="form-group">
							<label for="field_name" class="req">Field of Research</label>
							{!! Form::text('fieldName', null, ['class' => 'form-control', 'placeholder' => $a->field,'readonly']) !!}
						</div>	
						
						<div class="form-group">
							<label for="title" class="req">Title*</label>
							{!! Form::text('title_g', null, ['class' => 'form-control', 'placeholder' => $a->title]) !!}
						</div>	

						<div class="form-group">
							<label for="research_place" class="req">Place of Research*</label>
							{!! Form::text('researchPlace', null, ['class' => 'form-control', 'placeholder' => $a->research_place]) !!}
						</div>

						<div class="form-group">
							<label for="team_members" class="req">Number of Team Members*</label>
							{!! Form::text('teamMembers', null, ['class' => 'form-control', 'placeholder'=>$a->team_members] ) !!}
						</div>						
				
						<div class="form-group">
							<div class="col-md-4">
							<label for="duration_period" class="req">Duration of Research*</label>
						</div>
							<div class="col-md-4">
							{!! Form::select('durationList', array('choose'=>'Select Duration Criteria',
								         	'weeks'=>'Weeks', 					
								           'months'=>'Months',
								           'year'=>'Year'),'size',array('L'=>'Large','S'=>'Small'),'L')!!}
							</div>
							
							{!! Form::text('duration', null, ['class' => 'form-control', 'placeholder' => $a->duration_of_research]) !!}
						
						
							</div>

						<div class="form-group">
							<label for="grant_needed" class="req">Grant needed*</label>
							{!! Form::text('grantNeeded', null, ['class' => 'form-control', 'placeholder' => $a->proposed_amount]) !!}
						</div>					  	
							
						<div class="form-group">
							<label for="grant_needed" class="req">Proposal's Description*</label>
							{!! Form::textarea('propDescription', null, ['class' => 'form-control', 'limit'=>'100','placeholder'=>$a->description]) !!}
						</div>					
						
						<div class="form-group">
							<label for="grant_file" class="req">Grant Proposal File*</label>
							<input type="file" name="grantProposal" id="grantFile">
							<p class="help-block">Please upload your Proposal.(file type allowed is pdf)</p>
						</div>
						
							<button class="btn btn-warning" name="submit" id="submit">Submit</button>
						
						</div>
						
						
						
					{!! Form::Close() !!}
					@endforeach
   				</div>
   			</div>   			

   		</div>

   	</section>
@endsection


@section('footer-scripts')
	<script src={{ asset("js/validateit.js") }}></script>
	<script src={{ asset('js/researchGrants.js') }}></script>
@endsection

