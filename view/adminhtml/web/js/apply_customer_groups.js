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

/* eslint-disable no-undef */
// jscs:disable jsDoc

define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'mage/translate',
    'prototype'
], function ($, alert, $t) {
    'use strict';

    return function (config) {
        $('#apply_cg_button').click(function () {
            let self = $(this),
                $selectedGroups = $('#bss_company_account_general_apply_for_customer_group'),
                selectedGroups = $selectedGroups.val();
            selectedGroups = selectedGroups.filter(function (item) {
                return item !== "";
            });

            if (selectedGroups.length > 0) {
                self.closest('.value').find('.success').hide();
                self.closest('.value').find('.processing').show();
                // $('#message_span').text('');
                $.ajax({
                    url: config.customerGroupsUrl,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        groupIds: selectedGroups
                    }
                }).done(function (res) {
                    self.closest('.value').find('.success').show();
                    self.closest('.value').find('.processing').hide();
                    // $('#message_span').text('');
                    console.log(res);
                }).fail(function (res) {
                    self.closest('.value').find('.success').show();
                    self.closest('.value').find('.processing').hide();
                    // $('#message_span').text('');
                    console.log(res);
                });
            } else {
                alert({
                    title: $t('Notification'),
                    content: $t('No group is selecting.'),
                });
            }
        });
    }
});