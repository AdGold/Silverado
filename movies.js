$(document).ready(function(){
    function getMovie(type)
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
    var types = ['RC','AC','FO','CH'];
    for (t in types)
    {
        getMovie(types[t]);
    }
});

