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
           }
       });
   });

    const channel = pusher.subscribe('file-upload-info');

    channel.bind_global(function(eventName, data) {
        console.log(data.text)
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
            },
            error: function(xhr, status, error) {
                console.error('Image upload failed:', status, error, xhr);
            }
        });
    });
});
