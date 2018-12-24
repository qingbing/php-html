<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2018-12-17
 * Version      :   1.0
 */

use Abstracts\SingleTon;
use Components\Request;

class ClientScript extends SingleTon
{
    const POS_HEAD = 0; // 将脚本放在HTMl的头部
    const POS_BEGIN = 1; // 将脚本放在HTML的body开始位置
    const POS_END = 2; // 将脚本放在HTML的body的结束位置

    private $_hasScripts = false;
    private $_isRendHead = false;
    private $_isRendBodyBegin = false;
    private $_isRendBodyEnd = false;

    private $_metaTags = [];
    private $_linkTags = [];
    private $_css = [];
    private $_cssFiles = [];
    private $_scripts = [];
    private $_scriptFiles = [];

    /**
     * 注册 head-meta
     * @param string $content
     * @param string $name
     * @param string $httpEquiv
     * @param array $options
     * @return $this
     */
    public function registerMetaTag($content, $name = null, $httpEquiv = null, $options = [])
    {
        $this->_hasScripts = true;
        $_html = Html::metaTag($content, $name, $httpEquiv, $options);
        if (!in_array($_html, $this->_metaTags)) {
            array_push($this->_metaTags, $_html);
        }
        return $this;
    }

    /**
     * 注册 link-tag
     * @param string $relation
     * @param string $type
     * @param string $href
     * @param string $media
     * @param array $options
     * @return $this
     */
    public function registerLinkTag($relation = null, $type = null, $href = null, $media = null, $options = [])
    {
        $this->_hasScripts = true;
        $_html = Html::linkTag($relation, $type, $href, $media, $options);
        if (!in_array($_html, $this->_linkTags)) {
            array_push($this->_linkTags, $_html);
        }
        return $this;
    }

    /**
     * 注册 css 内容
     * @param string $id
     * @param string $css
     * @param string $media
     * @return $this
     */
    public function registerCss($id, $css, $media = '')
    {
        $this->_hasScripts = true;
        if (!isset($this->_css[$id])) {
            $this->_css[$id] = Html::css($css, $media);
        }
        return $this;
    }

    /**
     * 注册 css 文件
     * @param string $url
     * @param string $media
     * @return $this
     * @throws \Exception
     */
    public function registerCssFile($url, $media = '')
    {
        $this->_hasScripts = true;
        if ('/' !== substr($url, 0, 1) && !preg_match('#^https?:\/\/#', $url)) {
            $url = Request::httpRequest()->getBaseUrl() . '/' . $url;
        }
        if (!isset($this->_cssFiles[$url])) {
            $this->_cssFiles[$url] = Html::cssFile($url, $media);
        }
        return $this;
    }

    /**
     * 注册 js 内容
     * @param string $id
     * @param string $text
     * @param int $position
     * @return $this
     */
    public function registerScript($id, $text, $position = self::POS_END)
    {
        $this->_hasScripts = true;
        if (!isset($this->_scripts[$position][$id])) {
            $this->_scripts[$position][$id] = Html::script($text);
        }
        return $this;
    }

    /**
     * 注册 js 文件
     * @param string $url
     * @param int $position
     * @return $this
     * @throws \Exception
     */
    public function registerScriptFile($url, $position = self::POS_HEAD)
    {
        $this->_hasScripts = true;
        if ('/' !== substr($url, 0, 1) && !preg_match('#^https?:\/\/#', $url)) {
            $url = Request::httpRequest()->getBaseUrl() . '/' . $url;
        }
        if (!isset($this->_scriptFiles[$position][$url])) {
            $this->_scriptFiles[$position][$url] = Html::scriptFile($url);
        }
        return $this;
    }

    /**
     * 将注册的内容（css、js）注入 HTML 中
     * @param string $output
     */
    public function render(&$output)
    {
        if (false !== $this->_hasScripts) {
            $this->_renderHead($output);
            $this->_renderBodyBegin($output);
            $this->_renderBodyEnd($output);
        }
    }

    /**
     * 在 HTML-HEAD 注入内容（css、js）
     * @param bool $outputCapture
     * @return string
     */
    public function renderHead($outputCapture = false)
    {
        $this->_isRendHead = true;
        $ha = [];
        if (!empty($this->_metaTags)) {
            $ha = array_merge($ha, $this->_metaTags);
        }
        if (!empty($this->_linkTags)) {
            $ha = array_merge($ha, $this->_linkTags);
        }
        if (!empty($this->_cssFiles)) {
            $ha = array_merge($ha, $this->_cssFiles);
        }
        if (isset($this->_scriptFiles[self::POS_HEAD])) {
            $ha = array_merge($ha, $this->_scriptFiles[self::POS_HEAD]);
        }
        if (isset($this->_scripts[self::POS_HEAD])) {
            $ha = array_merge($ha, $this->_scripts[self::POS_HEAD]);
        }

        $_html = implode("\n", $ha);
        if ($outputCapture) {
            return $_html;
        } else {
            echo $_html;
            return null;
        }
    }

    /**
     * 渲染 HTML-HEAD 内容
     * @param string $output
     */
    private function _renderHead(&$output)
    {
        if (true === $this->_isRendBodyBegin || '' === ($_html = $this->renderHead(true))) {
            return;
        }

        if ('' !== $_html) {
            $_html .= "\n";
            $count = 0;
            $output = preg_replace('/(<title\b[^>]*>|<\\/head\s*>)/is', '<###head###>$1', $output, 1, $count);
            if ($count) {
                $output = str_replace('<###head###>', $_html, $output);
            } else {
                $output = $_html . $output;
            }
        }
    }

    /**
     * 在 BODY-BEGIN 注入内容（css、js）
     * @param bool $outputCapture
     * @return string
     */
    public function renderBodyBegin($outputCapture = false)
    {
        $this->_isRendBodyBegin = true;
        $ha = [];
        if (!empty($this->_css)) {
            $ha = array_merge($ha, $this->_css);
        }
        if (isset($this->_scriptFiles[self::POS_BEGIN])) {
            $ha = array_merge($ha, $this->_scriptFiles[self::POS_BEGIN]);
        }
        $_html = implode("\n", $ha);
        if ($outputCapture) {
            return $_html;
        } else {
            echo $_html;
            return null;
        }
    }

    /**
     * 渲染 BODY-BEGIN 内容
     * @param string $output
     */
    private function _renderBodyBegin(&$output)
    {
        if (true === $this->_isRendBodyBegin || '' === ($_html = $this->renderBodyBegin(true))) {
            return;
        }

        if ('' !== $_html) {
            $count = 0;
            $output = preg_replace('/(<body\b[^>]*>)/is', '$1<###begin###>', $output, 1, $count);
            if ($count) {
                $output = str_replace('<###begin###>', $_html, $output);
            } else {
                $output = $_html . $output;
            }
        }
    }

    /**
     * 在 BODY-END 注入内容（css、js）
     * @param bool $outputCapture
     * @return string
     */
    public function renderBodyEnd($outputCapture = false)
    {
        $this->_isRendBodyEnd = true;
        $ha = [];
        if (isset($this->_scriptFiles[self::POS_END])) {
            $ha = array_merge($ha, $this->_scriptFiles[self::POS_END]);
        }
        if (isset($this->_scripts[self::POS_END])) {
            $ha = array_merge($ha, $this->_scripts[self::POS_END]);
        }

        $_html = implode("\n", $ha);
        if ($outputCapture) {
            return $_html;
        } else {
            echo $_html;
            return null;
        }
    }

    /**
     * 渲染 BODY-END 内容
     * @param string $output
     */
    private function _renderBodyEnd(&$output)
    {
        if (true === $this->_isRendBodyEnd || '' === ($_html = $this->renderBodyEnd(true))) {
            return;
        }

        $fullPage = 0;
        $output = preg_replace('/(<\\/body\s*>)/is', '<###end###>$1', $output, 1, $fullPage);
        if ($fullPage) {
            $output = str_replace('<###end###>', $_html, $output);
        } else {
            $output = $output . $_html;
        }
    }
}