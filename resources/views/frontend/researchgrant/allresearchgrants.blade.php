@extends('frontend.master')

@section('title', 'Grants')

@section('section-after-mainMenu')

@endsection
@section('main')
	<section>
		  <div class="container-fluid">
		@if(($users))
	<h3></h3>
			
			<h3>Listing All Research Grant Requests</h3>
			
			
	                
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
               				 @foreach ($arr as $a)

               				 
								<div class="listing-items">
		                        	<div class="row">
										<div class="col-md-6">
											<p>
											<span><b>Grant money: Rs{{$a->granted_amount}}/-</b></span>
											<br/><span>Version #{{$a->version_number}}</span>
											<br/><span>Title: {{$a['title']}}</span> 
											<br/><span>Field: {{$a['field']}}</span>
			                            	</p>  
					                    </div>
										<div class="col-md-2">
											@if($a->research_status==0)
           										 <h4 class="label label-primary"><span class="glyphicon glyphicon-asterisk"></span><b>New/Pending</b></h4>
           									@elseif($a->research_status==1)
	           									<h4 class="label label-warning"><span class="glyphicon glyphicon-repeat"></span><b>Changes Required</b></h4>
        									@elseif($a->research_status==2)
            									 <h4 class="label label-success"><span class="glyphicon glyphicon-ok"></span><b>Accepted</b></h4>
            				                     <br/>
											@elseif($a->research_status==3)
            									 <h4 class="label label-danger"><span class="glyphicon glyphicon-remove"></span><b>Rejected</b></h4>
            									 <br>
												
            								@endif
										</div>

										<div class="col-md-2">
											
											<a class="btn btn-info" href="\showversions\{{$a->proposal_id}}" >View Version</a>
										</div>
										<!-- Version number in array-->
										<div class="col-md-1">
											@if(($a->research_status==1))
           										 <a  class="btn btn-warning" href="{{ action('ResearchGrantController@grantversions',array($a->proposal_id)) }}">Update</a>
        									@elseif(($a->research_status==2)||($a->research_status==3)||($a->research_status==0))
            									 <!-- no update -->
            								@endif
										</div>
					                    
					                 </div>
		                        </div>
							@endforeach
                   			<center>{!! $arr->render() !!}</center>
               			 </div>
               			 @else
	    	<p>No records</p>
	    @endif    
	                    <!-- panel-footer -->
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
	                <!-- /.panel -->
	            </div>
	</section>

	        
	          
@endsection


