<?php 
class agPicupload{

    public function __construct(){

    }
    public static function ag_download_image_to_media_library($file_url) {
        
        $user_id = get_current_user_id();
        // Get the file data from the URL
        $file_data = file_get_contents($file_url);

        if ($file_data !== false) {
            // Create a unique filename for the image
            $file_name = basename($file_url);
            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['path'] . '/' . $file_name;

            // Save the image to the uploads directory
            file_put_contents($upload_path, $file_data);

            // Prepare the attachment data
            $attachment = array(
                'guid'           => $upload_dir['url'] . '/' . $file_name,
                'post_mime_type' => mime_content_type($upload_path),
                'post_title'     => sanitize_file_name(pathinfo($file_name, PATHINFO_FILENAME)),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'post_author'    => $user_id,
                
            );

            // Insert the attachment into the media library
            $attach_id = wp_insert_attachment($attachment, $upload_path);

            // Generate attachment metadata and update the attachment
            require_once ABSPATH . 'wp-admin/includes/image.php';
            $attach_data = wp_generate_attachment_metadata($attach_id, $upload_path);
            wp_update_attachment_metadata($attach_id, $attach_data);

            return $attach_id; // Return the attachment ID
        } 

    }


}