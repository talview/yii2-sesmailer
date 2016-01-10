<?php

namespace talview\sesmailer;

use \Aws\Ses\SesClient;
use Yii;
use yii\mail\BaseMailer;

/**
 * Mailer implementing email queing and delivery functions
 * @author Mani Ka <mani@talview.com>
 */
class Mailer extends BaseMailer
{
    /**
     * @var
     */
    private $client;
     
    public $messageConfig ;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }    
    
    /**
     * @inheritdoc
     */
    protected function sendMessage($message)
    {
        if($this->client instanceof  SesClient){
            $result = $this->client->sendEmail($message->getSESMessage());    
            return true;
        }else{
            throw new \yii\base\InvalidConfigException('Invalid client config');
        }

    }

}
