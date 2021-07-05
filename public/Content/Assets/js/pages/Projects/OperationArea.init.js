//$(function () {

//    var url = $('.urlParser').data('request-url');

//    $('.js-basic-example').DataTable({
//        processing: true,
//        serverSide: false,
//        ajax: {
//            url: url,
//            headers: { "X-CSRFToken": csrftoken },
//            type: "GET",
//            data: { search_text: search_text },
//            dataType: "json",
//            mode: 'same-origin',
//            dataSrc: "results",
//        },
//        destroy: true,
//        searching: true,
//        lengthChange: false,
//        info: true,
//        paging: true,
//        deferLoading: 57,
//        language: {
//            sEmptyTable: "ไม่มีข้อมูล",
//            sInfo: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
//            sInfoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
//            sInfoFiltered: "(กรองข้อมูล _MAX_ ทุกรายการ)",
//            sInfoPostFix: "",
//            sInfoThousands: ",",
//            sLengthMenu: "แสดง _MENU_ รายการ",
//            sLoadingRecords: "<i class=\"zmdi zmdi-rotate-right zmdi-hc-5x zmdi-hc-spin\"></i><span class=\"sr-only\">กำลังโหลดข้อมูล...</span>",
//            sProcessing: "กำลังดำเนินการ...",
//            sSearch: "ค้นหา: ",
//            sZeroRecords: "ไม่มีข้อมูล",
//            oPaginate: {
//                sFirst: "หน้าแรก",
//                sPrevious: "ก่อนหน้า",
//                sNext: "ถัดไป",
//                sLast: "หน้าสุดท้าย"
//            },
//            oAria: {
//                sSortAscending: ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
//                sSortDescending: ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
//            }
//        },
//        columns: [
//            { data: "" },
//            { data: "collection_name" },
//            //{ data: "document_no" },
//            { data: "document_name" },
//            { data: "drawing_no" },
//            { data: "title" },
//            { data: "drawing_type" },
//            { data: "updated_date" }
//        ],
//        columnDefs: [
//            {
//                targets: [0],
//                searchable: false,
//                orderable: true,
//                render: function (data, type, row, meta) {
//                    return meta.row + 1;
//                }
//            },
//            {
//                targets: [1],
//                render: function (data, type, row, meta) {

//                    //http://localhost:8181/asbuilt/collection/item-2/
//                    return "<a href=\"/asbuilt/collection/item-" + row.collection_id + "/\"> <span class=\"badge badge-info\"><i class=\"zmdi zmdi-collection-folder-image m-r-10\"></i>" + data + "</span></a>";
//                }
//            },
//            {
//                targets: [2, 3, 4],
//                render: function (data, type, row, meta) {
//                    return "<a href=\"/asbuilt/documents/" + row.object_id + "/\">" + data + "</a>";
//                }
//            },
//            //{ visible: false, targets: [1] },
//        ],
//        //drawCallback: function (settings) {
//        //    var api = this.api();
//        //    var rows = api.rows({ page: 'current' }).nodes();
//        //    var last = null;

//        //    api.column(1, { page: 'current' }).data().each(function (group, i) {
//        //        if (last !== group) {
//        //            $(rows).eq(i).before(
//        //                '<tr class="group"><td colspan="7">' + group + '</td></tr>'
//        //            );

//        //            last = group;
//        //        }
//        //    });
//        //}
//    });

//    //Exportable table
//    $('.js-exportable').DataTable({
//        dom: 'Bfrtip',
//        buttons: [
//            'copy', 'csv', 'excel', 'pdf', 'print'
//        ]
//    });
//});

!function ($) {
    "use strict";

    var operationArea = function () { };

    operationArea.prototype.popModalDialog = function (title, key, relate_key = null) {

        $('.modal-title').html("<strong>จัดการข้อมูล " + title + " </strong>");

        var filter_key = null;
        var filter_value = null;


        if (key == "payload-contract") {
            $('#dvParentGroup').show();
        } else {
            $('#dvParentGroup').hide();
        }

        if (relate_key != null) {
            switch (relate_key) {
                case "payload-sector":
                    filter_key = "sector_id";
                    filter_value = $('#' + relate_key + ' option:selected').val();

                    $.CollectionMngmt.bindSelect('parent-group', '/api/Sector/', 'Sector', filter_value);

                    break;
                default:
                    break;
            }

        }

        $.each(api_list, function (idx, item) {
            if (item.Key == key) {
                $.CollectionMngmt.bindDatatable('#tblDataList', key, item.api, filter_key, filter_value);
                $('#btnAddData').prop("onclick", null).off("click");
                $('#btnAddData').click(function () {
                    var value = $('#txtTitle').val();
                    var id = $('#hdId').val();

                    if (value == "") {
                        Swal.fire({
                            title: 'กรุณาระบุชื่อ ' + title,
                            text: "ต้องมีการกำหนดชื่อ " + title,
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ตกลง',
                            cancelButtonText: "ยกเลิก",
                            allowOutsideClick: false
                        });

                        return;
                    }

                    var json_data = {};

                    if (item.Key == "payload-contract") {

                        if ($('#parent-group option:selected').val() == "") {
                            Swal.fire({
                                title: "กรุณาเลือกรายการ Sector",
                                text: 'รายการ Sector ยังไม่ถูกเลือก',
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ตกลง',
                                cancelButtonText: "ยกเลิก",
                                allowOutsideClick: false
                            });

                            return;
                        }
                        if (id) {
                            json_data = {
                                "id": id,
                                "name": value,
                                "sector": $('#parent-group option:selected').val()
                            }
                        } else {
                            json_data = {
                                "name": value,
                                "sector": $('#parent-group option:selected').val()
                            }
                        }
                    } else {
                        if (id) {
                            json_data = {
                                "id": id,
                                "name": value,
                            }
                        } else {
                            json_data = {
                                "name": value,
                            }
                        }

                    }

                    if (id) {
                        $.CollectionMngmt.updateItem(item.api + id + '/', json_data, true);
                    } else {
                        $.CollectionMngmt.updateItem(item.api, json_data);
                    }


                });

                return;
            }
        });


        $('#divMasterData').modal({
            backdrop: 'static'
        });
    }


    operationArea.prototype.init = function () {

        var markerApi = $('.urlMarkerApiParser').data('request-url');
        //urlIconParser
        var iconUrl = $('.urlIconParser').data('request-url');
        //Init page 
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([100, 13]),
                zoom: 5
            })
        });

        var vectorLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
                url: markerApi,
                format: new ol.format.GeoJSON(),
            }),
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 46],
                    anchorXUnits: "fraction",
                    anchorYUnits: "pixels",
                    src: iconUrl,
                }),
            }),
        });
        map.addLayer(vectorLayer);
        var element = document.getElementById("popup");

        var popup = new ol.Overlay({
            element: element,
            positioning: "bottom-center",
            stopEvent: false,
        });

        map.addOverlay(popup);
        map.on("click", function (evt) {
            if ($(element)) {
                $(element).popover("dispose");
            }
            var feature = map.forEachFeatureAtPixel(map.getEventPixel(evt.originalEvent), function (feature) {
                return feature;
            });
            if (feature) {
                popup.setPosition(evt.coordinate);
                $(element).popover({
                    placement: "top",
                    html: true,
                    content: feature.get("id"),
                });
                $(element).popover("show");
            } else {
                $(element).popover("dispose");
            }
        });
        map.on("movestart", function (e) {
            if ($(element)) {
                $(element).popover("dispose");
            }
        });

    };

    //init
    $.operationArea = new operationArea, $.operationArea.Constructor = operationArea
}(window.jQuery),

    //initializing
    function ($) {
        "use strict";

        $.operationArea.init();


    }(window.jQuery);