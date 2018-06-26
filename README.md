# Elliot Global Project

<!-- BADGES/ -->

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

<!-- /BADGES -->

This is Yii2 application.

It was created and developing as a fast start for building an advanced sites based on Yii2. 

It covers typical use cases for a new project and will help you not to waste your time doing the same work in every project

## TABLE OF CONTENTS
- [Hosting](#server)
- [Features](#features)
- [Structure](#structure)
- [Installation](docs/installation.md)
    - [Manual installation](docs/installation.md#manual-installation)
    - [Localhost installation](docs/installation.md#local-installation)
- [Application components](#application-components)


## Server
Server is hosted by [Digital Ocean](https://m.do.co/c/d7f000191ea8)

on Live [url](https://elliot.global)


## FEATURES
Coming Soon!

## STRUCTURE

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
storage/                 contains uploaded contents
```


# Application Components

### I18N
If you want to store application messages in DB and to have ability to edit them from backend, run:
```
php console/yii message/migrate @common/config/messages/php.php @common/config/messages/db.php
```
it will copy all existing messages to database

Then uncomment config for `DbMessageSource` in
```php
common/config/base.php
```

### KeyStorage
Key storage is a key-value storage to store different information. Application settings for example.
Values can be stored both via api or by backend CRUD component.
```
Yii::$app->keyStorage->set('articles-per-page', 20);
Yii::$app->keyStorage->get('articles-per-page'); // 20
```

### Maintenance mode
Elliot Global Project has built-in component to provide a maintenance functionality. All you have to do is to configure ``maintenance``
component in your config
```php
'bootstrap' => ['maintenance'],
...
'components' => [
    ...
    'maintenance' => [
        'class' => 'common\components\maintenance\Maintenance',
        'enabled' => Astronomy::isAFullMoonToday()
    ]
    ...
]
```
This component will catch all incoming requests, set proper response HTTP headers (503, "Retry After") and show a maintenance message.
Additional configuration options can be found in a corresponding class.

Elliot Global Project configured to turn on maintenance mode if ``frontend.maintenance`` key in KeyStorage is set to ``true``

### Command Bus
- [What is command bus?](http://shawnmc.cool/command-bus)

In Elliot Global Project Command Bus pattern is implemented with [tactician](https://github.com/thephpleague/tactician) package and 
it's yii2 connector - [yii2-tactician](https://github.com/trntv/yii2-tactician)

Command are stored in ``common/commands/command`` directory, handlers in ``common/commands/handler``

To execute command run
```php
$sendEmailCommand = new SendEmailCommand(['to' => 'user@example.org', 'body' => 'Hello User!']);
Yii::$app->commandBus->handle($sendEmailCommand);
```

### Timeline (Activity)
```php
$addToTimelineCommand = new AddToTimelineCommand([
    'category' => 'user', 
    'event' => 'signup', 
    'data' => ['foo' => 'bar']
]);
Yii::$app->commandBus->handle($addToTimelineCommand);
```

### Behaviors
#### CacheInvalidateBehavior
```php
 public function behaviors()
 {
     return [
         [
             'class' => `common\behaviors\CacheInvalidateBehavior`,
             'tags' => [
                  'awesomeTag',
                   function($model){
                       return "tag-{$model->id}"
                  }
              ],
             'keys' => [
                  'awesomeKey',
                  function($model){
                      return "key-{$model->id}"
                  }
              ]
         ],
     ];
 }
```
#### GlobalAccessBehavior
Add in your application config:
```php
'as globalAccess'=>[
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions'=>['error']
            ],
            [
				'allow' => true,
				'roles' => ['@']
			]
        ]
    ]
```
It will allow access to you application only for authentificated users. 

### Command Bus
Read more about command bus on in [official repository](https://github.com/trntv/yii2-command-bus#yii2-command-bus)

### Widgets configurable from backend
#### Carousel
1. Create carousel in backend
2. Use it:
```php
<?php echo DbCarousel::widget(['key' => 'key-from-backend']) ?>
```

#### DbText
1. Create text block in backend
2. Use it:
```php
<?php echo DbText::widget(['key' => 'key-from-backend']) ?>
```

#### DbMenu
1. Create text block in backend
2. Use it:
```php
<?php echo DbMenu::widget(['key' => 'key-from-backend']) ?>
```


### Grid
#### EnumColumn
```php
 [
      'class' => '\common\grid\EnumColumn',
      'attribute' => 'status',
      'enum' => User::getStatuses() // [0=>'Deleted', 1=>'Active']
 ]
```
### API
Elliot Global has fully configured and ready-to-go REST API module. You can access it on http://elliot.global/api/v1
For some endpoints you should authenticate your requests with one of available methods - https://github.com/yiisoft/yii2/blob/master/docs/guide/rest-authentication.md#authentication

### MultiModel
``common\base\MultiModel`` - class for handling multiple models in one
In controller:
```php
$model = new MultiModel([
    'models' => [
        'user' => $userModel,
        'profile' => $userProfileModel
    ]
]);

if ($model->load(Yii::$app->request->post()) && $model->save()) {
    ...
}
```
In view:
```php
<?php echo $form->field($model->getModel('account'), 'username') ?>

<?php echo $form->field($model->getModel('profile'), 'middlename')->textInput(['maxlength' => 255]) ?>    
```
### Other
- ``common\behaviors\GlobalAccessBehavior`` - allows to set access rules for your application in application config

- ``common\behaviors\LocaleBehavior`` - discover user locale from browser or account settings and set it

- ``common\behaviors\LoginTimestampBehavior`` - logs user login time

- ``common\validators\JsonValidator`` - validates a value to be a valid json

- ``common\rbac\rule\OwnModelRule`` - simple rule for RBAC to check if the current user is model owner
```php
Yii::$app->user->can('editOwnModel', ['model' => $model]);
```

- ``common\filters\OwnModelAccessFilter`` - action filter to check if user is allowed to manage this model
```php
public function behaviors()
    {
        return [
            'modelAccess' => [
                'class' => OwnModelAccessFilter::className(),
                'only' => ['view', 'update', 'delete'],
                'modelCreatedByAttribute' => 'created_by',
                'modelClass' => Article::className()
            ],
        ];
    }
```

## READ MORE
https://github.com/yiisoft/yii2/blob/master/apps/advanced/README.md
https://github.com/yiisoft/yii2/tree/master/docs

