class BootstrapAjaxTable 
{
    static fnBuild(sID)
    {
        var oOptions = window.oTables[sID];

        window.oTablesElements || (window.oTablesElements = {});
        window.oTablesElements[sID] = new BootstrapAjaxTable(sID, oOptions);
    }

    constructor(sID, oOptions)
    {
        var oThis = this;

        oThis.sID = sID;
        oThis.sSelTable = `#${sID}`;
        oThis.oOptions = oOptions;
        oThis.oAttrs = {};
        oThis.sIndexField;
        oThis.aSelections = [];
        oThis.aColumns = [];

        oThis.$oTable;
        oThis.$oRemove;

        oThis.fnBindEvents();
    }

    fnGetDefaultAttrs()
    {
        return {
            "data-search": "true",
            "data-show-refresh": "true",
            "data-show-toggle": "true",
            "data-show-fullscreen": "true",
            "data-show-columns": "true",
            "data-show-columns-toggle-all": "true",
            "data-detail-view": "true",
            "data-show-export": "true",
            "data-click-to-select": "true",
            "data-minimum-count-columns": "2",
            "data-show-pagination-switch": "true",
            "data-pagination": "true",
            "data-id-field": "id",
            "data-page-list": "[10, 25, 50, 100, all]",
            "data-show-footer": "true",
            "data-side-pagination": "server",
            "data-url": "",
            "data-filter-control": "true",
            "data-detail-formatter": this.detailFormatter,
            "data-response-handler": this.responseHandler,
        }
    }

    fnGetURL_GetTableInfo_JSON()
    {
        return this.oOptions.aURLs['gettableinfo_json'];
    }

    fnGetURL_ListWithPagination_JSON()
    {
        return this.oOptions.aURLs['listwithpagination_json'];
    }

    fnGetURL_Update_JSON(oData={})
    {
        return this.oOptions.aURLs['update_json'];
    }

    fnGetURL_Delete_JSON(iID)
    {
        return this.oOptions.aURLs['delete_json'];
    }

    fnPrepareAttr()
    {
        var oThis = this;
        oThis.oAttrs = {
            ...oThis.fnGetDefaultAttrs(),
            ...{
                "data-url": oThis.fnGetURL_ListWithPagination_JSON()
            },
            ...oThis.oOptions.aAttrs
        }
    }

    fnPrepareColumns(aColumns)
    {
        var oThis = this;

        oThis.aColumns= [
            {
                field: 'state',
                checkbox: true,
                align: 'center',
                valign: 'middle'
            }
        ]
        oThis.aColumns = oThis.aColumns.concat(aColumns);
        oThis.aColumns = oThis.aColumns.concat([
            {
                field: 'operate',
                title: 'Операции',
                align: 'center',
                clickToSelect: false,
                class: "actions",
                events: oThis.operateEvents,
                formatter: oThis.operateFormatter
            }
        ]);
    }

    fnBindEvents()
    {
        var oThis = this;

        oThis.operateEvents = {
            [`click .edit`]: (e, value, row, index) => {
                window.open(oThis.fnGetURL_Update_JSON());
            },
            [`click .remove`]: (e, value, row, index) => {
                $.post(oThis.fnGetURL_Delete_JSON())
            }
        }

        $(document).ready(() => {
            oThis.$oTable = $(oThis.sSelTable);
            oThis.fnPrepareAttr();
            oThis.$oTable.attr(oThis.oAttrs);
            oThis.$oRemove = $('#remove')

            $.post(oThis.fnGetURL_GetTableInfo_JSON(), { dataType: 'json' })
                .done((oResponse) => {
                    oThis.sIndexField = oResponse.sIndexField;
                    oThis.fnPrepareColumns(oResponse.aColumns);
                    oThis.fnInit();
                })
            
        })
    }

    getIdSelections() {
        var oThis = this;
        return $.map(oThis.$oTable.bootstrapTable('getSelections'), (row) => {
            return row[oThis.sIndexField]
        })
    }

    responseHandler(res) {
        var oThis = this;
        $.each(res.rows, (i, row) => {
            row.state = $.inArray(row[oThis.sIndexField], oThis.aSelections) !== -1
        })
        return res
    }

    detailFormatter(index, row) {
        var oThis = this;
        var html = []
        $.each(row, (key, value) => {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>')
        })
        return html.join('')
    }

    operateFormatter(value, row, index) {
        return `
        <a class="edit" href="javascript:void(0)" title="Edit">
            <i class="bi bi-pencil-square"></i>
        </a>
        <a class="remove" href="javascript:void(0)" title="Remove">
            <i class="bi bi-trash"></i>
        </a>
        `
    }

    totalTextFormatter(data) {
        return 'Total'
    }

    totalNameFormatter(data) {
        return data.length
    }

    totalPriceFormatter(data) {
        var oThis = this;
        var field = oThis.field
            return '$' + data.map((row) => {
            return +row[field].substring(1)
        }).reduce((sum, i) => {
            return sum + i
        }, 0)
    }

    fnInit() 
    {
        var oThis = this;
        console.log('initTable');

        oThis.$oTable.bootstrapTable('destroy').bootstrapTable({
            height: "900",
            columns: oThis.aColumns
        })

        oThis.$oTable.on(
            'check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table',
            () => {
                oThis.$oRemove.prop('disabled', !oThis.$oTable.bootstrapTable('getSelections').length)
                oThis.aSelections = oThis.getIdSelections()
            }
        )

        oThis.$oTable.on('all.bs.table', (e, name, args) => {
            
        })
    }
}