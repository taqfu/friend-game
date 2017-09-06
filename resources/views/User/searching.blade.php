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
<div >
Searching for another player willing to wager {{$wager}} points<span id='countdown'>...</span>
</div >
<div >

<a href = "{{route ("home")}}" >Back </a >
</div >

</body></html>
