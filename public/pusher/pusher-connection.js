/**
 * Created by ma3xc on 15/12/2016.
 */

var pusher = new Pusher("402e624a6faaa230eb2d", {
    auth: {
        headers: {
            'X-CSRF-Token': $('#application-token').data('token'),
            '_token'    : $('#application-token').data('token')
        }
    }
});
var channel = pusher.subscribe('private-'+Pheaks.user_name);
channel.bind('pusher:subscription_error', function(status) {
    console.log(status);
    if(status == 408 || status == 503){
        // retry?
    }
});
channel.bind('pusher:subscription_succeeded', function() {
    //console.log('Pusher connection succesfully');
});