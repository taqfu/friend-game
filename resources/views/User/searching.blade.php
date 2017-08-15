<html><script>
maxNumberOfCharacters=3;
countdown="...";
direction=0;
setInterval(function(){
	if (direction){
	   countdown=countdown + ".";
	} else {
	    countdown=countdown.slice(0,-1);
	}
	document.getElementById('countdown').innerHTML=countdown;
	if (maxNumberOfCharacters==countdown.length && direction){
   		window.location.reload(1);
	} 
	if (countdown.length==1){
	    direction=1;
	}
}, 500);
</script><body>

Searching for a {{$wager}} point match<span id='countdown'>...</span>
</body></html>
