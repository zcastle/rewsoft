Ext.define('rewsoft.store.AlmacenTranslado', {
    extend: 'Ext.data.Store',
    model: 'rewsoft.model.Almacen',
    proxy: {
        type: 'ajax',
        url: 'data/readAlmacen.php',
        reader: {
            type: 'json',
            root: 'almacen'
        },
        actionMethods: {
            read: 'POST'
        },
        extraParams: {
            co_empresa: '',
            co_producto: ''
        }
    }
});