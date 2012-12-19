Ext.define('MG.view.mantenimiento.unidadmedida.WinUnidadMedidaNuevo', {
    extend: 'Ext.window.Window',
    alias : 'widget.winunidadmedidanuevo',
    title: 'Unidades de Medida',
    layout: 'fit',
    resizable: false,
    border: false,
    modal: true,
    initComponent: function() {
        this.items = [{
            xtype: 'form',
            frame: true,
            defaults: {
                width: 300,
                xtype: 'textfield',
                labelWidth: 70,
                allowBlank: false
            },
            items: [{
                xtype: 'hiddenfield',
                name: 'id',
                allowBlank: true
            },{
                name: 'no_unidad',
                fieldLabel: 'Unidad'
            },{
                name: 'no_sub_unidad',
                fieldLabel: 'Sub Unidad'
            },{
                xtype: 'numberfield',
                name: 'ca_sub_unidad',
                fieldLabel: 'Cantidad',
                allowDecimals: false,
                allowNegative: false,
                minValue: 1,
                hideTrigger: true,
                keyNavEnabled: false,
                mouseWheelEnabled: false
            }]
        }],
        this.buttons = [{
                name: 'btnCrear',
                text : 'Grabar',
                iconCls: 'ico-aceptar',
                scale: 'medium'
            },{
                name: 'btnEditar',
                text : 'Editar',
                iconCls: 'ico-aceptar',
                scale: 'medium'
            },{
                text : 'Cancelar',
                scope : this,
                iconCls: 'ico-cancelar',
                scale: 'medium',
                handler: this.close
            }]
        this.callParent(arguments);
    }
});