<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Helpers\Exception;

class CommonHelpers
{



    public static function uploadSingleFile($file, $path = 'public/uploads/images/', $types = "png,gif,csv,jpeg,jpg", $filesize = '20000', $rule_msgs = [])
    {
        $path = $path . date('Y') . '/';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
       
        $rules = array('file' => 'required|mimes:' . $types . "|max:" . $filesize);
        
        $validator = \Validator::make(array('file' => $file), $rules, $rule_msgs);
        if ($validator->passes()) {
            $rand = time() . "_" . \Str::random(15) . "_";
            $f_name = $rand . $file->getClientOriginalName();
            $filename = $path . $f_name;
            //full size image
            $file->move($path, $f_name);
            return $filename;
        } else {
            return ['error' => $validator->errors()->first('file')];
        }
    }

    public static function createThumbnail($filepath, $width = 500, $height = 500)
    {
        $img = \Image::make($filepath);
        //this so name can be broken
        $path = explode('/', $filepath);
        $f_name = "thumbnail_".last($path);
        //sticting the name and path again
        $path = str_replace(last($path), '', $filepath);
        $filename = $path . $f_name;

        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($filename, 80);
        return $filename;
    }


}
