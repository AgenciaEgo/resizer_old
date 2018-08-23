<?php
namespace AgenciaEgo\Resizer;

use Intervention\Image\ImageManagerStatic as Image;
use \Intervention\Image\Exception\NotReadableException;

use Illuminate\Support\Facades\Storage;

class Resizer {

    private static $ignored_extensions = ['svg'];

    public static function __callstatic($name, $args) {
        $file = array_pop($args);
        $is_external = preg_match('/http(s?):\/\//m', $file) > 0 ? true : false;


        if ($file == '') {
            $file = 'http://placehold.it/1920x1080?text=Imagen';
            return $file;
        }

        $filename = basename($file);

        $cacheFolder = 'img_cache';
        $extension = pathinfo($file)['extension'];

        if (in_array(strtolower($extension), self::$ignored_extensions)) {
            return $file;
        }

        if ($is_external) {
            $filename = md5($file) . '.' . $extension;
        }

        $unique_name = implode('_', array_merge([$name], $args, [str_slug(str_replace('/', '_', $file)), '.' . $extension]));



        if (file_exists(public_path($cacheFolder . '/' . $unique_name))) {
            return url($cacheFolder . '/' . $unique_name);
        } else {

            if ($is_external) {
                $local_file = storage_path($cacheFolder . '/' . str_slug($file) . '.' . $extension);
                if (!file_exists($local_file)) {
                    $remote = file_get_contents($file);
                    file_put_contents($local_file, $remote);
                }

            } else {
                $local_file = str_replace('/storage/', storage_path('app/public/'), $file); // si está guardada en storage, buscar path absoluto fisico
            }




            try {
                $img = Image::make($local_file)->$name(...$args);
                $img->save(public_path($cacheFolder . '/' . $unique_name));
            } catch (NotReadableException $e) {
                return $file;
            }

            //return $file;


        }

        return url($cacheFolder . '/' . $unique_name);
    }
}
