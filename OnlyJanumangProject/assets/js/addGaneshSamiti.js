/**
 * @author Kishor Mali
 */


$(document).ready(function(){
	
	var addGaneshSamitiForm = $("#addGaneshSamiti");
	
	var validator = addGaneshSamitiForm.validate({
		
		rules:{
			serial_number :{ required : true },
			year :{ required : true },
			ganesh_samiti_name :{ required : true, maxlength : 100 },
			establishment : { maxlength : 100 },
			medium_circle_writer : { maxlength : 100 },
			medium_circle_name : { maxlength : 100 },
			group_number : { maxlength : 50 },
			group_name : { maxlength : 100 },
			coordinator : { maxlength : 100 },
			quantity : { maxlength : 50 },
			phone : { maxlength : 20, digits : true },
			helper_name : { maxlength : 100 },
			rep_name : { maxlength : 100 },
			up_sub : { maxlength : 50 },
			pat : { maxlength : 50 },
			mobile_number : { maxlength : 20, digits : true },
			remark : { maxlength : 500 }
		},
		messages:{
			serial_number :{ required : "यह फ़ील्ड आवश्यक है" },
			year :{ required : "यह फ़ील्ड आवश्यक है" },
			ganesh_samiti_name :{ required : "यह फ़ील्ड आवश्यक है", maxlength : "यह फ़ील्ड केवल 100 अक्षर स्वीकार करती है" },
			establishment : { maxlength : "यह फ़ील्ड केवल 100 अक्षर स्वीकार करती है" },
			medium_circle_writer : { maxlength : "यह फ़ील्ड केवल 100 अक्षर स्वीकार करती है" },
			medium_circle_name : { maxlength : "यह फ़ील्ड केवल 100 अक्षर स्वीकार करती है" },
			group_number : { maxlength : "यह फ़ील्ड केवल 50 अक्षर स्वीकार करती है" },
			group_name : { maxlength : "यह फ़ील्ड केवल 100 अक्षर स्वीकार करती है" },
			coordinator : { maxlength : "यह फ़ील्ड केवल 100 अक्षर स्वीकार करती है" },
			quantity : { maxlength : "यह फ़ील्ड केवल 50 अक्षर स्वीकार करती है" },
			phone : { maxlength : "यह फ़ील्ड केवल 20 अक्षर स्वीकार करती है", digits : "यह फ़ील्ड केवल संख्या स्वीकार करती है" },
			helper_name : { maxlength : "यह फ़ील्ड केवल 100 अक्षर स्वीकार करती है" },
			rep_name : { maxlength : "यह फ़ील्ड केवल 100 अक्षर स्वीकार करती है" },
			up_sub : { maxlength : "यह फ़ील्ड केवल 50 अक्षर स्वीकार करती है" },
			pat : { maxlength : "यह फ़ील्ड केवल 50 अक्षर स्वीकार करती है" },
			mobile_number : { maxlength : "यह फ़ील्ड केवल 20 अक्षर स्वीकार करती है", digits : "यह फ़ील्ड केवल संख्या स्वीकार करती है" },
			remark : { maxlength : "यह फ़ील्ड केवल 500 अक्षर स्वीकार करती है" }
		}
	});
});
