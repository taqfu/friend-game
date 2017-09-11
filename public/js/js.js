console.log("FUCK1");
$(document.body).ready(function () {
    console.log("FUCK2");
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

console.log("FUCK3");
