<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
return [
	'class' => 'yii\web\Response',
	'on beforeSend' => function($event) {
		$controller = Yii::$app->controller;
		$developmentStages = ['dev', 'testing'];
		if (isset($controller->isAPIMode) && $controller->isAPIMode) {
			$options = [
				'isDebug' => defined('YII_DEBUG') && YII_DEBUG,
				'isDevelopement' => defined('YII_ENV') && in_array(YII_ENV, $developmentStages),
			];
			$apiResponse = new app\components\response\ApiResponse($event->sender, $options);
			$response= $apiResponse->run();
		}
	},
];
