<?php

namespace talview\sesmailer;

use \Aws\Ses\SesClient;
use Yii;
use yii\mail\BaseMailer;

/**
 * Mailer implementing email queing and delivery functions
 */
class Mailer extends BaseMailer
{
    /**
     * @var
     */
    private $_sesClient;

    private $_factory = [];
     
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
        $result = $this->getSesClient()->sendEmail($message->getSESMessage());
        return true;
    }

    public function getSesClient(){
        if (!is_object($this->_sesClient)) {
            $this->_sesClient = $this->createSesClient();
        }
        return $this->_sesClient;
    }

    /**
     * @return mixed
     */
    public function createSesClient()
    {
        return SesClient::factory($this->getFactory());
    }

    /**
     * @return array
     */
    public function getFactory()
    {
        return $this->_factory;
    }

    /**
     * 
     * @return self
     */
    public function setFactory($factory)
    {
        $this->_factory = $factory;
        return $this;
    }
}
