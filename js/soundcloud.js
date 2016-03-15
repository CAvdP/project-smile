/**
 * Created by Ken Fontijne on 15-3-2016.
 */
SC.initialize({
    client_id: '4538efdc5bdc167e29a65c3c3404bf1a'
});

function stream()
{
    SC.stream('/tracks/251958056').then(function(player){
        player.play();
    });
}

switch(){
    case 1:
        stream();
        break;
    case 2:
        stream();
        break;
    case 3:
        stream();
        break;
    case 4:
        stream();
        break;
}
