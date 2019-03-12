<?php
/**
 * FlowReCaptcha plugin for Craft CMS 3.x
 *
 * A re-captcha field type for validating forms
 *
 * @link      https://www.flowsa.com
 * @copyright Copyright (c) 2018 Flow Communications
 */

namespace flowsa\flowrecaptchav3\fields;


use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use flowsa\flowrecaptchav3\FlowRecaptchaV3;
use flowsa\googlemapembed\GoogleMapEmbed;
use GuzzleHttp\Client;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Flow Communications
 * @package   FlowReCaptcha
 * @since     0.0.1
 */
class FlowRecaptchaV3Field extends Field
{
    // Public Properties
    // =========================================================================

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('flow-recaptcha-v3', 'Flow Recaptcha V3');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
        ]);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'flow-recaptcha-v3/_components/fields/FlowRecaptchaV3Field_settings',
            [
                'field' => $this,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        static $onceOnly = null;

        // Get our id and namespace
        $id           = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        if (!$onceOnly) {
            Craft::$app->getView()->registerJsFile('https://www.google.com/recaptcha/api.js?render=' . FlowRecaptchaV3::$plugin->getSettings()->siteKey);
            $onceOnly = true;
        }


        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'flow-recaptcha-v3/_components/fields/FlowRecaptchaV3Field_input',
            [
                'name'         => $this->handle,
                'value'        => $value,
                'field'        => $this,
                'id'           => $id,
                'namespacedId' => $namespacedId,
                'siteKey'      => FlowRecaptchaV3::$plugin->getSettings()->siteKey,
            ]
        );
    }

    public function _validate()
    {
        $captcha = Craft::$app->request->post('fields.g-recaptcha-response');
        $request = Craft::$app->getRequest();

        if ($request->getIsCpRequest()) {
            return true;
        }

        $verified = $this->verify($captcha);

        return $verified;
    }

    public function getElementValidationRules(): array
    {
        //$this->handle
        return [
            [$this->handle, 'skipOnEmpty' => false, function ($model, $params) {
                if (!$this->_validate()) {
                    $model->addError($this->handle, 'The CAPTCHA verification failed.');
                    return false;
                }
            }]
        ];
    }

    public function verify($data)
    {
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . FlowRecaptchaV3::$plugin->getSettings()->secretKey . "&response=" . $data);
        $json  = json_decode($response);

        return ($json->success && $json->score > 0.5);
    }

}
