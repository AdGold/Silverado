$(document).ready(function(){
    alert(Server);
    var types = ['RC','AC','FO','CH'];
    for (t in types)
    {
        $.post(
        "http://"+server+"/~e54061/wp/movie-service.php" ,
        {
            CRC:'s3493577',
            filmID:types[t]
        },
        function(data){
            $('#'+types[t]).html(data);
        });
    }
});

