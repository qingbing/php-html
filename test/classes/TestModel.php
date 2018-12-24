<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2018-12-17
 * Version      :   1.0
 */

namespace TestClass;


use Abstracts\FormModel;

class TestModel extends FormModel
{
    public $textField;
    public $hiddenField = 'hide';
    public $passwordField = 'password';
    public $fileField;
    public $textarea;
    public $radioButton;
    public $checkbox;
    public $dropDownlist;
    public $listbox;
    public $checkboxList;
    public $radioButtonList;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['textField, hiddenField, passwordField', 'string'],
            ['fileField', 'string'],
            ['textarea', 'string'],
            ['radioButton', 'boolean'],
            ['checkbox', 'boolean'],
            ['dropDownlist', 'in', 'range' => ['apple', 'pear', 'banana']],
            ['listbox', 'in', 'range' => ['apple', 'pear', 'banana']],
            ['checkboxList', 'multiIn', 'range' => ['apple', 'pear', 'banana']],
            ['radioButtonList', 'in', 'range' => ['apple', 'pear', 'banana']],
        ];
    }

    public static function dropDownlist()
    {
        return [
            'apple' => '苹果',
            'pear' => '梨子',
            'banana' => '香蕉'
        ];
    }
}