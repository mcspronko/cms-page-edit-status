define([
    'uiComponent',
    'jquery',
    'mageUtils'
], function (Component, $, utils) {
   'use strict';

   return Component.extend({
     defaults: {
       updateStatusUrl: '',
       backButtonUrl: '',
       pageId: 0,
       backButtonId: '#back'
     },

     initialize: function () {
       this._super();
       var backButton = $(this.backButtonId);

       backButton.attr('onclick', '');
       backButton.on('click', $.proxy(this.handleStatusUpdate, this));
     },

     handleStatusUpdate: function (event) {
       var options = {ajaxSaveType: 'simple'},
           backUrl = this.backButtonUrl;

       utils.ajaxSubmit(
         {
           url: this.updateStatusUrl,
           data: {
             'page_id': this.pageId
           }
         },
         options
       ).always(function () {
         location.href = backUrl;
       }, this);
     }
   });
});
