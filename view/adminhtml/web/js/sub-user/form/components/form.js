/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   BSS
 * @package    Bss_CompanyAccount
 * @author     Extension Team
 * @copyright  Copyright (c) 2020 BSS Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */
define([
    'jquery',
    'Magento_Ui/js/model/messageList',
    'mage/backend/notification',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/confirm',
    'Magento_Ui/js/form/form',
    'underscore',
    'mage/translate'
], function ($, msg, notification, uiAlert, uiConfirm, Form, _, $t) {
    'use strict';

    return Form.extend({
        defaults: {
            deleteConfirmationMessage: '',
            resetPasswordConfirmationMessage: '',
            ajaxSettings: {
                method: 'POST',
                dataType: 'json'
            }
        },

        /**
         * Delete sub-user by provided url.
         * Will call confirmation message to be sure that user is really wants to delete this sub-user
         *
         * @param {String} url - ajax url
         */
        deleteSubUser: function (url) {
            var that = this;

            uiConfirm({
                content: this.deleteConfirmationMessage,
                actions: {
                    /** @inheritdoc */
                    confirm: function () {
                        that._delete(url);
                    }
                }
            });
        },

        /**
         * Send reset password mail by provided url.
         *
         * @param {String} url - ajax url
         */
        resetPasswordSubUser: function (url) {
            var self = this;
            msg.addSuccessMessage({message: 'estttt'});

            uiConfirm({
                content: this.resetPasswordConfirmationMessage,
                actions: {
                    confirm: function () {
                        self._sendResetPasswordMail(url);
                    }
                }
            });
        },

        /**
         * Perform asynchronous POST request to server
         *
         * @param {String} url - ajax url
         */
        _sendResetPasswordMail: function (url) {
            var settings = _.extend({}, this.ajaxSettings, {
                url: url,
                data: {
                    'form_key': window.FORM_KEY
                }
                }),
                that = this;

            $('body').trigger('processStart');

            return $.ajax(settings)
                .done(function (res) {
                    $('body').notification('clear')
                        .notification('add', {
                            error: false,
                            message: '123',
                            insertMethod: function (message) {
                                var $wrapper = $('<div/>').html(message);

                                $('.page-main-actions').after($wrapper);
                            }
                        });
                })
                .fail(function (res) {
                    uiAlert({
                        content: res.statusText
                    });
                }).always(function () {
                    $('body').trigger('processStop');
                });
        },

        /**
         * Perform asynchronous DELETE request to server.
         *
         * @param {String} url - ajax url
         * @returns {Deferred}
         */
        _delete: function (url) {
            var settings = _.extend({}, this.ajaxSettings, {
                url: url,
                data: {
                    'form_key': window.FORM_KEY
                }
                }),
                that = this;

            $('body').trigger('processStart');

            return $.ajax(settings)
                .done(function (response) {
                    if (response.error) {
                        uiAlert({
                            content: response.message
                        });
                    } else {
                        that.trigger('deleteSubUserAction');
                    }
                })
                .fail(function () {
                    uiAlert({
                        content: $t('Sorry, there has been an error processing your request. Please try again later.')
                    });
                })
                .always(function () {
                    $('body').trigger('processStop');
                });
        }
    });
});
