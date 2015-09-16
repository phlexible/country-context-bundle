Ext.require('Phlexible.countrycontext.view.CountryContextAccordion');
Ext.require('Phlexible.elements.ElementAccordion');

Phlexible.elements.ElementAccordion.prototype.populateItems =
    Phlexible.elements.ElementAccordion.prototype.populateItems.createSequence(function() {
        this.items.push({
            xtype: 'country-context-accordion',
            collapsed: true
        });
    });
