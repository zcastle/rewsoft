Ext.define('rewsoft.store.DocumentosAlmacen', {
    extend: 'Ext.data.Store',
    model: 'rewsoft.model.Documento',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        api:{
            read: 'data/readDocumentos.php'
        },
        reader: {
            type: 'json',
            root: 'documentos'
        },
        actionMethods: {
            read: 'POST'
        }
    }
});