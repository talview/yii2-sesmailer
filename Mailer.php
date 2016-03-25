<?php

namespace talview\sesmailer;

use Aws\Ses\Exception\SesException;
use \Aws\Ses\SesClient;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Console;
use yii\mail\BaseMailer;

/**
 * Mailer implementing email queueing and delivery functions
 * @author Mani Ka <mani@talview.com>
 */
class Mailer extends BaseMailer
{

    /**
     * @var SesClient|array
     */
    public $client;

    public $messageConfig = [] ;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->client === null) {
            throw new InvalidConfigException('The "client" property must be set.');
        }
        if (!$this->client instanceof SesClient) {
            $this->client = new SesClient($this->client);
        }

    }

    /**
     *
     * @param \talview\sesmailer\Message $message
     *
     * @return bool
     */
    protected function sendMessage($message)
    {
        try {
            return $this->client->sendRawEmail([
                'RawMessage' => [
                    'Data' => $message->getSwiftMessage()
                ]
            ]);
        } catch (SesException $e) {
            echo $e->getMessage();
            Yii::error($e->getMessage());
        }
        return false;
    }

    /**
     *
     * @param \talview\sesmailer\Message $message
     *
     * @return bool
     */
    protected function sendMessageAsync($message)
    {
        try {
            return $this->client->sendRawEmailAsync([
                'RawMessage' => [
                    'Data' => base64_encode($message->getSwiftMessage())
                ]
            ]);
        } catch (SesException $e) {
            Console::output($e->getMessage());
            Yii::error($e->getMessage());
        }
        return false;
    }

    /**
     * Sends the given email message.
     * This method will log a message about the email being sent.
     * If [[useFileTransport]] is true, it will save the email as a file under [[fileTransportPath]].
     * Otherwise, it will call [[sendMessage()]] to send the email to its recipient(s).
     * Child classes should implement [[sendMessage()]] with the actual email sending logic.
     * @param \talview\sesmailer\Message $message email message instance to be sent
     * @return \GuzzleHttp\Promise\Promise whether the message has been sent successfully
     */
    public function sendAsync($message)
    {
        if (!$this->beforeSend($message)) {
            return false;
        }

        $address = $message->getTo();
        if (is_array($address)) {
            $address = implode(', ', array_keys($address));
        }
        Yii::info('Sending email "' . $message->getSubject() . '" to "' . $address . '"', __METHOD__);

        $promise = $this->sendMessageAsync($message);
        $this->afterSend($message, true);// async promises

        return $promise;
    }

}
