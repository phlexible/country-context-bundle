Ext.provide('Phlexible.countrycontext.view.CountryContextAccordion');

Phlexible.countrycontext.view.CountryContextAccordion = Ext.extend(Ext.grid.EditorGridPanel, {
    strings: Phlexible.countrycontext.Strings,
    title: Phlexible.countrycontext.Strings.country_context,
    iconCls: 'p-gui-de-icon',
    border: false,
    autoHeight: true,
    autoExpandColumn: 1,
    viewConfig: {
        emptyText: Phlexible.countrycontext.Strings.no_country_context
    },

    key: 'context',

    initComponent: function() {
        this.store = new Ext.data.JsonStore({
            fields: [
                {name: 'id', type: 'string'},
                {name: 'country', type: 'string'},
                {name: 'state', type: 'bool'}
            ],
            id: 'id'
        });

        this.sm = new Ext.grid.RowSelectionModel({
            singleSelect: true
        });

        /*
        var checkColumn = new Ext.grid.CheckColumn({
            header: this.strings.active,
            dataIndex: 'state,
            width: 50,
            xrenderer: function(v) {
                var iconCls = v ? 'tick' : 'cross';

                return '<img src="' + Ext.BLANK_IMAGE_URL + '" width="16" height="16" class="m-elements-' + iconCls + '-icon" />';
            }
        });
        */

        var checkColumn = new Ext.grid.CheckColumn({
            header: this.strings.state,
            dataIndex: 'state',
            width: 50
        });

        this.plugins = [checkColumn];

        this.columns = [
            checkColumn,
            {
                header: this.strings.country,
                dataIndex: 'country',
                renderer: function(v, md, r) {
                    var icon = Phlexible.inlineIcon('p-gui-' + r.get('country') + '-icon');

                    return icon + ' ' + v;
                }
            }
        ];

        this.tbar = [{
            xtype: 'combo',
            value: 'positive',
            store: new Ext.data.SimpleStore({
                fields: ['type'],
                data: [['positive'], ['negative']]
            }),
            displayField: 'type',
            valueField: 'type'
        }];

        this.on({
            rowdblclick: function(grid, rowIndex) {
                var record = grid.getStore().getAt(rowIndex);
                if (!record) {
                    return;
                }
                if (record.get('state') === 'available') {
                    record.set('state', 'not_available');
                } else if (record.get('state') === 'not_available') {
                    record.set('state', 'undeceided');
                } else if (record.get('state') === 'undeceided') {
                    record.set('state', 'available');
                }
            },
            scope: this
        });

        Phlexible.countrycontext.view.CountryContextAccordion.superclass.initComponent.call(this);
    },

    load: function(data) {
        if (data.context === undefined) {
            this.hide();
            return;
        }

        this.getTopToolbar().items.items[0].setValue(data.mode);

        this.store.removeAll();
        if (data.context.countries && data.context.countries.length) {
            this.store.loadData(data.context);
        }

        this.show();
    },

    getData: function() {
        var records = this.store.getRange(),
            data = {};

        for(var i=0; i<records.length; i++) {
            data[records[i].get('id')] = records[i].get('state');
        }

        return data;
    }
});

Ext.reg('country-context-accordion', Phlexible.countrycontext.view.CountryContextAccordion);
