function init(){
	window.timeline = new VCO.Timeline('timeline', timeline_vars.json_url, {
// Options go here.
    	      });
    	};
  	document.addEventListener('DOMContentLoaded', init, false);
  	window.onresize = function(event) {
  	      	timeline.updateDisplay();
  	      }