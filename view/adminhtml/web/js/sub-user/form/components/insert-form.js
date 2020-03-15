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
    'Magento_Ui/js/form/components/insert-form'
], function (Insert) {
    'use strict';

    return Insert.extend({
        defaults: {
            listens: {
                responseData: 'onResponse'
            },
            modules: {
                subUserListing: '${ $.subUserListingProvider }',
                subUserModal: '${ $.subUserModalProvider }'
            }
        },

        /**
         * Close modal, reload sub-user listing
         *
         * @param {Object} responseData
         */
        onResponse: function (responseData) {
            if (!responseData.error) {
                this.subUserModal().closeModal();
                this.subUserListing().reload({
                    refresh: true
                });
            }
        },

        /**
         * Event method that closes "Edit" modal and refreshes grid after sub-user
         * was removed through "Delete" button on the "Edit" modal
         */
        onSubUserDelete: function () {
            this.subUserModal().closeModal();
            this.subUserListing().reload({
                refresh: true
            });
        }
    });
});
