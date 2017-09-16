

$(document.body).ready(function () {

    if ($("#numOfMsgs").length && $("#matchID").length && $("#matchStatus").length){
      setInterval(checkForUpdate, 1000 );
      scrollToTheBottom();

    }
    $(document).on("click", ".msgKeys", function (event) {
        $currentMsg = $("#msgInput").val();
        $currentMsg += event.target.value;
        $("#msgInput").val($currentMsg);
    });
    $(document).on("click", "#delKey", function (event) {
        $currentMsg = $("#msgInput").val();
        $currentMsg = $currentMsg.slice(0, -1);
        $("#msgInput").val($currentMsg);
    });
});


function checkForUpdate(){
    matchID = $("#matchID").val();
    statusArr = [$("#matchStatus").val()=="null" ? null : $("#matchStatus").val(), Number($("#numOfMsgs").val())];
    console.log("/match/" + matchID + "/status");
    $.get("/match/" + matchID + "/status", function (data){
      arr=JSON.parse(data);
      if (arr[0]!=statusArr[0]){
          refreshStatus(matchID);
          $("#matchStatus").val(arr[0]);
      }
      if (arr[1]!=statusArr[1]){
              getNewMessages(matchID, statusArr[1]);
              $("#numOfMsgs").val(arr[1]);
              setTimeout(scrollToTheBottom, 500);
      }

      console.log(matchID, arr[0]==statusArr[0], typeof arr[0], arr[0], typeof statusArr[0], statusArr[0]);
      console.log(matchID, arr[1]==statusArr[1], typeof arr[1], arr[1], typeof statusArr[1], statusArr[1]);
    });
}
function getNewMessages(matchID, numOfOldMsgs){
    $.get("/match/" + matchID + "/msg/new/" + numOfOldMsgs, function (data){
      $("#matchNewMsgs").replaceWith(data);
    });


}
function refreshStatus(matchID){
    $.get("/match/" + matchID + "/statusMsg", function (data){
        $("#matchStatusMsg").html(data);
    });
    $.get("/match/" + matchID + "/menu", function (data){
        $("#matchMenu").html(data);
    });

}
function scrollToTheBottom(){
  console.log("START", $("#matchMsgs")[0].scrollTop, $("#matchMsgs")[0].scrollHeight);
  var myDiv = $("#matchMsgs").get(0);
myDiv.scrollTop = myDiv.scrollHeight;

console.log("END", $("#matchMsgs")[0].scrollTop, $("#matchMsgs")[0].scrollHeight);


}
