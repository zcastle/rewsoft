Ext.define('MG.store.IngresoProductos', {
    extend: 'Ext.data.Store',
    model: 'MG.model.IngresoProductos',
    /*proxy: {
        type: 'ajax',
        url: 'data/pedidos.json',
        api:{
            read: 'data/pedidos.json'
        },
        reader: {
            type: 'json',
            root: 'pedido',
            successProperty: 'success'
        },
        actionMethods: {
            read: 'POST'
        },
        simpleSortMode: true
    }*/
    data: []
});