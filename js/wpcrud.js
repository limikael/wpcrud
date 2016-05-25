jQuery(document).ready(function($) {

	// Initialize the date time picker for timestamp fields.
	$('.wpcrud-timestamp').datetimepicker({
		format: 'Y-m-d H:i'
	});

	// Initialize media-image references.
	var fileFrame;
	var mediaImageId;

	$('.wpcrud-media-image-link').on('click',function(event){
		mediaImageId=$(this).attr("media-image-id");
		event.preventDefault();

		if (!fileFrame) {
			fileFrame = wp.media.frames.file_frame = wp.media({
				title: "Select Media Library Image", //$(this).data( 'File upload' ),
				button: {
					text: "Select",
				},
				multiple: false
			});

			// When an image is selected, run a callback.
			fileFrame.on('select', function() {
				attachment = fileFrame.state().get('selection').first().toJSON();
				$("#"+mediaImageId+"-image").attr("src",attachment.url);
				$("#"+mediaImageId).val(attachment.url);
			});
		}

		fileFrame.options.title="asdfasdf";

		console.log(fileFrame);

		// Finally, open the modal
		fileFrame.open();
	});
});
