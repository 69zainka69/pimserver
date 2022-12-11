
/*
 * This file is part of EspoCRM and/or AtroCore.
 *
 * EspoCRM - Open Source CRM application.
 * Copyright (C) 2014-2019 Yuri Kuznetsov, Taras Machyshyn, Oleksiy Avramenko
 * Website: http://www.espocrm.com
 *
 * AtroCore is EspoCRM-based Open Source application.
 * Copyright (C) 2020 AtroCore UG (haftungsbeschränkt).
 *
 * AtroCore as well as EspoCRM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AtroCore as well as EspoCRM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with EspoCRM. If not, see http://www.gnu.org/licenses/.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "EspoCRM" word
 * and "AtroCore" word.
 *
 * This software is not allowed to be used in Russia and Belarus.
 */

Espo.define('views/dashlets/fields/records/bool-filter-list', 'views/fields/multi-enum', function (Dep) {

    return Dep.extend({

        setup: function () {
            Dep.prototype.setup.call(this);

            this.listenTo(this.model, 'change:entityType', function () {
                this.setupOptions();
                this.reRender();
            }, this);
        },

        setupOptions: function () {
            var entityType = this.model.get('entityType');
            if (!entityType) {
                this.params.options = [];
                return;
            }

            var filterList = this.getMetadata().get(['clientDefs', entityType, 'boolFilterList']) || [],
                hiddenFilterList = this.getMetadata().get(['clientDefs', entityType, 'hiddenBoolFilterList']) || [],
                actualFilterList = filterList.filter(item => !hiddenFilterList.includes(item));

            this.params.options = [];

            actualFilterList.forEach(function (item) {
                    if (typeof item === 'object' && item.name) {
                    if (item.accessDataList) {
                        if (!Espo.Utils.checkAccessDataList(item.accessDataList, this.getAcl(), this.getUser(), null, true)) {
                            return false;
                        }
                    }
                    this.params.options.push(item.name);
                    return;
                }
                this.params.options.push(item);
            }, this);

            if (this.getMetadata().get(['scopes', entityType, 'stream']) && this.getAcl().checkScope(entityType, 'stream')) {
                this.params.options.push('followed');
            }

            this.translatedOptions = {};
            this.params.options.forEach(function (item) {
                this.translatedOptions[item] = this.translate(item, 'boolFilters', entityType);
            }, this);
        }

    });

});
