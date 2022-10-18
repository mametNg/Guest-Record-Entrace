<?php

namespace Controller;

class Controller {

  public $ua = false;
  public $ip = false;
  public $allowFile = true;

  public function view($view, $data = [])
  {
    $open = 'app/views/'.$view.'.php';
    if (!file_exists($open)) $open = 'app/views/error/404.php';
    include $open;
  }

  public function model($model)
  {
    include 'app/models/'.$model.'.php';
    return new $model;
  }

  public function helper($helper)
  {
    include 'app/helpers/'.$helper.'.php';
    return new $helper;
  }

  public function authApi($authApi)
  {
    include 'app/api/'.$authApi.'.php';
    return new $authApi;
  }

  public function base_url($path='')
  {
    return $this->e(BASE_URL.$path);
  }

  public function base_host()
  {
    return BASE_HOST;
  }

  public function config()
  {
    $this->ua = (!isset($_SERVER['HTTP_USER_AGENT']) ? $this->ua : $this->e($_SERVER['HTTP_USER_AGENT']));
    $this->ip = (!isset($_SERVER['REMOTE_ADDR']) ? $this->ip : $this->e($_SERVER['REMOTE_ADDR']));
    return $this;
  }

  public function e($string="", $replace=false)
  {
    return htmlspecialchars(addslashes(trim($string, $replace)));
  }

  public function printJson($arr=array())
  {
    header('Content-Type: application/json');
    print json_encode($arr, JSON_PRETTY_PRINT);
    exit();
  }

  public function invalid($status=false, $code=403, $msg="Access Denied", $params=[])
  {
    $result = [
      "status"  => $status,
      "code"  => $code,
      "msg"  => $msg,
      "result"  => $params,
    ];

    return $result;
  }

  public function clean($string) {
    $string = str_replace(' ', '-', $string);

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
  }

  public function getTimeInterval($date)
  {
    $datime = time();

    $interval = $datime - $date;

    $return = '';

    switch ( $interval )
    {
        case ($interval <= 60) :
            $return = 'a few secs ago';
            break;

        case ($interval > 60 && $interval < 3600) :
            $return = (int)date('i', $interval) . ' mins ago';
            break;

        case ($interval >= 3600 && $interval < 86400) :
            $return = ( abs((date('G', $datime) - date('G', $date))) < 2)
                ? abs((date('G', $datime) - date('G', $date))) . ' hour ago'
                : abs((date('G', $datime) - date('G', $date))) . ' hours ago';
            break;

        case ($interval >= 86400 && $interval < 606060604800) :
            $return = ( (int)date('j', $interval) === 1)
                ? (int)date('j', $interval) . ' day ago'
                : (int)date('j', $interval) . ' days ago';
            break;

        case ($interval > 604800 && $interval <= 2592000) :
            $return = 'A few weeks ago';
            break;
        case ($interval > 2592000) :
            $return = date('n', $interval) . ' months ago';
            break;
        case ($interval > 31536000) :
            $return = 'Over a year ago';
            break;

    }
    return $return;
  }

  public function array_group($array, $key) {
    $return = array();
    foreach($array as $val) {
      $return[$val[$key]][] = $val;

    }
    return $return;
  }

  public function printImg($path=false)
  {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    header('Content-Type: image/'.$type);
    print $data;
    // print $this->imgToBase64($path);
  }

  public function imgToBase64($path=false)
  {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $img = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $img;
  }

  public function filterString($value='') {
    $result = false;
    for ($i=0; $i < strlen($value); $i++) { 
      if (substr($value, $i,1) == " " || substr($value, $i,1) >= "a" && substr($value, $i,1) <= "z" || substr($value, $i,1) >= "A" && substr($value, $i,1) <= "Z") {
        $result = true;
      } else {
        $result = false;
        break;
      }
    }

    return $result;
  }

  public function filterNumb($value='') {
    $result = false;
    for ($i=0; $i < strlen($value); $i++) { 
      if (substr($value, $i,1) >= "0" && substr($value, $i,1) <= "9") {
        $result = true;
      } else {
        $result = false;
        break;
      }
    }

    return $result;
  }
  
  public function filterMail($email=false)
  {
    return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false ;
  }

  public function randNumb($length)
  {
    $txt = "1234567890";
    $string = "";
    for ($i=0; $i < $length; $i++) { 
      $acak = rand(0, strlen($txt)-1);
      $string .= $txt[$acak];
    }
    return $string;
  }

  public function randString($length)
  {
    $chars = "abcdefghijklmnopqrstuvwxyz";
    $txt = "1234567890".strtolower($chars).strtoupper($chars);
    $string = "";
    for ($i=0; $i < $length; $i++) { 
      $acak = rand(0, strlen($txt)-1);
      $string .= $txt[$acak];
    }
    return $string;
  }

  public function filterImg($myFile=[])
  {
    $img = [
      'name'            => trim($myFile['name']),
      'size'            => trim($myFile['size']),
      'type'            => trim($myFile['type']),
      'tmp'             => trim($myFile['tmp_name']),
      'pixel'           => @getimagesize($myFile['tmp_name']),
      'error'           => trim($myFile['error']),
      'extension'       => explode(".", trim($myFile['name'])),
      'allowExtension'  => ['png', 'jpg', 'jpeg', 'svg'],
    ];

    if (!in_array(end($img['extension']), $img['allowExtension'])) {
      return [
        'status'  => false,
        'msg'     => "The file must be an image!",
      ];
    }

    if ($img['type'] !== "image/jpeg" && $img['type'] !== "image/png" && $img['type'] !== "image/svg+xml") {
      return [
        'status'  => false,
        'msg'     => "The file must be an image!",
      ];
    }

    if ($img['pixel'] == false && end($img['extension']) !== 'svg') {
      return [
        'status'  => false,
        'msg'     => "Malicious files detected!",
      ];
    }

    if (!in_array(end($img['extension']), $img['allowExtension'])) {
      return [
        'status'  => false,
        'msg'     => "The file must be an image!",
      ];
    }

    return [
      'status'  => true,
      'msg'     => "",
    ];
  }

  public function balitbangEncode($str='',$code=82)
  {
    $t='';
    if(($code>=0)and($code<100)) {
      $t .=dechex(strlen($str)+$code)."g";
      $str=strrev($str);
      for($i=0;$i<=strlen($str)-1;$i++) {
        $t .=dechex(ord(substr($str,$i,1))+$code);
      }
    }
    return $t;
  }

  public function balitbangDecode($str='',$code=82)
  {
    $all = explode("g",$str);
    $dec = $str;
    if (isset($all[1])) {
      $head = hexdec($all[0])-$code;
      $content = $all[1];
      $dec = '';
      if($head==(strlen($content)/2)) {
        for($i = 0; $i <= $head-1; $i++) {
          $dec .= chr(hexdec(substr($content,$i*2,2))-$code);
        }
        $dec = strrev($dec);
      }
    }
    return $dec;
  }

  public function RSAPublicKey()
  {
    $public = '-----BEGIN PUBLIC KEY----- MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAu5D5uwkMWLxRmwoOdepJYZiGVVi82NRqxZFClYx8EtCPBReu48TlMJcluWrNQHhczT8kVEObilXq6ujwKMppMHXyGtFJKlZGnlIo0EPY8O+NIT9g0HjWiMy51FHY3SsIz0MCs6qrFXlPkJYiSKp34NpIVp75QXqBoHil5b3E8XxMd7oICLXI52t0qpQYuTAgkK1FVhsfqd86IrdSj4AMo/t8n0Owk30/L/GBQqpN1OWOrbCYyftFccdR0wugHmt47Q99Y5zDJ46VKoAYCU/KGXWvJ236Y3eDzRKPg7g90WRhzXZycgGina6q69MSbTrIEXpU7gIcEMpdOXi/FYOtt0Nn6Uj84i4MOX3CA0FgVuLex78pldVmgh9mEqNK0g3o65L/IvohM2UMD/vgvLLFBL1JYu6qtTvzzF9Pntu5JluBXtTJnx1vVRzAZVD2nL0j1Cw5dj7OKR3AS5RbVc64jL3iqnYhuMrhp6+JWps6yQuzhaOB1E1zRtOygm3dUuGIx0G9SS0xLPnowXNTbA3qZFHtFUOyMW6LkQSCtVyV5SWmXhr1ZXAZR1uTWlQ6YnuotSUbr4S4wPV19QCSCsA65H9WzLEsvDXjiyrL4iSYX35v6GMZZ3xlen+V3Zt5yiC87pwx09SPZu9pRxCwX1wU5OqMhuGHy2NtIKXaqOlgkaMCAwEAAQ== -----END PUBLIC KEY-----';
    return $public; 
  }

  public function RSAPrivateKey()
  {
    $private = "-----BEGIN RSA PRIVATE KEY-----\n";
    $private .= "MIIJKAIBAAKCAgEAu5D5uwkMWLxRmwoOdepJYZiGVVi82NRqxZFClYx8EtCPBReu\n";
    $private .= "48TlMJcluWrNQHhczT8kVEObilXq6ujwKMppMHXyGtFJKlZGnlIo0EPY8O+NIT9g\n";
    $private .= "0HjWiMy51FHY3SsIz0MCs6qrFXlPkJYiSKp34NpIVp75QXqBoHil5b3E8XxMd7oI\n";
    $private .= "CLXI52t0qpQYuTAgkK1FVhsfqd86IrdSj4AMo/t8n0Owk30/L/GBQqpN1OWOrbCY\n";
    $private .= "yftFccdR0wugHmt47Q99Y5zDJ46VKoAYCU/KGXWvJ236Y3eDzRKPg7g90WRhzXZy\n";
    $private .= "cgGina6q69MSbTrIEXpU7gIcEMpdOXi/FYOtt0Nn6Uj84i4MOX3CA0FgVuLex78p\n";
    $private .= "ldVmgh9mEqNK0g3o65L/IvohM2UMD/vgvLLFBL1JYu6qtTvzzF9Pntu5JluBXtTJ\n";
    $private .= "nx1vVRzAZVD2nL0j1Cw5dj7OKR3AS5RbVc64jL3iqnYhuMrhp6+JWps6yQuzhaOB\n";
    $private .= "1E1zRtOygm3dUuGIx0G9SS0xLPnowXNTbA3qZFHtFUOyMW6LkQSCtVyV5SWmXhr1\n";
    $private .= "ZXAZR1uTWlQ6YnuotSUbr4S4wPV19QCSCsA65H9WzLEsvDXjiyrL4iSYX35v6GMZ\n";
    $private .= "Z3xlen+V3Zt5yiC87pwx09SPZu9pRxCwX1wU5OqMhuGHy2NtIKXaqOlgkaMCAwEA\n";
    $private .= "AQKCAgB/IevzN1XUC4jwomdcyzmD2kMrNCOEgK4CTcwo23j5s71NAVl8bue+AKUE\n";
    $private .= "QXzvtuWIBMVWDCEwKb46DTtDGrcjrr40KSkDdkkVZLDfQS2ZWXV6VKAFjfIz9Tf7\n";
    $private .= "zqJEfrfQ7CW3q/Wcb4ZbhTels03f7XRcqhJerG+SWlRwHSmRWOPnvwNVDAopua7x\n";
    $private .= "M8JyO0nHZnp5u5bBqFmaUFG4jF2FBJ/av6G+xoT+tR4dFpv8sr/7wJg/R34xeZ1f\n";
    $private .= "hCC6nbPwUrB1xTqN5Fn83aftH9TnXtoiyquNoeOHK451BHt6IyUbg65c0fjsEgku\n";
    $private .= "IPn7aX1UQ2uvi2SEiPWZT9uM9JzYUthHE+ROOumdffpljp1HvZb6ISw39sL1LRXH\n";
    $private .= "V+3EasK+luQTBn+K8UIBPpADx4L6P1OOzKdUHMelq9kj5LX6/vYRh9lftq7YcADE\n";
    $private .= "ERckXZI7rBgyFFqA1dL1f7JorO37k3sW6xiMVg9nAI5e3bT0AXTvkGXSseRIX4aH\n";
    $private .= "2MSiLHMI/Ae51HD9kspGVUV0k9fuY+8WQqN9eroAj7wTdvkHWFVKbPeKGsmZDw+s\n";
    $private .= "zGk2mRjQ6po6dVV77Y8RaPgGBrv9cthPXMfTfYD3OrlJ7fH0cQJgMCiPLzxVMRSG\n";
    $private .= "sQRpgMG8h/7njnwvaxla8Fq5eqJe7FvavtsNEXBjDi2Oak7ryQKCAQEA3ZcAdkHX\n";
    $private .= "MUzBh+o4SqvITMrv6qk2ahJ0AFm2JcZdUvYk4O3D2UtljrINizDOsu8bYwmr4tLy\n";
    $private .= "nk3jka/637Qd+ut0Pr/5Y8/U4YeS0rjf+6u8JaBk9z8xTngkAyKR1eo67sdWwgSK\n";
    $private .= "Z+4tgr9axEa9ONHCbTkZubWw1Zgmtdd6DsmlJ6h3sWbcW9YUtqtqh7EUFuyP1PiJ\n";
    $private .= "KVtNZgeliTzIUFxTsWS9aAzu4hC5wZdhgx5IKWyfE+U/JmN7I/EGH3bC05kcedgO\n";
    $private .= "OJtZ8/qp/F8ndFMkYDcWRYoBNSt5RzpsBYj026hO2fRLee03SFEC7Kmilq+y8FOj\n";
    $private .= "wneADOxiHcETbwKCAQEA2LFqNsZZa8eQNqqPuDY6pffEZXCdpJWn/Qp0/xZSgZxl\n";
    $private .= "zzgg5sN1L4SFRPqVBsmHNMpNy223QxJfeoh97pS65L/A0OheSri+CPkMTBiC35hH\n";
    $private .= "bj84f+Z9fjhZtqW/iz8rIuc9AfVcox5Ha4viBXBkJU+cmoBKLSoS2B0SDc8GBDoU\n";
    $private .= "U+03KmlUIOCmnoRMjTYl7L4y9BbT47Q1ECoeZ+HAoktPV7SidmOcReRqUaz5Su65\n";
    $private .= "wAwM7v2yX68k+lFSLsAEAmshsJtrXeKdS8TI44Xh5M8rxBXt1m1Z5aORfyWh9Bxn\n";
    $private .= "MZsDSn6getKPFBJs6ltlX8sbH4iy9AOH2/IVHmg7DQKCAQEAqBR0/j6c60FMfzrz\n";
    $private .= "bfh1W4KHj1jA9J6ArQ9fcbHQcjBQ8uiHKRjetOlsCouADgv+mxXn8oqOC/QKzSRO\n";
    $private .= "SEdIgl788ugNVF9+G4AJp5siErVGZsgOLdkaHmpU7qfXNQqRnzNHJK3rCkCI9ucN\n";
    $private .= "A1qhBytcrhqk38/ojWv22PHUHMlpY/aOq9rZBTQSzCikCr8P/P99bk8DQ4KE6AKe\n";
    $private .= "1sVrMEGIHkPKw9UjkgibzjN0fM+Ibxt8Ysv+JbFJ445cVZtw1q4KAoYW62szRTR6\n";
    $private .= "ofrPY5X5Pp4qX575oYoTWSsAawZirQcyoHKEmbyMtWb1r+xQbrphIZhf3A9m6uaW\n";
    $private .= "2fjtMwKCAQBshSVROzKLNI03o2GIergSaCwWNTjttPlFU1hWa6J0QJQIG+72QorM\n";
    $private .= "ekyXx/qcRI8O1AXzzAWMdIYWgoa21gtnBdUVilm2iCC7s6YB8gCQ491aDBVKkG7m\n";
    $private .= "qGfdfdKYdNEwkKfP9EYpdr+Dz7Eo0imFOgKOqZL8XWbEjoJ9IeG8ei21/kWzWr6E\n";
    $private .= "HJ21I0KHMcf6cSJpdYk2LwioCL/jfH6RiK+6l78JFUetBQBt2PecHEQwNpi/k5Qi\n";
    $private .= "MT+OkO1cdlNLtsVPgfZaNWRbDrkgoOsJQOuFLwpGacssoyb5iyo5a4QOprgWNaY+\n";
    $private .= "/HYlMjkTgSQavkfeGgKtC5udffYvnTl9AoIBAHRCwOVwnjJGcLl9YfITFyo8tGHL\n";
    $private .= "lMjrvhn9BPc40ZC3P/iFrHUhQ3iirqNoBWKvALrARK+n5PmS9T899lWNw29AaETO\n";
    $private .= "cEcGf2vQjOgL3teVTJxFiC+B+aGNVC8MVD4+iuWeAFS7tADAsRyo+Ak8b7sOsHyw\n";
    $private .= "1mwZltTsE8iO2FVi8i5Ubr9TGP+XGFsXn20kpijA3qghkKzTOFlVz8qXCvNNFJFO\n";
    $private .= "tFyL6xgPDLVzn81ZjefBYXJnNxF/MBTuzD0S4nfKIk5OBFwPpYrD0FyrMwyk9CGe\n";
    $private .= "298dz1gCLagExy7MegjHUtSHh/IJURdMy0HT0a3M7gwT5nDYTnJq/b3up6w=\n";
    $private .= "-----END RSA PRIVATE KEY-----";

    return $private;
  }

  public function RSAdecrypt($field){

    if (!$privateKey = openssl_pkey_get_private($this->RSAPrivateKey()))
      return false;

    $decrypted_text = "";
    if (!openssl_private_decrypt(base64_decode($field), $decrypted_text, $privateKey))
      return false;

    $strTime = (int)substr($decrypted_text, strripos($decrypted_text, "+")+1);
    $decrypted_text = substr($decrypted_text, 0, strripos($decrypted_text, "+"));

    $time = time();

    openssl_free_key($privateKey);

    if(($time - $strTime) < 30){
      return $decrypted_text;
    } else {
      return false;
    }

  }

  public function mailler()
  {

    $mail['Host']       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail['SMTPAuth']   = true;                                   //Enable SMTP authentication
    $mail['Username']   = 'example@gmail.com';                     //SMTP username
    $mail['Password']   = 'password';                               //SMTP password
    $mail['Port']       = 465; 

    return json_decode(json_encode($mail));
  }

  public function get_url()
  { 
    $url[] = "";
    if (isset($_GET['url'])) {
      $url = htmlspecialchars(addslashes(trim(trim($_GET['url'], "/"))));
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode("/", $url);
    } 
    return $url;
  }
}
