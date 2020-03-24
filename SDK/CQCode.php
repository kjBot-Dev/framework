<?php
namespace kjBot\SDK;

class CQCode{

    public static function CQ($type, $argArray = NULL){
        $code='[CQ:'.$type;
        if(NULL !== $argArray) foreach($argArray as $key => $value){
            if($value === NULL) continue;
            $code.= (','.$key.'='.self::EncodeCQCode($value));
        }
        $code.=']';
        return $code;
    }

    public static function At($qq){
        return self::CQ('at', ['qq' => $qq]);
    }

    public static function Face($id){
        return self::CQ('face', ['id' => $id]);
    }

    public static function BFace($id){
        return self::CQ('bface', ['id' => $id]);
    }

    public static function SFace($id){
        return self::CQ('sface', ['id' => $id]);
    }

    public static function Emoji($id){
        return self::CQ('emoji', ['id' => $id]);
    }

    public static function Image($file){
        return self::CQ('image', ['file' => $file]);
    }

    public static function Record($file, $magic = NULL){
        return self::CQ('record', [
            'file' => $file,
            'magic' => $magic,
        ]);
    }

    public static function Rps($type = NULL){
        return self::CQ('rps', ['type' => $type]);
    }

    public static function Dice($type = NULL){
        return self::CQ('dice', ['type' => $type]);
    }
    
    public static function Shake(){
        return self::CQ('shake');
    }

    public static function Anonymous($ignore = NULL){
        return self::CQ('anonymous', ['ignore' => $ignore]);
    }

    public static function Location($lat, $lon, $title, $content){
        return self::CQ('location', [
            'lat' => $lat,
            'lon' => $lon,
            'title' => $title,
            'content' => $content,
        ]);
    }

    public static function Music($type, $id, $style = NULL){
        return self::CQ('music', [
            'type' => $type,
            'id' => $id,
            'style' => $style,
        ]);
    }

    public static function CustomMusic($url, $audio, $title, $content = NULL, $image = NULL){
        return self::CQ('music', [
            'type' => 'custom',
            'url' => $url,
            'audio' => $audio,
            'title' => $title,
            'content' => $content,
            'image' => $image,
        ]);
    }

    public static function Share($url, $title, $content = NULL, $image = NULL){
        return self::CQ('share', [
            'url' => $url,
            'title' => $title,
            'content' => $content,
            'image' => $image,
        ]);
    }

    public static function EncodeCQCode($str){
        if($str === true) return 'true';
        if($str === false) return 'false';
        //if($str === NULL) return ?; //这种情况的处理待定
        return str_replace([
            '&',
            '[',
            ']',
            ',',
        ], [
            '&amp;',
            '&#91;',
            '&#93;',
            '&#44;',
        ], $str);
    }

    public static function DecodeCQCode($str){
        return str_replace([
            '&amp;',
            '&#91;',
            '&#93;',
            '&#44;',
        ],[
            '&',
            '[',
            ']',
            ',',
        ], $str);
    }

}

?>
