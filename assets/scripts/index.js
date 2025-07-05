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

    const infoChannel = pusher.subscribe('file-upload-info');
    infoChannel.bind_global(function(eventName, data) {
        console.log(data)
    });

    const newImagesChannel = pusher.subscribe('new-images');
    newImagesChannel.bind('image-uploaded', function(data) {
        $('.js-images-container').append(`
            <div class="image-container">
                <h2>Image new</h2>
                <img src="${data.url}" alt="new image">
            </div>
        `);
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
