/**
 * Created by Ken Fontijne on 15-3-2016.
 */

//Connect to soundcloud
SC.initialize({
    client_id: '4538efdc5bdc167e29a65c3c3404bf1a'
});


//Stream sound of specific emotion
function streamAngry()
{
    SC.stream('/tracks/252585653').then(function(player){
        player.play();
    });
}

function streamSad()
{
    SC.stream('/tracks/252585644').then(function(player){
        player.play();
    });
}

function streamSurprised()
{
    SC.stream('/tracks/188284691').then(function(player){
        player.play();
    });
}

function streamHappy()
{
    SC.stream('/tracks/252585649').then(function(player){
        player.play();
    });
}
