$(document).ready(function(){
    function checkValid(type)
    {
       $.post(
        "http://"+server+"/~e54061/wp/movie-service.php" ,
        {
            CRC:'s3493577',
            filmID:type
        },
        function(data){
            $('#'+type).html(data);
        });
    }
    $("#code").on('input', function() {
        $("#result").html("Checking code...");
        var check = $("#code").val();
        if (/\d{5}-\d{5}-[A-Z]{2}/g.test(check))
        {
            $.post(
            "checkcode.php", { code:$("#code").val() },
            function(data) {
                if (data == "1")
                    $("#result").html("Success :)");
                else
                    $("#result").html("Invalid code");
            });
        }
        else if (check.length == 0)
            $("#result").html("");
        else
            $("#result").html("Wrong format");
    });
});

