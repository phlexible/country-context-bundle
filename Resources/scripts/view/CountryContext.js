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

        this.tbar = [
            this.strings.mode,
        {
            xtype: 'combo',
            value: 'positive',
            store: new Ext.data.SimpleStore({
                fields: ['mode', 'name'],
                data: [['positive', this.strings.positive], ['negative', this.strings.negative]]
            }),
            displayField: 'name',
            valueField: 'type'
        }];

        Phlexible.countrycontext.view.CountryContextAccordion.superclass.initComponent.call(this);
    },

    load: function(data) {
        if (data.context === undefined) {
            this.hide();
            return;
        }

        this.getTopToolbar().items.items[1].setValue(data.mode);

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
