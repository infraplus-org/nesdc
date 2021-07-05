
!function ($) {
    "use strict";
    var projectController = function () { }

    projectController.prototype.formAddProjectDetails = function () {

        $('#divAddProjectDetails').modal({
            backdrop: 'static'
        });
    }

    projectController.prototype.projectList = function () {
        $(function () {
            var url = $('.urlParser').data('request-url');

            $('.js-exportable').DataTable({
                processing: true,
                serverSide: false,
                //ajax: {
                //    url: url,
                //    //headers: { "X-CSRFToken": csrftoken },
                //    type: "GET",
                //    //data: { search_text: search_text },
                //    dataType: "json",
                //    mode: 'same-origin',
                //    dataSrc: "",
                //},
                destroy: true,
                searching: true,
                lengthChange: false,
                info: true,
                paging: true,
                deferLoading: 57,
                language: {
                    sEmptyTable: "ไม่มีข้อมูล",
                    sInfo: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    sInfoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
                    sInfoFiltered: "(กรองข้อมูล _MAX_ ทุกรายการ)",
                    sInfoPostFix: "",
                    sInfoThousands: ",",
                    sLengthMenu: "แสดง _MENU_ รายการ",
                    sLoadingRecords: "<i class=\"zmdi zmdi-rotate-right zmdi-hc-5x zmdi-hc-spin\"></i><span class=\"sr-only\">กำลังโหลดข้อมูล...</span>",
                    sProcessing: "กำลังดำเนินการ...",
                    sSearch: "ค้นหา: ",
                    sZeroRecords: "ไม่มีข้อมูล",
                    oPaginate: {
                        sFirst: "หน้าแรก",
                        sPrevious: "ก่อนหน้า",
                        sNext: "ถัดไป",
                        sLast: "หน้าสุดท้าย"
                    },
                    oAria: {
                        sSortAscending: ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
                        sSortDescending: ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
                    }
                },
                //columns: [
                //    { data: "" },
                //    { data: "collection_name" },
                //    //{ data: "document_no" },
                //    { data: "document_name" },
                //    { data: "drawing_no" },
                //    { data: "title" },
                //    { data: "drawing_type" },
                //    { data: "updated_date" }
                //],
                columnDefs: [
                    {
                        targets: [0],
                        searchable: false,
                        orderable: true,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    //{
                    //    targets: [1],
                    //    render: function (data, type, row, meta) {

                    //        //http://localhost:8181/asbuilt/collection/item-2/
                    //        return "<a href=\"/asbuilt/collection/item-" + row.collection_id + "/\"> <span class=\"badge badge-info\"><i class=\"zmdi zmdi-collection-folder-image m-r-10\"></i>" + data + "</span></a>";
                    //    }
                    //},
                    //{
                    //    targets: [2, 3, 4],
                    //    render: function (data, type, row, meta) {
                    //        return "<a href=\"/asbuilt/documents/" + row.object_id + "/\">" + data + "</a>";
                    //    }
                    //},
                    //{ visible: false, targets: [1] },
                ],
                //drawCallback: function (settings) {
                //    var api = this.api();
                //    var rows = api.rows({ page: 'current' }).nodes();
                //    var last = null;

                //    api.column(1, { page: 'current' }).data().each(function (group, i) {
                //        if (last !== group) {
                //            $(rows).eq(i).before(
                //                '<tr class="group"><td colspan="7">' + group + '</td></tr>'
                //            );

                //            last = group;
                //        }
                //    });
                //}
            });

            //Exportable table
            //$('.js-exportable').DataTable({
            //    dom: 'Bfrtip',
            //    buttons: [
            //        'copy', 'csv', 'excel', 'pdf', 'print'
            //    ]
            //});
        });

    }

    projectController.prototype.init = function () {

    }

    //init
    $.projectController = new projectController, $.projectController.Constructor = projectController

}(window.jQuery),

    //initializing
    function ($) {
        "use strict";

    $.projectController.init();
    $.projectController.projectList();


    }(window.jQuery);