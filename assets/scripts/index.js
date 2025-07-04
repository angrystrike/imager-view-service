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

    $('#imageUploadForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: '/upload',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#uploadStatus').text('Upload successful: ' + response.message);
                console.log('Image upload successful:', response);
            },
            error: function(xhr, status, error) {
                $('#uploadStatus').text('Upload failed: ' + xhr.responseJSON.message);
                console.error('Image upload failed:', status, error, xhr);
            }
        });
    });
});
