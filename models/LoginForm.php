<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Logs in a user using the provided username
     * If the login does not exists creates a new user with this login
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if (!$user) {
                $user = new User();
                $user->username = $this->username;
                $user->auth_key = 'test';
                $user->password_hash = 'test';
                $user->email = 'test';
                $saved = $user->save();

                if (!$saved) {
                    throw new \yii\web\ServerErrorHttpException(Yii::t('app', 'Cannot create user'));
                }
            }
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
