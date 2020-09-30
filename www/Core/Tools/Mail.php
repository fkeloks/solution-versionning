<?php

namespace ESGI\Core\Tools;

use ESGI\Core\Configuration\Config;
use Exception;
use PHPMailer\PHPMailer;

class Mail
{
    /** @var PHPMailer */
    private $mail;

    /**
     * Instantiate a new mail object
     *
     * @param string $subject
     * @param string $body
     *
     * @return static
     *
     * @throws Exception
     */
    public static function create(string $subject, string $body): self
    {
        $instance = new self;

        // Configuration of mailer
        $instance->mail = new PHPMailer(true);
        $instance->mail->isSMTP();
        $instance->mail->Host = Config::get('MAILER_HOST');
        $instance->mail->Port = Config::get('MAILER_PORT');
        $instance->mail->setFrom(Config::get('MAILER_FROM'), Config::get('site.name'));
        $instance->mail->IsHTML(true);
        $instance->mail->CharSet = 'UTF-8';
        $instance->mail->Subject = $subject;
        $instance->mail->Body = $body;

        if (!App::isInDevelopmentMode()) {
            $instance->mail->SMTPAuth = true;
            $instance->mail->Username = Config::get('MAILER_USERNAME');
            $instance->mail->Password = Config::get('MAILER_PASSWORD');
            $instance->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }

        return $instance;
    }

    /**
     * Send current mail
     *
     * @param string|string[] $email
     *
     * @return bool
     */
    public function send($email): bool
    {
        try {
            if (is_array($email)) {
                foreach ($email as $e) {
                    $this->mail->addAddress($e);
                }
            } else {
                $this->mail->addAddress($email);
            }

            $this->mail->send();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
