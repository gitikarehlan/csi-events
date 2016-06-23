var mp;
var url = window.location.origin+'/';
console.log(url);
var formElements = [
	//first object of form elements to be checked for 1st next button click
	{
		'teamMembers': {
			rule: ['required']
		},
		'researchPlace': {
			rule: ['required']
		},
		'duration': {
			rule: ['required']
		},
		'grantNeeded': {
			rule: ['required']
		},
		'fieldName': {
			rule: ['required']
		},
		'title_g': {
			rule: ['required']
		},
		'grantProposal': {
			rule: ['required']
		}		
	}
	
];
$(document).ready(function() {
  $.validateIt({
  	debug: false
  });
});

$(document).ready(function(){
  $("#research_verify_form").submit(function(e){  
		var valueSelected= parseInt( $('select[name="status"] option:selected').val() );
		var description= $('textarea[name="message"]').val();

		if( (1 == valueSelected || 3== valueSelected) && !(description!=undefined && description.trim().length) ){
		  alert("Please Fill in a brief reason");
		  e.preventDefault();
		  return;
		}
		
  });

});