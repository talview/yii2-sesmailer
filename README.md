SESMailer Extension for Yii 2
===============================

This extension provides a [SES](hhttps://aws.amazon.com/ses/) mail solution for [Yii framework 2.0](http://www.yiiframework.com).

For license information check the [LICENSE](LICENSE.md)-file.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
```

or add

```json
    "talview/sesmailer": "~1.0"
```

to composer.json.

Usage
-----

To use this extension,  simply add the following code in your application configuration:

```php
return [
    //....
    'components' => [
        'mailer' => [
            'class' => 'talview\sesmailer\Mailer',
        ],
    ],
];
```

You can then send an email as follows:

```php
Yii::$app->mailer->compose('contact/html')
     ->setFrom('from@domain.com')
     ->setTo($form->email)
     ->setSubject($form->subject)
     ->send();
```