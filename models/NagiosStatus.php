<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is a model that reads the Nagios Status Dat File
 * 
 * It provides access to the array
 */
class NagiosStatus extends Model
{
    protected $_datFile;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            //[['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            //['email', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }
    
    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            //'verifyCode' => 'Verification Code',
        ];
    }
    


}