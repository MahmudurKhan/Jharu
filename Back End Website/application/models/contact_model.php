<?php

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact_model extends CI_Model
{
    function send_mail($too,$subject,$message)
    {
        $flag = false;

        $to = $too;
        $sub = $subject;
        $msg = $message;

        /*important lines for html mails*/
        $header = "MIME-Version:1.0"."\r\n";
        $header = $header."Content-type:text/html;charset=utf-8"."\r\n";
        /*important lines for html mails*/

        $header = $header."From:jharu <jharu.itechoid.com>"."\r\n";
        $header = $header.'Cc:  info@jharu.itechoid.com' . "\r\n";
        $header = $header.'Bcc:  info@jharu.itechoid.com' . "\r\n";

        if(mail($to,$sub,$msg,$header))
        {
            $flag = true;
        }

        return $flag;
    }
}

?>