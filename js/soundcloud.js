/**
 * Created by Ken Fontijne on 15-3-2016.
 */

//Connect to soundcloud
SC.initialize({
    client_id: '4538efdc5bdc167e29a65c3c3404bf1a'
});


//Stream sound of specific emotion
function streamSad()
{
    SC.stream('/tracks/251958056').then(function(player){
        player.play();
    });
}


