/**
 * File : addPhoneDirectory.js
 * 
 * This file contain the validation of add phone directory form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Ramesh Fadatare <fadatare.ramesh@gmail.com>
 */

$(document).ready(function(){
	
	var addPhoneDirectoryForm = $("#addPhoneDirectory");
	
	var validator = addPhoneDirectoryForm.validate({
		
		rules:{
			name :{ required : true },
			number : { required : true, digits : true, minlength : 10 },
			alternate_number : { digits : true, minlength : 10 },
			email : { email : true }
		},
		messages:{
			name :{ required : "This field is required" },
			number : { 
				required : "This field is required", 
				digits : "Please enter numbers only",
				minlength : "Please enter at least 10 digits"
			},
			alternate_number : { 
				digits : "Please enter numbers only",
				minlength : "Please enter at least 10 digits"
			},
			email : { email : "Please enter valid email address" }			
		}
	});
});