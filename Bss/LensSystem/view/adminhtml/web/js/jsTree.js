// jscs:disable requireCamelCaseOrUpperCaseIdentifiers
define([
    'jquery',
    'jsTreeLib',
    'Magento_Ui/js/modal/modal'
], function ($) {
    'use strict';

    $.widget('mage.jsTree', {
        options: {
            optionsTreeSelector: '#optionTree',
            stepsTreeSelector: '#stepTree',
            conditionTreeSelector: '#conditionTree',

            optionsData: [
                {
                    'id': 'root',
                    'parent': '#',
                    'text': 'Lens Options'
                }
            ],
            stepsData: [
                {
                    'id': 'root',
                    'parent': '#',
                    'text': 'Lens Steps'
                }
            ],
            conditionData: [
                {
                    'id': 'root',
                    'parent': '#',
                    'text': 'Lens Condition'
                }
            ],

            inputConditionValueSelector: 'input[name=condition_value]'
        },

        /**
         * Init all trees
         * @private
         */
        _create: function () {
            this.initSourceTree(this.options.stepsTreeSelector, this.options.optionsData);
            this.initSourceTree(this.options.optionsTreeSelector, this.options.stepsData);
            this.initDestinationTree(this.options.conditionTreeSelector, this.options.conditionData);
            this.updateConditionTree();
        },

        /**
         * Create source: steps and condition tree
         * @param {String} selector
         * @param {Array} data
         */
        initSourceTree: function (selector, data) {
            $(selector)
                .jstree({
                    'core': {
                        'data': data,
                        'themes': {
                            'url': true,
                            'icons': true,
                            'dots': true
                        },

                        /** Check events and update data */
                        'check_callback': function (operation) {
                            if (operation === 'copy_node' || operation === 'move_node') {
                                return false;
                            }
                        }
                    },
                    'plugins': ['dnd'],
                    'dnd': {
                        'always_copy': true
                    }
                });
        },

        /**
         * Create destination: condition tree
         * @param {String} selector
         * @param {String} data
         */
        initDestinationTree: function (selector, data) {
            var self = this;

            $(selector)
                .jstree({
                    'core': {
                        'data': JSON.parse(data),
                        'themes': {
                            'url': true,
                            'icons': true
                        },

                        /** Check events and update data */
                        'check_callback': function (operation) {
                            if (operation === 'copy_node' || operation === 'move_node' || operation === 'delete_node') {
                                self.updateConditionTree();
                                self.updateData();
                            }
                        },
                        'dblclick_toggle': false
                    },
                    'plugins': ['dnd', 'changed', 'contextmenu'],
                    'contextmenu': {
                        /** Context menu */
                        'items': function (node) {
                            var defaultItems = $.jstree.defaults.contextmenu.items(),
                                updatePrice = {
                                'separator_before': false,
                                'separator_after': false,
                                'label': 'Update Price',

                                /** Update price of option */
                                'action': function () {
                                    var nodeUpdate = $('li#' + node.id);

                                    self.updatePrice(nodeUpdate);
                                }
                            };

                            delete defaultItems.create;
                            delete defaultItems.rename;
                            defaultItems.updatePrice = updatePrice;

                            return defaultItems;
                        }
                    }
                })
                .on('keydown.tree', '.jstree-anchor', function (e) {
                    if (e.target.tagName && e.target.tagName.toLowerCase() === 'input') {
                        return true;
                    }

                    if (e.which === 46) {
                        $(selector).jstree('delete_node', e.target);
                    }
                    e.stopImmediatePropagation();

                    return false;
                })
                // update price for each option when update tree
                .on('loaded.jstree changed.jstree open_node.jstree', function () {
                    self.updateConditionTree();
                })
                .bind('dblclick.jstree', function (event) {
                    var node = $(event.target).closest('li');

                    self.updatePrice(node);
                })
                .bind('ready.jstree', function () {
                    var tree = $(selector),
                        branchCont = tree.jstree(true)._model.data;

                    tree.jstree('open_all');

                    /** Delete null steps, options */
                    $.each(branchCont, function (index, branch) {
                        if (branch.text && branch.text === 'null_data') {
                            tree.jstree('delete_node', $('li#' + branch.id).find('a')[0]);
                        }
                    });

                    self.updateData();
                });
        },

        /**
         * Update price for specific option node, using modal
         * @param {Object} node
         */
        updatePrice: function (node) {
            var self = this,
                selector = this.options.conditionTreeSelector,
                optionsModal = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: $.mage.__('Add option price:'),
                buttons: [{
                    text: $.mage.__('Ok'),

                    /** Close modal and update price data */
                    click: function () {
                        var price = $('#option-price').val() || 0,
                            included = $('#isIncluded').is(':checked') ? 1 : 0;

                        this.closeModal();

                        $(selector).jstree().get_selected(true)[0]['li_attr'].included = included;
                        $(selector).jstree().get_selected(true)[0]['li_attr'].price = included ? 0 : price;
                        self.updateConditionTree();
                        self.updateData();
                    }
                }]
            };

            if (node.attr('type') !== 'option') {
                return;
            }
            $('#price-modal').modal(optionsModal).modal('openModal');
            $('#option-price').val($(selector).jstree().get_selected(true)[0]['li_attr'].price);
            $('#isIncluded').prop('checked', $(selector).jstree().get_selected(true)[0]['li_attr'].included);
        },

        /**
         * update all price of condition tree
         */
        updateConditionTree: function () {
            var self = this;

            setTimeout(function () {
                var selector = self.options.conditionTreeSelector,
                    nodes = $('#conditionRoot').find('li[type=option]');

                nodes.each(function (i) {
                    // node of tree
                    var element = $(selector).jstree(true).get_node($(nodes[i]).attr('id'));

                    if (element.li_attr.included) {
                        $(nodes[i]).find('a').contents()[1].nodeValue = element.text +
                            ' --- INCLUDED ';
                    } else {
                        $(nodes[i]).find('a').contents()[1].nodeValue = element.text +
                            ' --- Price: ' + element.li_attr.price;
                    }
                });
            }, 300);
        },

        /**
         * Update input when drag and drop in condition tree
         */
        updateData: function () {
            var selector = this.options.conditionTreeSelector;

            setTimeout(function () {
                var items = $(selector).jstree(true).get_json('conditionRoot', {
                    flat: true
                }),
                    data = items.slice(1).map(function (item) {
                    return {
                        id: item.id,
                        parent: item.parent,
                        li_attr: item.li_attr
                    };
                });

                $('input[name=condition_value]').val(JSON.stringify(data)).change();
            }, 300);
        }
    });

    return $.mage.jsTree;
});
