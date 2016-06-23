@extends('backend.master')
@section('title', 'Research Grant')
@section('main')
	<section id="main">
   		<div class="container">
   			<div class="row">
   				<div class="col-md-12">
   					<div>
					  	<h1 class="section-header-style">Verify Version</h1>
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
					</div>
					@foreach($arr as $a)
   					{!! Form::open([ 'route' => ['makechanges', 'id'=>$a->proposal_id],'id'=>"research_verify_form", 'files' => true]) !!}
					  <div class="steps">
																	
						<div class="form-group">
							<label for="title">Title: </label>
							{!! Form::label('title',$a->title) !!}
						</div>	
						<div class="form-group">
							<label for="description">Author's Description: </label>
							{!! Form::label('description',$a->description) !!}
						</div>	



						<div class="form-group">
							<label for="file_link">File: </label>
							
							<a href="{{action('adminResearchGrantController@viewfile',[$a->version_path])}}">Click To View</a>
						

							</div>				
					

						<div class="form-group">
							<label for="status">Change Status: </label>
							{!! Form::select('status', [0=>'New/Pending ', 1=>'Changes Required ', 2=> 'Accept ', 3=> 'Reject']) !!}
						</div>	

                        <div class="form-group">
							<label for="comments">Add Your Description: </label>
							{!! Form::textarea('message',"",['class' => 'form-control', 'limit'=>50]) !!}
						</div>
                       
						<div class="form-group">
							{!! Form::input("submit","submit", "done",['class' => 'form-control btn btn-warning']) !!}
						</div>
						
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
	<script src={{ asset('js/description.js') }}></script>
@endsection
