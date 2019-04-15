<?php
/**
 * FlowReCaptcha plugin for Craft CMS 3.x
 *
 * A re-captcha field type for validating forms
 *
 * @link      https://www.flowsa.com
 * @copyright Copyright (c) 2018 Flow Communications
 */

namespace flowsa\flowrecaptchav3\assetbundles\flowrecaptchav3;

use Craft;
use craft\web\AssetBundle;
use yii\web\JqueryAsset;
// use craft\web\assets\cp\CpAsset;

/**
 * @author    Flow Communications
 * @package   FlowReCaptcha
 * @since     0.0.1
 */
class FlowRecaptchaV3Asset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@flowsa/flowrecaptchav3/assetbundles/flowrecaptchav3/dist";

         $this->depends = [
            JqueryAsset::class,
        ];
        
        $this->js = [
            'js/FlowReCaptcha.js',
        ];

        $this->css = [
            'css/FlowReCaptcha.css',
        ];

        parent::init();
    }
}
