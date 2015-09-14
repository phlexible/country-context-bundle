Ext.provide('Phlexible.countrycontext.view.CountryContextAccordion');
Ext.require('Phlexible.elements.ElementAccordion');

Phlexible.elements.ElementAccordion.prototype.populateItems = Ext.createSequence(
    Phlexible.elements.ElementAccordion.prototype.populateItems,
    function() {
        alert("test");
    }
);
