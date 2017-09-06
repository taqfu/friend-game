$(document.body).ready(function () {
    $(document).on("click", ".msgKeys", function (event) {
        $currentMsg = $("#msgInput").val();
        $currentMsg += event.target.value;
        $("#msgInput").val($currentMsg);
        //console.log($("#msgInput").val());
    });
    $(document).on("click", "#delKey", function (event) {
        $currentMsg = $("#msgInput").val();
        $currentMsg = $currentMsg.slice(0, -1);
        $("#msgInput").val($currentMsg);
        //console.log($("#msgInput").val());
    });
});
