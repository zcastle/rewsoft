Ext.define('rewsoft.controller.mantenimiento.categorias.PnlCategorias', {
    extend: 'Ext.app.Controller',
    views: [
    'mantenimiento.categoria.PnlCategorias'
    ],
    refs: [{
        ref: 'MainView',
        selector: 'pnlcategorias'
    }],
    stores: [
    'Categorias',
    'Grupo'
    ],
    init: function() {
        this.control({
            'pnlcategorias': {
                render: this.onRenderedPnlCategorias,
                itemdblclick: this.onItemDblClickPnlCategorias,
                cellclick: this.onCellClickPnlCategorias
            },
            'pnlcategorias button[name=btnNuevo]': {
                click: this.onClickBtnNuevo
            },
            'pnlcategorias textfield[name=txtBuscar]': {
                keypress: this.onKeyPressTxtBuscar,
                keyup: this.onKeyUpTxtBuscar
            }
        });
    },
    onRenderedPnlCategorias: function(grid) {
        this.getCategoriasStore().proxy.extraParams.co_empresa = rewsoft.AppGlobals.CIA;
        this.getCategoriasStore().proxy.extraParams.no_categoria = '';
        this.getCategoriasStore().proxy.extraParams.co_grupo = '';
        this.getCategoriasStore().load();
    },
    onItemDblClickPnlCategorias: function(Grid, record){
        var view = Ext.widget('wincategoriasnuevo');
        view.down('form').loadRecord(record);
        view.down('button[name=btnCrear]').hide();
        view.down('button[name=btnEditar]').show();
        view.show();
    },
    onCellClickPnlCategorias: function(grid, td, columnIndex, record, tr, rowIndex, e, opt){
        var columna = grid.up('grid').columns[columnIndex].name;
        var categoria = record.get('no_categoria');
        if(columna == 'actionEditar') {
            var view = Ext.widget('wincategoriasnuevo');
            view.down('form').loadRecord(record);
            view.down('button[name=btnCrear]').hide();
            view.down('button[name=btnEditar]').show();
            view.show();
        } else if(columna == 'actionRemover') {
            Ext.Msg.confirm('Confirmacion', 'Estas seguro de querer remover la categoria: ' + categoria + '?', function(btn){
                if(btn=='yes'){
                    grid.getStore().remove(record);
                    grid.getStore().sync();
                }
            }, this);
        }
    },
    onClickBtnNuevo: function(btn){
        var view = Ext.widget('wincategoriasnuevo');
        view.down('button[name=btnEditar]').hide();
        view.show();
    },
    onKeyPressTxtBuscar: function(text, key){
        if(key.getKey() == key.ENTER){
            this.getCategoriasStore().proxy.extraParams.no_categoria = text.getValue();
            this.getCategoriasStore().loadPage(1);
        }
    },
    onKeyUpTxtBuscar: function(text, key) {
        if((key.getKey() == key.BACKSPACE || key.getKey() == key.DELETE) && text.getValue().length == 0){
            this.getCategoriasStore().proxy.extraParams.no_categoria = '';
            this.getCategoriasStore().loadPage(1);
        }
    },
});
