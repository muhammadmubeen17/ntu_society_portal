<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Get Upload Directory (Monthly Directory)
 *
 * @param  mixed $module
 * @return $uploads_dir
 */
if (!function_exists('hc_get_uploads_directory_monthly')) {
    function hc_get_uploads_directory_monthly($module = '', $society_name = '')
    {
        // $module_path = Module::getModulePath($module);
        // $uploads_dir = $module_path . '/uploads/';
        $uploads_dir = public_path('/uploads/' . $module . '/uploads/' . $society_name . '/');

        $year = date('Y');
        $month = date('m');

        $custom_directory = $uploads_dir . $year . '/' . $month;

        // create monthly directory if not exists
        if (!file_exists($custom_directory)) {
            mkdir($custom_directory, 0777, true);
        }
        return $custom_directory;
    }
}

/**
 *  Get Image Path Attachments
 */
if (!function_exists('hc_store_and_get_image_path')) {
    function hc_store_and_get_image_path($module, $file)
    {
        $image_path = str_replace(' ', '', $file->getClientOriginalName());
        // $unique_id  = uniqid();
        // $image_path = $unique_id . '-' . $image_path;
        $timestamp  = now()->format('d_m_Y_His');
        $image_path = "{$timestamp}_{$image_path}";
            
        $file->move(hc_get_uploads_directory_monthly($module), $image_path);

        $image_path = date('Y') . '/' . date('m') . '/' . $image_path;

        return $image_path;
    }
}

/**
 *  Get Image Path Attachments
 */
if (!function_exists('hc_store_and_get_society_image_path')) {
    function hc_store_and_get_society_image_path($module, $society_name, $file)
    {
        $image_path = str_replace(' ', '', $file->getClientOriginalName());
        $society_name = str_replace(' ', '-', $society_name);
        // $unique_id  = uniqid();
        // $image_path = $unique_id . '-' . $image_path;
        $timestamp  = now()->format('d_m_Y_His');
        $image_path = "{$timestamp}_{$image_path}";
            
        $file->move(hc_get_uploads_directory_monthly($module, $society_name), $image_path);

        $image_path = $society_name . '/' . date('Y') . '/' . date('m') . '/' . $image_path;

        return $image_path;
    }
}

/**
 *  Insert Attachments
 */
if (!function_exists('hc_insert_attachment')) {
    function hc_insert_attachment($module, $file)
    {
        $image_path = str_replace(' ', '', $file->getClientOriginalName());
        $file_path = $file->path();
        $file_extension = $file->getClientOriginalExtension();
        $file_name = pathinfo($image_path, PATHINFO_FILENAME);

        $unique_id = uniqid();

        $file_meta = hc_generate_thumbnails($file_path, $unique_id . '-' . $file_name, $module, $file_extension);

        $image_path = $unique_id . '-' . $image_path;
        $file->move(hc_get_uploads_directory_monthly($module), $image_path);

        $image_path = date('Y') . '/' . date('m') . '/' . $image_path;

        $attachment = new Attachments();
        $attachment->user_id = auth()->user()->id;
        $attachment->group_id = auth()->user()->group_id;
        $attachment->home_id = auth()->user()->home_id;
        $attachment->file_name = isset($file_meta['file']) ? $file_meta['file'] : '';
        $attachment->file_type = isset($file_meta['mime-type']) ? $file_meta['mime-type'] : '';
        $attachment->file_meta = isset($file_meta) ? json_encode($file_meta) : '';
        $attachment->status = 'attached';
        $attachment->module = $module;
        $attachment->save();

        $attachment_id = $attachment->id;

        return $attachment_id;
    }
}

/**
 *  Magic make sizes
 */
if (!function_exists('hc_generate_thumbnails')) {
    function hc_generate_thumbnails($file_path, $file_name, $module, $extension)
    {
        $file_meta = [];
        $file_meta['file'] = date('Y') . '/' . date('m') . '/' . $file_name . '.' . $extension;
        $file_meta['mime-type'] = $extension;

        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $allowed_sizes = hc_get_allowed_image_sizes();

            foreach ($allowed_sizes as $size => $values) {
                $image_resizer = Image::make($file_path);
                $image_resizer
                    ->resize($values['width'], $values['height'], function ($const) {
                        $const->aspectRatio();
                    })
                    ->save(hc_get_uploads_directory_monthly($module) . '/' . $file_name . '-' . $values['width'] . 'x' . $values['height'] . '.' . $extension);

                $file_meta['sizes'][$size] = [
                    'file' => date('Y') . '/' . date('m') . '/' . $file_name . '-' . $values['width'] . 'x' . $values['height'] . '.' . $extension,
                    'width' => $values['width'],
                    'height' => $values['height'],
                    'mime-type' => $extension,
                ];
            }
        }

        return $file_meta;
    }
}

/**
 *  Magic allowed image sizes
 */
if (!function_exists('hc_get_allowed_image_sizes')) {
    function hc_get_allowed_image_sizes()
    {
        $allowed_sizes = [
            'thumb_120_80' => [
                'width' => 120,
                'height' => 80,
            ],
            'thumb_250_270' => [
                'width' => 250,
                'height' => 270,
            ],
            'medium_1024_1000' => [
                'width' => 1024,
                'height' => 1000,
            ],
            'large_1400_1200' => [
                'width' => 1400,
                'height' => 1200,
            ],
        ];

        return $allowed_sizes;
    }
}

/**
 *  Delete attachments
 */
if (!function_exists('hc_delete_attachment')) {
    function hc_delete_attachment($attachment_id)
    {
        if (is_null($attachment_id)) {
            return;
        } // bail out

        $attachment = DB::table('attachments')
            ->where('id', $attachment_id)
            ->get()
            ->toArray();
        $attachment = isset($attachment[0]) ? $attachment[0] : [];

        if (!empty($attachment)) {
            $file_meta = isset($attachment->file_meta) ? json_decode($attachment->file_meta, true) : [];
            $original_file = $file_meta['file'];
            $sizes = isset($file_meta['sizes']) ? $file_meta['sizes'] : [];

            // delete original image
            hc_delete_attachment_from_directory($original_file, $attachment->module);

            if (!empty($sizes)) {
                foreach ($sizes as $size) {
                    // delete variations
                    hc_delete_attachment_from_directory($size['file'], $attachment->module);
                }
            }
        }

        // delete from database;
        DB::table('attachments')
            ->where('id', $attachment_id)
            ->delete();
    }
}

/**
 *  Delete attachment from directory
 */
if (!function_exists('hc_delete_attachment_from_directory')) {
    function hc_delete_attachment_from_directory($file, $module)
    {
        $upload_dir = 'uploads/' . $module . '/uploads/';

        // delete from directory
        if (File::exists($upload_dir . $file)) {
            // Delete from the directory
            File::delete($upload_dir . $file);
        }
    }
}

?>