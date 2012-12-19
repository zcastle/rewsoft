Ext.define('MG.view.ventas.WinCantidad', {
    extend: 'Ext.Window',
    alias: 'widget.winventascantidad',
    title: 'Ingreso de Cantidad',
    width: 400,
    modal: true,
    resizable: false,
    initComponent: function() {
        this.items = [{
            xtype: 'hidden',
            name: 'txtCodigo'
        },{
            xtype: 'label',
            name: 'lblProducto',
            baseCls: 'titulo-producto',
            text: 'Nombre Producto'
        },{
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            frame: true,
            style: 'border: 0px none; margin: 0; padding: 0;',
            items:[{
                xtype: 'numberfield',
                style: 'margin-top: 5px;',
                name: 'txtCantidad',
                fieldLabel: 'Cantidad',
                allowDecimals: false,
                allowNegative: false,
                allowBlank: false,
                minValue: 1,
                enableKeyEvents: true,
                hideTrigger: true,
                keyNavEnabled: false,
                mouseWheelEnabled: false,
                labelWidth: 55,
                width: 160,
                value: 1,
                margins: '0 0 0 5'
            },{
                xtype: 'textfield',
                name: 'txtCosto',
                style: 'margin-top: 5px;',
                fieldLabel: 'Valor Compra S/.',
                labelWidth: 100,
                flex: 1,
                readOnly: true,
                margins: '0 5 0 5'
            }]
        },{
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            frame: true,
            style: 'border: 0px none; margin: 0; padding: 0;',
            items:[{
                xtype: 'numberfield',
                name: 'txtPrecio',
                style: 'margin-top: 5px;',
                fieldLabel: 'Precio S/.',
                allowNegative: false,
                allowBlank: false,
                allowDecimals: true,
                decimalPrecision: 4,
                minValue: 0,
                enableKeyEvents: true,
                hideTrigger: true,
                keyNavEnabled: false,
                mouseWheelEnabled: false,
                labelWidth: 55,
                width: 160,
                margins: '0 0 0 5'
            },{
                xtype: "combobox",
                style: 'margin-top: 5px;',
                name: "cboUnidadVenta", 
                fieldLabel: "Unidad de Venta",
                store: 'UnidadesVentaByProducto',
                valueField: 'id',
                displayField: 'no_unidad',
                queryMode: 'local',
                editable: false,
                labelWidth: 100,
                flex: 1,
                margins: '0 5 0 5'
            }]
        },{
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            frame: true,
            style: 'border: 0px none; margin: 0; padding: 0;',
            items:[{
                xtype: 'grid',
                width: 200,
                name: 'gridPrecioCaja',
                height: 80,
                store: 'PrecioCaja',
                margins: '5 0 0 0',
                columns: [{
                    header: 'Medida',
                    dataIndex: 'no_medida',
                    menuDisabled: true,
                    sortable: false,
                    width: 100
                },{
                    header: 'Precio',
                    dataIndex: 'va_precio',
                    menuDisabled: true,
                    sortable: false,
                    align: 'right',
                    flex: 1,
                    renderer: function(val){
                        return Ext.util.Format.number(val, "0,000.0000");
                    }
                }]
            },{
                xtype: 'grid',
                name: 'gridPrecios',
                height: 80,
                width: 190,
                store: 'Precio',
                margins: '5 0 0 0',
                columns: [{
                    header: '%',
                    dataIndex: 'va_per',
                    menuDisabled: true,
                    sortable: false,
                    width: 40
                },{
                    header: 'Precio',
                    dataIndex: 'va_precio',
                    menuDisabled: true,
                    sortable: false,
                    align: 'right',
                    flex: 1,
                    renderer: function(val){
                        return Ext.util.Format.number(val, "0,000.0000");
                    }
                }]
            }]
        },{
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            frame: true,
            style: 'border: 0px none; margin: 0; padding: 0;',
            items:[{
                xtype: 'textfield',
                name: 'txtLote',
                style: 'margin-top: 5px;',
                fieldLabel: 'Lote',
                allowNegative: false,
                allowBlank: false,
                minValue: 1,
                enableKeyEvents: true,
                labelWidth: 55,
                width: 170,
                readOnly: true
            },{
                xtype: 'textfield',
                name: 'txtVencimiento',
                style: 'margin-top: 5px;',
                fieldLabel: 'Vencimiento',
                allowNegative: false,
                allowBlank: false,
                minValue: 1,
                enableKeyEvents: true,
                labelWidth: 70,
                width: 170,
                readOnly: true,
                margins: '0 0 0 5'
            },{
                xtype: 'textfield',
                name: 'txtStockLote',
                readOnly: true,
                hidden: true
            }]
        },{
            xtype: 'grid',
            name: 'gridLotes',
            height: 100,
            store: 'Lotes',
            margins: '5 0 0 0',
            columns: [{
                header: 'Lote',
                dataIndex: 'no_lote',
                menuDisabled: true,
                sortable: false,
                width: 150
            },{
                header: 'Vencimiento',
                dataIndex: 'fe_vencimiento',
                menuDisabled: true,
                sortable: false,
                width: 80
            },{
                header: 'Stock',
                dataIndex: 'ca_stock',
                menuDisabled: true,
                sortable: false,
                width: 50
            }]
        },{
            xtype: "textfield",
            name: "txtCliente", 
            fieldLabel: "Cliente",
            style: 'margin-top: 5px;',
            labelWidth: 40,
            readOnly: true,
            width: 387
        },{
            xtype: 'grid',
            name: 'gridHistorialPedido',
            height: 150,
            store: 'HistorialCompraProductos',
            columns: [{
                header: 'Fecha',
                dataIndex: 'fecha',
                menuDisabled: true,
                sortable: false,
                width: 80
            },{
                header: 'No. Documento',
                dataIndex: 'nudocumento',
                menuDisabled: true,
                sortable: false,
                flex: 1
            },{
                header: 'Cantidad',
                dataIndex: 'cantidad',
                menuDisabled: true,
                sortable: false,
                align: 'right',
                width: 55
            },{
                header: 'Precio',
                dataIndex: 'precio',
                menuDisabled: true,
                sortable: false,
                width: 100,
                align: 'right',
                renderer: function(val){
                    return Ext.util.Format.number(val, "0,000.0000");
                }
            }],
            bbar: Ext.create('Ext.PagingToolbar', {
                store: 'HistorialCompraProductos',
                displayInfo: true,
                displayMsg: 'Mostrando historial {0} - {1} de {2}',
                emptyMsg: "No hay historial para mostrar"
            })
        }],
        this.buttons = [{
            name: 'btnAceptar',
            text: 'Aceptar'
        },{
            text: 'Cancelar',
            scope: this,
            handler: this.close
        }]
        this.callParent(arguments);
    }      
});