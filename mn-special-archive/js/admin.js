//handle color picker
jQuery(document).ready(function($){
    $('#title_color').wpColorPicker({
        defaultColor: $('#title_color').data('default-color')
    });
    
    $('#primary_color').wpColorPicker({
        defaultColor: $('#primary_color').data('default-color')
    });
    
    $('#secondary_color').wpColorPicker({
        defaultColor: $('#secondary_color').data('default-color')
    });

    $('#slider_color').wpColorPicker({
        defaultColor: $('#slider_color').data('default-color')
    });
    
    $('#slider_bg').wpColorPicker({
        defaultColor: $('#slider_bg').data('default-color')
    });

    $('#text_color').wpColorPicker({
        defaultColor: $('#text_color').data('default-color')
    });

    $('#text_bg_color').wpColorPicker({
        defaultColor: $('#text_bg_color').data('default-color')
    });

    $('#text_bg_option').change(function(){
        if($(this).val() == 'color') {
            $('#text_bg').show();
        } else {
            $('#text_bg').hide();
        }
    });

    $('#fallback_bg_color').wpColorPicker({
        defaultColor: $('#fallback_bg_color').data('default-color')
    });
});


//handle video upload
jQuery(document).ready(function($){
    // Toggle visibility based on selection
    $('#video_bg_option').change(function(){
        if($(this).val() == 'custom') {
            $('#video_bg_custom').show();
        } else {
            $('#video_bg_custom').hide();
        }
    });

    // Media Uploader
    var custom_uploader;
    $('#upload_video_button').click(function(e) {
        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        // Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Video',
            button: {
                text: 'Choose Video'
            },
            multiple: false,
            library: {
               type: 'video' // Only allow video uploads
            }
        });

        // Callback for selected image
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#video_bg_url').val(attachment.url);
            //$('#video_filename').text(attachment.filename); // Update the displayed filename
        });


        // Open the uploader dialog
        custom_uploader.open();
    });
});


//handle fallback bg 
jQuery(document).ready(function($){
    // Toggle visibility based on selection
    $('#fallback_bg_option').change(function(){
        if($(this).val() == 'custom') {
            $('#fallback_bg_custom').show();
        } else {
            $('#fallback_bg_custom').hide();
        }
    });

    // Media Uploader
    var custom_uploader;
    $('#upload_image_button').click(function(e) {
        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        // Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false,
            library: {
               type: 'image' // Only allow image uploads
            }
        });


        // Callback for selected image
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#fallback_bg_image').val(attachment.url);
            //$('#fallback_filename').text(attachment.filename); // Update the displayed filename
        });


        // Open the uploader dialog
        custom_uploader.open();
    });
});


//handle logo img 
jQuery(document).ready(function($){
    // Media Uploader
    var custom_uploader;
    $('#upload_logo_button').click(function(e) {
        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        // Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false,
            library: {
               type: 'image' // Only allow image uploads
            }
        });

        // Callback for selected image
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#logo_url').val(attachment.url);
            //$('#fallback_filename').text(attachment.filename); // Update the displayed filename
        });


        // Open the uploader dialog
        custom_uploader.open();
    });
});


//handle asset uploader
jQuery(document).ready(function($){
    // Toggle visibility based on selection
    $('[data-option-type]').change(function(){
        var associatedField = $(this).data('associated-field');
        if($(this).val() == 'custom') {
            $('#' + associatedField).show();
        } else {
            $('#' + associatedField).hide();
        }
    });

    // Media Uploader
    $('[data-uploader-button]').click(function(f) {
        f.preventDefault();

        var fieldId = $(this).data('for');
        
        var custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Asset',
            button: {
                text: 'Choose Asset'
            },
            multiple: false,
            library: {
               type: 'image' // Only allow image uploads. Adjust if you want other types.
            }
        });

        // Callback for selected asset
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#' + fieldId).val(attachment.url);
        });

        // Open the uploader dialog
        custom_uploader.open();
    });
});

