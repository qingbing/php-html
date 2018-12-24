<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2018-10-27
 * Version      :   1.0
 */

namespace Test;

use Html;
use TestClass\TestModel;
use TestCore\Tester;

class TestHtml extends Tester
{
    /**
     * 执行函数
     * @throws \Exception
     */
    /*public function run()
    {
        if (isset($_GET['do']) && $_GET['do']) {
            var_dump($_GET);
            exit;
        }
        $str = Html::beginForm(['', "c" => "TestHtml", "do" => "1",], 'get');
        echo $str . "\n";

        $str = Html::encode('<div> code </div>');
        echo $str . "\n";

        $str = Html::decode('&lt;div&gt; code &lt;/div&gt;');
        echo $str . "\n";

        $str = Html::cdata("attr");
        echo $str . "\n";

        $str = Html::tag('input', ['id' => 'tag'], '11', false);
        echo $str . "\n";

        $str = Html::link('This is a link', 'http://www.baidu.com', []);
        echo $str . "\n";

        // 生成 link-meta 属性，需要通过 \ClientScript::getInstance()->render($html); // 来渲染
        Html::refresh('This is a link', 'http://www.baidu.com');

        $str = Html::openTag('div', ['id' => 'openTag']) . ' Content ' . Html::closeTag('div');
        echo $str . "\n";

        $str = Html::metaTag('This is description.', 'description', 'content-type', []);
        echo $str . "\n";

        $str = Html::linkTag(null, 'description', '/public/css/main.css', null, []);
        echo $str . "\n";

        $str = Html::css("body{font-size:18px;}");
        echo $str . "\n";

        $str = Html::cssFile('/public/css/main.css');
        echo $str . "\n";

        $str = Html::script('console.log(123);');
        echo $str . "\n";

        $str = Html::scriptFile('/public/css/main.js');
        echo $str . "\n";

        $str = Html::label('This is a label.');
        echo $str . "\n";

        $str = Html::mailto('This is a label.', '780042175@qqb.com');
        echo $str . "\n";

        $str = Html::image('/public/img/1.png', '消息');
        echo $str . "\n";

        $str = Html::button('SingleTagButton');
        echo $str . "\n";

        $str = Html::htmlButton('DoubleTagButton');
        echo $str . "\n";

        $str = Html::submitButton('SubmitButton');
        echo $str . "\n";

        $str = Html::resetButton('ResetButton');
        echo $str . "\n";

        $str = Html::imageButton('/public/img/1.png');
        echo $str . "\n";

        $str = Html::linkButton('LinkButton');
        echo $str . "\n";

        $str = Html::textField('textField', 'TextField', []);
        echo $str . "\n";

        $str = Html::passwordField('passwordField', 'PasswordField', []);
        echo $str . "\n";

        $str = Html::fileField('fileField', []);
        echo $str . "\n";

        $str = Html::hiddenField('hidden[Field]', 'hiddenField', []);
        echo $str . "\n";

        $str = Html::textArea('textArea', 'textArea', []);
        echo $str . "\n";

        $str = Html::radioButton('radioButton', true, []);
        echo $str . "\n";

        $str = Html::radioButtonList('radioButtonList', 'pear', [
            'pear' => '梨子',
            'apple' => '苹果',
            'banana' => '香蕉',
        ]);
        echo $str . "\n";

        $str = Html::checkBox('checkBox', true, []);
        echo $str . "\n<br>";

        $str = Html::checkBoxList('radioButtonList', ['pear', 'apple'], [
            'pear' => '梨子',
            'apple' => '苹果',
            'banana' => '香蕉',
        ]);
        echo $str . "\n";

        $str = Html::dropDownList('dropDownList', 'apple', [
            'pear' => '梨子',
            'apple' => '苹果',
            'banana' => '香蕉',
        ]);
        echo $str . "\n";

        $str = Html::listBox('listBox', ['apple', 'banana'], [
            'pear' => '梨子',
            'apple' => '苹果',
            'banana' => '香蕉',
        ], [
            'multiple' => '1'
        ]);
        echo $str . "\n";

        $str = Html::endForm();
        echo $str . "\n";
    }*/

    public function run()
    {
        if (isset($_GET['do']) && $_GET['do']) {
            var_dump($_GET);
            exit;
        }
        $model = new TestModel();
        $rString = '<ul>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'textField') . '</dt>';
        $rString .= '<dd>' . Html::activeTextField($model, 'textField') . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'hiddenField') . '</dt>';
        $rString .= '<dd>' . Html::activeHiddenField($model, 'hiddenField') . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'passwordField') . '</dt>';
        $rString .= '<dd>' . Html::activePasswordField($model, 'passwordField') . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'fileField') . '</dt>';
        $rString .= '<dd>' . Html::activeFileField($model, 'fileField') . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'textarea') . '</dt>';
        $rString .= '<dd>' . Html::activeTextArea($model, 'textarea') . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'radioButton') . '</dt>';
        $rString .= '<dd>' . Html::activeRadioButton($model, 'radioButton') . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'checkbox') . '</dt>';
        $rString .= '<dd>' . Html::activeCheckbox($model, 'checkbox') . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'dropDownlist') . '</dt>';
        $rString .= '<dd>' . Html::activeDropDownList($model, 'dropDownlist', TestModel::dropDownlist()) . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'listbox') . '</dt>';
        $rString .= '<dd>' . Html::activeListBox($model, 'listbox', TestModel::dropDownlist()) . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'checkboxList') . '</dt>';
        $rString .= '<dd>' . Html::activeCheckboxList($model, 'checkboxList', TestModel::dropDownlist()) . '</dd></dl>';

        $rString .= '<dl><dt>' . Html::activeLabel($model, 'radioButtonList') . '</dt>';
        $rString .= '<dd>' . Html::activeRadioButtonList($model, 'radioButtonList', TestModel::dropDownlist()) . '</dd></dl>';

        $rString .= '</ul>';
        echo $rString;
    }
}