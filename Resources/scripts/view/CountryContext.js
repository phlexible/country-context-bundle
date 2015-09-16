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
            fields: ['id', 'country', 'state'],
            id: 'id'
        });

        this.sm = new Ext.grid.RowSelectionModel();

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

        this.columns = [
            {
                header: this.strings.country,
                dataIndex: 'country',
                renderer: function(v, md, r) {
                    var icon = Phlexible.inlineIcon('p-gui-' + r.data.id + '-icon');

                    return icon + ' ' + v;
                }
            },
            {
                header: this.strings.state,
                dataIndex: 'state',
                renderer: function(v) {
                    if (!v || v === 'undeceided') {
                        return Phlexible.inlineIcon('p-countrycontext-help-icon') + ' undeceided';
                    }
                    else if (v === 'available') {
                        return Phlexible.inlineIcon('p-countrycontext-tick-icon') + ' available';
                    }
                    else if (v === 'not_available') {
                        return Phlexible.inlineIcon('p-countrycontext-cross-icon') + ' not_available';
                    }

                    return v;
                }
            }
        ];

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
        if (!Ext.isArray(data.context) || !data.context.length) {
            this.hide();
            return;
        }

        this.store.removeAll();
        this.store.loadData(data.context);

        this.show();
    },

    getData: function() {
        var records = this.store.getRange(),
            data = {};

        for(var i=0; i<records.length; i++) {
            data[records[i].data.id] = records[i].data.state;
        }

        return data;
    }
});

Ext.reg('country-context-accordion', Phlexible.countrycontext.view.CountryContextAccordion);
