Ext.define('MG.model.Imagen', {
    extend: 'Ext.data.Model',
    fields: [{
        name: 'src', 
        type: 'string'
    }, {
        name: 'caption', 
        type: 'string'
    }, {
        name: 'action', 
        type: 'string'
    }]
});