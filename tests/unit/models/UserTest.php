<?php
namespace tests\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testEnsureUserExists()
    {
        $username = uniqid();

        $this->tester->dontSeeRecord(User::className(), ['username' => $username]);
        $model = User::ensureUserExists($username);
        expect($model)->notNull();
        $this->tester->seeRecord(User::className(), ['username' => $username]);
    }
}
