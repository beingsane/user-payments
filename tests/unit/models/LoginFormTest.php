<?php

namespace tests\models;

use app\models\LoginForm;
use app\models\User;

class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginCorrect()
    {
        $username = uniqid();
        $model = new LoginForm(['username' => $username]);

        expect_that($model->login());
        expect_not(\Yii::$app->user->isGuest);

        $this->tester->seeRecord(User::className(), ['username' => $username]);
    }
}
