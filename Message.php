<?php

namespace talview\sesmailer;

use yii\mail\BaseMessage;
use Yii;

/**
 * Message implements a message class based on SES.
 *
 * @method Mailer getMailer() returns mailer instance.
 *
 * @property $sesMessage SES message instance. This property is read-only.
 * @author Mani Ka <mani@talview.com>
 *
 */
class Message extends BaseMessage
{
    /**
     * @var
     */
    private $_sesMessage;

    /**
     * @var string
     */
    public $charset = "UTF-8";

    /**
     * @return array
     */
    public function getSESMessage()
    {
        if (!is_array($this->_sesMessage)) {
            $this->_sesMessage = $this->createSESMessage();
        }
        return $this->_sesMessage;
    }

    /**
     * @return array
     */
    public function createSESMessage()
    {
        return [
            'Source'=>$this->getFrom(),
            'Destination'=>['ToAddresses'=>[$this->getTo()]],
            'Message'=>[
                'Subject'=>['Data'=>$this->getSubject(),'Charset'=>$this->getCharset()],
                'Body'=>[
                    'Text'=>['Data'=>$this->getTextBody(),'Charset'=>$this->getCharset()],
                    'Html'=>['Data'=>$this->getHtmlBody(),'Charset'=>$this->getCharset()],
                    ]
                ],
            'ReplyToAddress'=>  $this->getReplyTo(),
            'replyPath'     =>  $this->getReplyTo(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    /**
     * @inheritdoc
     */
    public function setHtmlBody($value)
    {
        $this->htmlBody = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTextBody()
    {
        return $this->textBody;
    }

    /**
     * @inheritdoc
     */
    public function setTextBody($value)
    {
        $this->textBody = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @inheritdoc
     */
    public function setCc($value)
    {
        $this->cc = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @inheritdoc
     */
    public function setFrom($value)
    {
        $this->from = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @inheritdoc
     */
    public function setSubject($value)
    {
        $this->subject = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @inheritdoc
     */
    public function setBcc($value)
    {
        $this->bcc = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @inheritdoc
     */
    public function setCharset($value)
    {
        $this->charset = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @inheritdoc
     */
    public function setReplyTo($value)
    {
        $this->replyTo = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @inheritdoc
     */
    public function setTo($value)
    {
        $this->to = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attach($fileName, array $options = [])
    {

    }

    /**
     * @inheritdoc
     */
    public function attachContent($fileName, array $options = [])
    {

    }

    /**
     * @inheritdoc
     */
    public function embed($fileName, array $options = [])
    {

    }

    /**
     * @inheritdoc
     */
    public function embedContent($fileName, array $options = [])
    {

    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return $this->getTextBody();
    }
}
