Ext.define('rewsoft.view.compras.ocompra.PnlOrdenCompra', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.pnlordencompra',
    border: false,
    layout: 'border',
    initComponent: function() {
        this.items = [{
            region: 'center',
            layout: 'border',
            flex: 1,
            border: false,
            items: [{
                region: 'north',
                frame: true,
                border: false,
                defaults: {
                    frame: true,
                    style: 'border: 0px none; margin: 0; padding: 0;',
                    defaults:{
                        margins:'0 5 5 0'
                    }
                },
                items: [{
                    layout: {
                        type: 'hbox',
                        align: 'stretch'
                    },
                    items:[{
                        xtype: "textfield",
                        name: "txtNuDocumento",
                        fieldLabel: 'O. COMPRA',
                        labelWidth: 100,
                        style: 'color: red; font-size: 15px;',
                        value: '001-0000101',
                        border: false,
                        readOnly: true,
                        width: 200
                    },{
                        xtype: "datefield",
                        name: "txtFecha",
                        fieldLabel: 'FECHA',
                        format: 'd/m/Y',
                        value: new Date(),
                        labelWidth: 50,
                        style: 'color: red; font-size: 15px;',
                        border: false,
                        readOnly: true,
                        width: 140
                    },{
                        xtype: "textfield",
                        name: "txtBuscarRequerimiento",
                        fieldLabel: "O. Requerimiento",
                        labelWidth: 100,
                        style: 'color: red; font-size: 15px;',
                        readOnly: true,
                        width: 250
                    },{
                        xtype: 'button',
                        name: 'btnBuscarRequerimiento',
                        text: 'Buscar',
                        iconCls: 'ico-buscar-small'
                    }]
                }]
            },{
                region: 'center',
                xtype: 'grid',
                name: 'gridPedido',
                store: 'IngresoProductos',
                columns: [{
                    header: 'Codigo',    
                    dataIndex: 'co_producto',
                    menuDisabled: true,
                    sortable: false,
                    width: 70
                },{
                    header: 'Producto',
                    dataIndex: 'no_producto',
                    menuDisabled: true,
                    sortable: false,
                    flex: 1
                },{
                    header: 'Cantidad',
                    dataIndex: 'ca_producto',
                    menuDisabled: true,
                    sortable: false,
                    width: 70,
                    align: 'right'
                },{
                    header: 'Medida',
                    dataIndex: 'no_unidad',
                    menuDisabled: true,
                    sortable: false,
                    width: 80
                },{
                    header: 'Valor',
                    dataIndex: 'va_compra',
                    menuDisabled: true,
                    sortable: false,
                    width: 70,
                    align: 'right',
                    renderer: function(val){
                        return Ext.util.Format.number(val, rewsoft.AppGlobals.FORMA_NUMBER);
                    }
                },{
                    header: 'Total',
                    dataIndex: 'va_compra_total',
                    menuDisabled: true,
                    sortable: false,
                    width: 70,
                    align: 'right',
                    renderer: function(val){
                        return Ext.util.Format.number(val, rewsoft.AppGlobals.FORMA_NUMBER);
                    }
                },{
                    header: 'Proveedor',
                    dataIndex: 'no_proveedor',
                    menuDisabled: true,
                    sortable: false,
                    width: 250
                },{
                    xtype: 'actioncolumn',
                    name: 'actionRemover',
                    width: 20,
                    menuDisabled: true,
                    items: [{
                        icon: 'resources/images/remove.gif',
                        tooltip: 'Remover',
                        iconCls: 'mousepointer'
                    }]
                }],
                dockedItems: [{
                    xtype: 'fieldcontainer',
                    dock: 'bottom',
                    layout: 'hbox',
                    items: [{
                        xtype: 'label',
                        name: 'totalProductos',
                        text: 'Productos: 0',
                        baseCls: 'etiqueta'
                    },{
                        xtype: 'tbfill'
                    },{
                        xtype: 'button',
                        text: 'Limpiar todo',
                        name: 'btnLimpiarTodo',
                        iconCls: 'ico-medium',
                        scale: 'medium'
                    },{
                        xtype: 'button',
                        text: 'Procesar Orden',
                        name: 'btnProcesar',
                        iconCls: 'ico-medium',
                        scale: 'medium'
                    }]
                    
                }]
            }]
        },{
            region: 'east',
            title: 'Buscar Producto',
            width: 400,
            layout: 'border',
            border: false,
            collapsible: true,
            //collapsed: true,
            split: true,
            items: [{
                region: 'center',
                xtype: 'grid',
                name: 'gridProductos',
                store: 'Productos',
                columns: [{
                    header: 'Producto',
                    dataIndex: 'no_producto',
                    menuDisabled: true,
                    flex: 1
                },{
                    header: 'Marca',
                    dataIndex: 'no_sub_categoria',
                    menuDisabled: true,
                    width: 100
                }],
                dockedItems: [{
                    xtype: 'toolbar',
                    border: false,
                    dock: 'top',
                    items: [{
                        xtype: 'textfield',
                        name: 'txtBuscar',
                        enableKeyEvents: true,
                        flex: 1
                    }]
                }]
            }]
        }],
        this.callParent(arguments);
    }      
});