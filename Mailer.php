<?php

namespace talview\sesmailer;

use Aws\Ses\Exception\SesException;
use \Aws\Ses\SesClient;
use Yii;
use yii\base\InvalidConfigException;
use yii\mail\BaseMailer;

/**
 * Mailer implementing email queing and delivery functions
 * @author Mani Ka <mani@talview.com>
 */
class Mailer extends BaseMailer
{

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
        if($this->client instanceof SesClient){
            try {
                return $this->client->sendEmail($message->getSESMessage());
            }catch(SesException $e) {
                echo $e->getMessage();
                Yii::error($e->getMessage());
            }
        }else{
            return false;
        }

    }

}
