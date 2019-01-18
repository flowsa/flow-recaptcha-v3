/**
 * FlowReCaptcha plugin for Craft CMS
 *
 * FlowReCaptcha JS
 *
 * @author    Flow Communications
 * @copyright Copyright (c) 2018 Flow Communications
 * @link      https://www.flowsa.com
 * @package   FlowReCaptcha
 * @since     0.0.1
 */
grecaptcha.ready(function () {
  $('.g-recaptcha-response').each(function () {
    $(this).closest('form').find('button').prop('disabled', true);
  });
  grecaptcha.execute($('.g-recaptcha-response').attr('data-sitekey'), {action: 'contact_form'}).then(function (token) {
    $('.g-recaptcha-response').each(function () {
      $(this).closest('form').find('button').prop('disabled', false);
      $(this).val(token);
    });
  });
});
