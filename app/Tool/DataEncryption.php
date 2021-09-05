<?php 

namespace App\Tool;

class DataEncryption
{

    public static function Encrypt($str = "")
    {
        $data = openssl_encrypt($str, 'AES-256-CBC', env('AES_KEY'), OPENSSL_RAW_DATA,env('AES_IV'));
        return base64_encode($data);      
    } 

    public static function Decrypt($str = "")
    { 
        return openssl_decrypt(base64_decode($str), 'AES-256-CBC', env('AES_KEY'), OPENSSL_RAW_DATA, env('AES_IV'));
    }
}