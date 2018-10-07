$(document).ready(function() {
    "use strict";
    var e = {
        chart: {
            type: "line",
            width: 80,
            height: 35,
            sparkline: {
                enabled: !0
            }
        },
        series: [],
        stroke: {
            width: 2,
            curve: "smooth"
        },
        markers: {
            size: 0
        },
        colors: ["#727cf5"],
        tooltip: {
            fixed: {
                enabled: !1
            },
            x: {
                show: !1
            },
            y: {
                title: {
                    formatter: function(e) {
                        return ""
                    }
                }
            },
            marker: {
                show: !1
            }
        }
    };
    $("#products-datatable").DataTable({
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            info: "Mostrando usuarios _START_ a _END_ de _TOTAL_",
            lengthMenu: 'Mostrar <select class=\'custom-select custom-select-sm ml-1 mr-1\'><option value="5">5</option><option value="20">20</option><option value="-1">Todos</option></select> usuarios'
        },
        pageLength: 5,
        columns: [{
            orderable: !1,
            render: function(e, t, o, l) {
                return "display" === t && (e = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes"><label class="custom-control-label">&nbsp;</label></div>'), e
            },
            checkboxes: {
                selectRow: !0,
                selectAllRender: '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes"><label class="custom-control-label">&nbsp;</label></div>'
            }
        }, {
            orderable: !0
        }, {
            orderable: !0
        }, {
            orderable: !0
        }, {
            orderable: !1
        }, {
            orderable: !1
        }],
        select: {
            style: "multi"
        },
        // order: [
        //     [4, "desc"]
        // ],
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(".spark-chart").each(function(t) {
                var o = $(this).data().dataset;
                e.series = [{
                    data: o
                }], new ApexCharts($(this)[0], e).render()
            })
        }
    })
});