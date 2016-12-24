<?php
namespace app\helpers;

use Yii;

/**
 * Helper for rendering form fields
 */
class Render
{
    /** @var \yii\widgets\ActiveForm */
    private $form;

    /** @var \yii\db\ActiveRecord */
    private $model;


    public function __construct($form, $model)
    {
        $this->form = $form;
        $this->model = $model;
    }

    /**
     * Returns default options for a form field
     * @param string $attribute
     * @return array
     */
    private function getDefaultOptions($attribute)
    {
        $defaultFieldOptions = ['options' => ['class' => 'form-group']];
        $defaultInputOptions = ['class' => 'form-control'];

        return [$defaultFieldOptions, $defaultInputOptions];
    }


    /**
     * Renders text field
     * @param string $attribute
     * @param array $widgetOptions
     * @param array $fieldOptions
     */
    public function textField($attribute, $fieldOptions = [], $inputOptions = [])
    {
        list ($defaultFieldOptions, $defaultInputOptions) = $this->getDefaultOptions($attribute);

        $fieldOptions = array_replace_recursive($defaultFieldOptions, $fieldOptions);
        $inputOptions = array_replace_recursive($defaultInputOptions, $inputOptions);

        return $this->form->field($this->model, $attribute, $fieldOptions)->textInput($inputOptions);
    }

    /**
     * Renders select field
     * @param string $attribute
     * @param array $data
     * @param array $fieldOptions
     * @param array $inputOptions
     */
    public function selectField($attribute, $data, $fieldOptions = [], $inputOptions = [])
    {
        list ($defaultFieldOptions, $defaultInputOptions) = $this->getDefaultOptions($attribute);

        $defaultInputOptions['class'] .= ' select';
        $defaultInputOptions['prompt'] = Yii::t('app', 'Select...');

        $fieldOptions = array_replace_recursive($defaultFieldOptions, $fieldOptions);
        $inputOptions = array_replace_recursive($defaultInputOptions, $inputOptions);

        return $this->form->field($this->model, $attribute, $fieldOptions)->dropDownList($data, $inputOptions);
    }
}
