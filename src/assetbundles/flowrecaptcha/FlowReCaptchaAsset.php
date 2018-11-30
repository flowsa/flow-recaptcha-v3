<?php
/**
 * FlowReCaptcha plugin for Craft CMS 3.x
 *
 * A re-captcha field type for validating forms
 *
 * @link      https://www.flowsa.com
 * @copyright Copyright (c) 2018 Flow Communications
 */

namespace flowsa\flowrecaptcha\assetbundles\FlowReCaptcha;

use Craft;
use craft\web\AssetBundle;
// use yii\web\JqueryAsset;
// use craft\web\assets\cp\CpAsset;

/**
 * @author    Flow Communications
 * @package   FlowReCaptcha
 * @since     0.0.1
 */
class FlowReCaptchaAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@flowsa/flowrecaptcha/assetbundles/flowrecaptcha/dist";

<<<<<<< HEAD
=======
        // $this->depends = [
        //     CpAsset::class,
        // ];
>>>>>>> bb6e9efb27d1ea6bfafd3ed2582a6602658fecde

        $this->js = [
            'js/FlowReCaptcha.js',
        ];

        $this->css = [
            'css/FlowReCaptcha.css',
        ];

        parent::init();
    }
}
