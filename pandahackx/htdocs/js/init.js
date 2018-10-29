(function($){
  $(function(){

    $('.button-collapse').sideNav();
    
    $('select').material_select();
    
    $('.datepicker').pickadate({
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 20, // Creates a dropdown of 15 years to control year
	    min: [1960,1,1],
	    //The illustrated orignial max range of this function is wrong
	    max: [2015,12,31]
	});

  }); // end of document ready
})(jQuery); // end of jQuery name space