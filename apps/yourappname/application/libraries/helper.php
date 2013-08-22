<?php

class Helper
{
    public static function upload($post_id, $files_array, $type) {

        switch ($type) {
            case 'IMAGE':
                $allowed_extensions = array (
                    'bmp', 'gif', 'jpg', 'jpe', 'jpeg', 'png', 'pspimage', 'thm', 'tif', 'yuv', // Images
                );
                break;

            case 'VIDEO':
                $allowed_extensions = array (
                    '3g2', '3gp', 'asf', 'asx', 'avi', 'flv', 'mp4', 'm2v', 'm4v', 'f4v', 'mov', 'mpg', 'rm', 'swf', 'vob', 'wmv', 'ogv', 'ogg' // Videos
                );
                break;

            case 'IMAGE/VIDEO':
                $allowed_extensions = array (
                    'bmp', 'gif', 'jpg', 'jpe', 'jpeg', 'png', 'pspimage', 'thm', 'tif', 'yuv', // Images
                    '3g2', '3gp', 'asf', 'asx', 'avi', 'flv', 'mp4', 'm2v', 'm4v', 'f4v', 'mov', 'mpg', 'rm', 'swf', 'vob', 'wmv', 'ogv', 'ogg' // Videos
                );
                break;

            default:
                $allowed_extensions = array ();
                break;
        }
        $ext = File::extension($files_array['name']);
        if (!in_array($ext, $allowed_extensions)) {
            return false;
        }

        // Upload locally
        $path = '../../public/apps/'.APPSOLUTE_FOLDER.'/uploads/';
        $fileName =  preg_replace('/\s+/', '-', pathinfo($files_array['name'], PATHINFO_FILENAME).'_'.time().'.'.pathinfo($files_array['name'], PATHINFO_EXTENSION));
        $upload = Input::upload($post_id, $path , $fileName);
        // Copy to S3
        $inputS3 = S3::inputFile((string)$upload, false);
        if(S3::putObject($inputS3, 'votingapps', $fileName, S3::ACL_PUBLIC_READ)) {
            // Delete locally if S3 upload was successful
            unlink($upload);

            $video_extensions = array (
                '3g2', '3gp', 'asf', 'asx', 'avi', 'flv', 'mp4', 'm2v', 'm4v', 'f4v', 'mov', 'mpg', 'rm', 'swf', 'vob', 'wmv', 'ogv', 'ogg' // Videos
            );
            if (!in_array($ext, $video_extensions)) {
                // Don't transcode images
                //return 'https://votingapps.s3.amazonaws.com/'.$fileName;
                return 'https://s3-eu-west-1.amazonaws.com/votingapps/'.$fileName;
            }

            // Prepare output file name and url
            $transcodedFile = str_replace('.'.$ext, '', $fileName);
            if (strtolower($ext) == 'mp4') {
                $transcodedFile = $transcodedFile.'-transcoded';
            }
            //$upload_url = 'https://votingapps.s3.amazonaws.com/'.$transcodedFile.'.mp4';
            $upload_url = 'https://s3-eu-west-1.amazonaws.com/votingapps/'.$transcodedFile.'.mp4';

            // Attempt transcoding
            $client = Aws\ElasticTranscoder\ElasticTranscoderClient::factory(array(
                'key'    => Config::get('s3.access_key'),   //'AKIAIB7IO2W2XBIRSV7Q',
                'secret' => Config::get('s3.secret_key'),   //'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',
                'region' => 'eu-west-1'
            ));

            $args_job_input = array();
            $args_job_input['Key'] = $fileName;
            $args_job_input['FrameRate'] = "auto";
            $args_job_input['Resolution'] = "auto";
            $args_job_input['AspectRatio'] = "auto";
            $args_job_input['Interlaced'] = "auto";
            $args_job_input['Container'] = "auto";

            $args_job_output = array();
            $args_job_output['Key'] = $transcodedFile.'.mp4';
            $args_job_output['ThumbnailPattern'] = $transcodedFile.'-{count}';
            $args_job_output['Rotate'] = "0";
            //$args_job_output['PresetId'] = "1351620000001-100070";
            $args_job_output['PresetId'] = "1376294562068-qycjag";

            $args_job_outputs[0] = $args_job_output;

            $args_job = array();
            $args_job['PipelineId'] = "1375889847769-20rm31";
            $args_job['Input'] = $args_job_input;
            $args_job['Outputs'] = $args_job_outputs;

            $client->createJob($args_job);
        } else {
            $upload_url = 'uploads/'.$files_array['name'];
        }
        return $upload_url;
    }
}