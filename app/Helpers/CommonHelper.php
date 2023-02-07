<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CommonHelper {

    public static function composeEmail( $email, $fileUrl, $subject = 'Order Confirmation', $body = '' ) {

        $mail = new PHPMailer( true );     // Passing `true` enables exceptions

        try {

            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host       = env( 'MAIL_HOST' );
            $mail->SMTPAuth   = true;
            $mail->Username   = env( 'MAIL_USERNAME' );
            $mail->Password   = env( 'MAIL_PASSWORD' );
            $mail->SMTPSecure = env( 'MAIL_ENCRYPTION' );
            $mail->Port       = env( 'MAIL_PORT' );

            $mail->setFrom( env( 'MAIL_FROM_ADDRESS' ), env( 'MAIL_FROM_NAME' ) );
            $mail->addAddress( $email );

            $mail->addReplyTo( env( 'MAIL_FROM_ADDRESS' ), env( 'MAIL_FROM_NAME' ) );
            if ( $fileUrl != null ) {
                $mail->addAttachment( $fileUrl );
            }

            $mail->isHTML( true );

            $mail->Subject = 'Order Confirmation';
            $mail->Body    = $body;
            if ( ! $mail->send() ) {
                return "Email not sent.";
            } else {
                return null;
            }
        } catch ( Exception $e ) {
            return 'Message could not be sent.';
        }
    }

}
