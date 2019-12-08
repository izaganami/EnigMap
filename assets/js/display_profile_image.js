$(document).ready(function(){
    // when user clicks on the upload profile image button ...
    $(document).on('click', '#profile_img', function(){
        // ...use Jquery to click on the hidden file input field
        $('#profile_input').click();
        // a 'change' event occurs when user selects image from the system.
        // when that happens, grab the image and display it
        $(document).on('change', '#profile_input', function(){
            // grab the file
            var file = $('#profile_input')[0].files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    // set the value of the input for profile picture
                    $('#profile_input').attr('value', file.name);
                    // display the image
                    $('#profile_img').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
});