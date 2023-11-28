<?php

namespace App\Helper;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Psr7\Request;
use PhpParser\Node\Stmt\Catch_;

class JWTToken{

                //createToken
    public static function CreateToken($userEmail):string{
        $key= env(key:'JWT_KEY');
        $payload=[
            'iss'=>'Laravel-JWT',
            'iat'=>time(),
            'exp'=>time()+60*60,
            'userEmail'=>$userEmail
        ];
        return JWT::encode($payload,$key, 'HS256');
    }

            //CreateTOkenForSetPassword
    public static function CreateTokenForSetPaassword($userEmail):string{
        $key= env(key:'JWT_KEY');
        $payload=[
            'iss'=>'Laravel-JWT',
            'iat'=>time(),
            'exp'=>time()+60*5,
            'userEmail'=>$userEmail
        ];
        return JWT::encode($payload,$key, 'HS256');
    }



                //VerifyORDecode token
    public static function VerifyToken($token){
        try{
            $key= env(key:'JWT_KEY');
            $decoded= JWT::decode($token, new key($key, 'HS256'));
            return $decoded->userEmail;
        }
        catch(Exception $e){
            return 'unauthorized';
        }
    }
}
