<?php
namespace tests\models;

use Yii;
use app\models\Transfer;
use app\models\TransferState;
use app\models\TransferType;
use app\models\Payment;
use app\models\PaymentType;
use app\models\User;
use Codeception\Util\Stub;

class TransferTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testState()
    {
        $model = new Transfer();

        $model->state_id = TransferState::AWAITING;
        expect($model->isAwaiting())->true();

        $model->state_id = TransferState::ACCEPTED;
        expect($model->isAwaiting())->false();
    }

    public function testType()
    {
        $model = new Transfer();

        $model->type_id = TransferType::SEND;
        expect($model->isSendType())->true();
        expect($model->isReceiveType())->false();

        $model->type_id = TransferType::RECEIVE;
        expect($model->isReceiveType())->true();
        expect($model->isSendType())->false();
    }

    public function testControlAllowed()
    {
        $user1 = new User(['id' => 1]);
        $user2 = new User(['id' => 2]);

        $model = Stub::make(Transfer::className(), [
            'isAwaiting' => true,
            'isSendType' => true,
            'isReceiveType' => false,
            'from_user_id' => $user1->id,
            'to_user_id' => $user2->id,
        ]);
        expect($model->isControlAllowed($user1->id))->true();
        expect($model->isControlAllowed($user2->id))->false();

        $model = Stub::make(Transfer::className(), [
            'isAwaiting' => true,
            'isSendType' => false,
            'isReceiveType' => true,
            'from_user_id' => $user2->id,
            'to_user_id' => $user1->id,
        ]);
        expect($model->isControlAllowed($user1->id))->true();
        expect($model->isControlAllowed($user2->id))->false();

        $model = Stub::make(Transfer::className(), [
            'isAwaiting' => false,
            'from_user_id' => $user1->id,
            'to_user_id' => $user2->id,
        ]);
        expect($model->isControlAllowed($user1->id))->false();
        expect($model->isControlAllowed($user2->id))->false();
    }

    public function testAccept()
    {
        $model = Transfer::findOne(1);
        expect_that($model->state_id == TransferState::AWAITING);

        $appUser = Yii::$app->user->identity;
        Yii::$app->user->identity = $model->fromUser;

        $amountFrom = $model->fromUser->account->amount;
        $amountTo = $model->toUser->account->amount;
        $amount = $model->amount;
        $model->accept();

        $this->tester->seeRecord(Payment::className(), [
            'account_id' => $model->fromUser->account->id,
            'type_id' => PaymentType::CREDIT,
            'amount' => $amount,
        ]);
        $this->tester->seeRecord(Payment::className(), [
            'account_id' => $model->toUser->account->id,
            'type_id' => PaymentType::DEBET,
            'amount' => $amount,
        ]);

        $newAmountFrom = $amountFrom - $amount;
        $newAmountTo = $amountTo + $amount;
        expect_that($this->floatEquals($model->fromUser->account->amount, $newAmountFrom));
        expect_that($this->floatEquals($model->toUser->account->amount, $newAmountTo));
        expect_that($model->state_id == TransferState::ACCEPTED);

        Yii::$app->user->identity = $appUser;
    }

    public function floatEquals($a, $b, $delta = 0.1)
    {
        return (abs($a - $b) < $delta);
    }
}
