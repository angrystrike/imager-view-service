import pusher from './pusher';

$(document).ready(function() {
   $('.test').click(function () {
       $.ajax({
           url: '/hello',
           method: 'GET',
           dataType: 'json',
           success: function(response) {
               console.log('AJAX request successful:', response);
           },
           error: function(xhr, status, error) {
               console.error('AJAX request failed:', status, error, xhr);
               alert('AJAX Failed! Check console for errors.');
           }
       });
   });

    const channel = pusher.subscribe('my-channel');

    channel.bind('my-event', function(data) {
        console.log('HELLO FROM SOCKETS', data)
    });
});
