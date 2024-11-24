/*Copyright (c) 2022, Mypcot Infotech (https://www.mypcot.com/) */
// window.location.reload();

// added by Ritesh : start
function addLoading() {
    $(".card-content").append(
        '<div class="overlay">' +
            '<i class="fa fa-refresh fa-spin"></i>' +
            "</div>"
    );
}

function removeLoading() {
    $(".overlay").remove();
}

//added by Ritesh : end

$("#dropdownBasic3").on("click", function () {
    if ($(".dropdownBasic3Content").hasClass("show")) {
        $(".dropdownBasic3Content").removeClass("show");
    } else {
        $(".dropdownBasic3Content").addClass("show");
    }
});
$(document).ready(function () {
    $(".select2").select2();
    $(".js-example-placeholder-single").select2({
        placeholder: "Select or Search Clients"
    });
    let left = document.getElementById('left-menu-icon');
    $('#sidebarToggle').on('click',function(){
        if(!$('#sidebar-logo').attr('style')) {
            $('#sidebar-logo').css('width','40px');
            left.classList.remove('ft-arrow-left-circle');
            left.classList.add('ft-arrow-right-circle');
        } else {
            $('#sidebar-logo').removeAttr('style');
            left.classList.add('ft-arrow-left-circle');
            left.classList.remove('ft-arrow-right-circle');
        }
    });
    $("#listing-filter-toggle").on("click", function () {
        $("#listing-filter-data").toggle();
    });
    $("#clear-form-data").on("click", function () {
        $("#listing-filter-data .form-control").val("");
        $("#listing-filter-data .select2").val("").trigger("change");
    });

    // remove alert messages for empty input fields
    $(document).on("keyup", ".required", function (event) {
        $(this).removeClass("border-danger");
    });

    $(document).on("change", ".required", function (event) {
        $(this).removeClass("border-danger");
        $(this)
            .siblings(".select2-container")
            .find(".selection")
            .find(".select2-selection")
            .removeClass("border-danger");
    });

    $(document).on("change", "#approval_status", function () {
        var status = document.getElementById("approval_status").value;
        if (this.value == "rejected") {
            $("#remark").show();
        } else {
            $("#remark").hide();
        }

        // if (this.value == 'accepted') {
        //     $("#gstin_div").show();
        //     $("#gst_certificate_div").show();
        // }
        // else {
        //     $("#gstin_div").hide();
        //     $("#gst_certificate_div").hide();
        // }
    });

    //created by: pradyumn; created on : 9-Aug_2022; uses : To show/hide upload collection image
    $(document).on("change", "#upload_collection_img", function () {
        var status = document.getElementById("upload_collection_img").value;
        if (this.value == 1) {
            $("#upload_collection_img_div").show();
        } else {
            $("#upload_collection_img_div").hide();
        }
    });

    //created by : Pradyumn, created on : 16/08/2022, uses : to get value in attribute type of selected type
    $(document).on("change", "#attribute_value_type", function () {
        var value = document.getElementById("attribute_value_type").value;
        var id = document.getElementById("att_val_id").value;
        $.ajax({
            url: "get_type_dropdown",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                type_data: value,
                att_val_id: id,
            },
            success: function (result) {
                response = JSON.parse(result);
                $("#type_name").empty();
                $("#type_name").append('<option value="">Select</option>');
                var is_val_data = response["data"]["attribute_val_data"];
                for (var j = 0; j < response["data"]["type_data"].length; j++) {
                    if (is_val_data) {
                        var attr_val_data_type =
                            response["data"]["attribute_val_data"]["type"];
                    }
                    var type_id = response["data"]["type_data"][j]["id"];
                    var type_name = response["data"]["type_data"][j]["name"];
                    if (attr_val_data_type == value) {
                        $("#type_name").append(
                            '<option value="' +
                                type_id +
                                '" selected>' +
                                type_name +
                                "</option>"
                        );
                    } else {
                        $("#type_name").append(
                            '<option value="' +
                                type_id +
                                '">' +
                                type_name +
                                "</option>"
                        );
                    }
                }
            },
        });
    });

    // created by : Pradyumn, created on : 16/08/2022, uses : to get color value in attribute value of selected type color
    $(document).on("change", "#attribute_name", function () {
        var value = document.getElementById("attribute_name").value;
        var id = document.getElementById("att_val_id").value;
        $("#toggle_attribute_input").empty();
        $.ajax({
            url: "get_color_attribute",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                attribute_id: value,
                att_val_id: id,
            },
            success: function (result) {
                response = JSON.parse(result);

                if (response["data"]["attribute_value"]) {
                    var values = response["data"]["attribute_value"]["values"];
                } else {
                    var values = "";
                }
                if (response["data"]["attribute_name"]["name"] == "Color") {
                    $("#toggle_attribute_input").append(
                        '<div class="row ml-0 mr-0" id="attribute_color_value">' +
                            '<div class="input-group">' +
                            '<input class="form-control" type="text" value="' +
                            values +
                            '" id="value" name="value"/>' +
                            '<div class="input-group-append">' +
                            '<input type="color" value="' +
                            values +
                            '" id="color_code" name="color_code" style="height: 37px; border-width: 1px 1px 1px 2px; border-color: #bbb;"/>' +
                            "</div><br/>" +
                            "</div>" +
                            "</div>"
                    );
                } else {
                    $("#toggle_attribute_input").append(
                        '<div class="row ml-0 mr-0" id="attribute_normal_value">' +
                            '<input class="form-control" value="' +
                            values +
                            '" type="text" id="value" name="value"><br/>' +
                            "</div>"
                    );
                }
            },
        });
    });

    $(document).on("keyup", "#value", function () {
        var value = document.getElementById("value").value;
        // alert(val)
        document.getElementById("color_code").value = value;
    });

    $(document).on("change", "#color_code", function () {
        //$("#color_value").value(color_code);
        var color_value = $("#color_code").val();
        $("#value").val(color_value);
    });

    setTimeout(function () {
        $(".successAlert").fadeOut("slow");
    }, 1000); // <-- time in milliseconds

    var items = [];
    var html_table_data = "";
    var data_orderable = "";
    var data_searchable = "";
    var bRowStarted = true;
    $("#dataTable thead>tr").each(function () {
        $("th", this).each(function () {
            html_table_data = $(this).attr("id");
            data_orderable = $(this).attr("data-orderable");
            data_searchable = $(this).attr("data-searchable");
            if (html_table_data == "id") {
                items.push({
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                });
            } else {
                if (data_orderable == "true") {
                    if (data_searchable == "true") {
                        items.push({
                            data: html_table_data,
                            orderable: true,
                            searchable: true,
                        });
                    } else {
                        items.push({
                            data: html_table_data,
                            orderable: true,
                            searchable: false,
                        });
                    }
                } else {
                    if (data_searchable == "true") {
                        items.push({
                            data: html_table_data,
                            orderable: false,
                            searchable: true,
                        });
                    } else {
                        items.push({
                            data: html_table_data,
                            orderable: false,
                            searchable: false,
                        });
                    }
                }
            }
        });
    });
    coldata = JSON.stringify(items);
    $(function () {
        var dataTable = $("#dataTable").DataTable({
            processing: true,
            serverSide: true,
            scrollX: false,
            autoWidth: true,
            scrollCollapse: true,
            searching: false,
            ajax: {
                url: $("#dataTable").attr("data-url"),
                type: "POST",
                data: function (d) {
                    d._token = $("meta[name=csrf-token]").attr("content");
                    $("#listing-filter-data .form-control").each(function () {
                        d.search[$(this).attr("id")] = $(this).val();
                    });
                },
            },
            columns: items,
            drawCallback: function (settings) {
                $("#dataTable_filter").addClass("pull-right");
                $("#dataTable_filter input").attr("name", "search_field");
                var elems = Array.prototype.slice.call(
                    document.querySelectorAll(".js-switch")
                );
                elems.forEach(function (html) {
                    var switchery = new Switchery(html, {
                        color: "#11c15b",
                        jackColor: "#fff",
                        size: "small",
                        secondaryColor: "#ff5251",
                    });
                });
            },
            language:{
                paginate: { //added by arjun
                    next: '<strong>&#8811;</strong>', // >
                    previous: '<strong>&#8810;</strong>' // <
                }
            }
        });

        $("#listing-filter-data .form-control").keyup(function () {
            dataTable.draw();
        });

        $("#listing-filter-data select").change(function () {
            dataTable.draw();
        });

        $("#listing-filter-data .date").change(function () {
            dataTable.draw();
        });

        $("#clear-form-data").click(function () {
            dataTable.draw();
        });
    });

    $(document).on("click", ".src_data", function (event) {
        event.preventDefault();
        var page = $(this).attr("href");
        loadViewPage(page);
    });

    $(document).on("click", ".certificate-share", function (event) {
        event.preventDefault();
        var page = $(this).attr("href");
        loadViewPage(page);
    });

    $(document).on("click", ".modal_src_data", function (event) {
        event.preventDefault();
        var page = $(this).attr("href");
        var dataSize = $(this).attr("data-size");
        var dataTitle = $(this).attr("data-title");
        loadViewPageInModal(page, dataSize, dataTitle);
    });
});

function loadViewPageInModal(page_url, dataSize, dataTitle) {
    $.ajax({
        url: page_url,
        async: true,
        success: function (data) {
            bootbox.dialog({
                message: data,
                title: dataTitle,
                size: dataSize,
                buttons: false,
            });

            if (page_url.includes("map_vendor_form")) {
                $("#vendor").select2();
            }
        },
    });
}

function loadViewPage(page_url) {
    $.ajax({
        url: page_url,
        datatype: "application/json",
        contentTypech: "application/json",
        async: true,
        success: function (data) {
            var viewData = data;
            try {
                if (JSON.parse(data)["success"]) {
                    $.activeitNoty({
                        type: "danger",
                        icon: "fa fa-minus",
                        message: JSON.parse(data)["message"],
                        container: "floating",
                        timer: 3000,
                    });
                }
            } catch (e) {
                $(".content-wrapper").html(data);
                //to make generic function: future implementation
                if (document.getElementById("approval_status")) {
                    var status =
                        document.getElementById("approval_status").value;
                    status == "rejected"
                        ? $("#remark").show()
                        : $("#remark").hide();
                    // (status == 'accepted') ? $("#gstin_div").show() : $("#gstin_div").hide();
                    // (status == 'accepted') ? $("#gst_certificate_div").show() : $("#gst_certificate_div").hide();
                }
                if (document.getElementById("upload_collection_img")) {
                    var status = document.getElementById(
                        "upload_collection_img"
                    ).value;
                    status == 1
                        ? $("#upload_collection_img_div").show()
                        : $("#upload_collection_img_div").hide();
                }
            }
        },
    });
}

function submitForm(form_id, form_method, errorOverlay = "") {
    console.log("submitForm function called"); // Log a message when the function is called

    var form = $("#" + form_id);
    console.log("Form element found:", form); // Log the form element

    var formdata = false;
    console.log("Checking for FormData support...");
    if (window.FormData) {
        console.log("FormData is supported.");
        formdata = new FormData(form[0]);
    } else {
        console.log("FormData is not supported.");
    }

    var can = 0;
    console.log("Checking required fields...");
    $("#" + form_id)
        .find(".required")
        .each(function () {
            var here = $(this);
            if (here.val() == "") {
                console.log("Required field is empty:", here);
                here.addClass("border-danger");
                here.siblings(".select2-container")
                    .find(".selection")
                    .find(".select2-selection")
                    .addClass("border-danger");
                can++;
            }
        });

    if (can == 0) {
        console.log("All required fields are filled. Proceeding with form submission...");

        $.ajax({
            url: form.attr("action"),
            type: form_method,
            dataType: "html",
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                console.log("Sending Ajax request...");
                $(".btn-success").attr("disabled", true);
                //addLoading();
            },
            success: function (data) {
                console.log("Ajax request successful. Processing response...");
                $(".btn-success").attr("disabled", false);
                var response = JSON.parse(data);
                if (response["success"] == 0) {
                    console.log("Error response received:", response);
                    $("#region_id").attr("disabled", true);
                    if (errorOverlay) {
                        $(form)
                            .find(".form-error")
                            .html(
                                '<span class="text-danger">*' +
                                    response["message"] +
                                    "</span>"
                            );
                        setTimeout(function () {
                            $(form).find(".form-error").empty();
                        }, 3000);
                    } else {
                        console.log("Displaying error message:", response["message"]);
                        $.activeitNoty({
                            type: "danger",
                            icon: "fa fa-minus",
                            message: response["message"],
                            container: "floating",
                            timer: 3000,
                        });
                    }
                    //removeLoading();
                } else {
                    console.log("Success response received:", response);
                    if (errorOverlay) {
                        $(form)
                            .find(".form-error")
                            .html(
                                '<span class="text-success">' +
                                    response["message"] +
                                    "</span>"
                            );
                    } else {
                        $.activeitNoty({
                            type: "success",
                            icon: "fa fa-check",
                            message: response["message"],
                            container: "floating",
                            timer: 3000,
                        });
                    }
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                    //removeLoading();
                }
            },
            error: function () {
                console.log("Ajax request failed. An error occurred.");
                var errorMsg = "Something is wrong, please try again later.";
                $(".btn-success").attr("disabled", false);
                //removeLoading();
                $.activeitNoty({
                    type: "danger",
                    icon: "fa fa-minus",
                    message: errorMsg,
                    container: "floating",
                    timer: 3000,
                });
            },
        });
    } else {
        console.log("Validation failed. Required fields are empty.");
        $("#region_id").attr("disabled", true);
        var ih = $(".border-danger").last().closest(".tab-pane").attr("id");
        $("#" + ih + "-tab").click();
    }
}

function submitModalForm(form_id, form_method, errorOverlay = "") {
    var form = $("#" + form_id);
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        url: form.attr("action"),
        type: form_method,
        dataType: "html",
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".btn-success").attr("disabled", true);
            //addLoading();
        },
        success: function (data) {
            $(".btn-success").attr("disabled", false);
            var response = JSON.parse(data);
            if (response["success"] == 0) {
                if (errorOverlay) {
                    $(form)
                        .find(".form-error")
                        .html(
                            '<span class="text-danger">*' +
                                response["message"] +
                                "</span>"
                        );
                    setTimeout(function () {
                        $(form).find(".form-error").empty();
                    }, 3000);
                } else {
                    $.activeitNoty({
                        type: "danger",
                        icon: "fa fa-minus",
                        message: response["message"],
                        container: "floating",
                        timer: 3000,
                    });
                }
                //removeLoading();
            } else {
                if (errorOverlay) {
                    $(form)
                        .find(".form-error")
                        .html(
                            '<span class="text-success">' +
                                response["message"] +
                                "</span>"
                        );
                } else {
                    $.activeitNoty({
                        type: "success",
                        icon: "fa fa-check",
                        message: response["message"],
                        container: "floating",
                        timer: 3000,
                    });
                }
                setTimeout(function () {
                    location.reload();
                }, 2000);
                //removeLoading();
            }
        },
        error: function () {
            var errorMsg = "Something is wrong, please try again later.";
            $(".btn-success").attr("disabled", false);
            //removeLoading();
            $(form)
                .find(".form-error")
                .html('<span class="text-danger">*' + errorMsg + "</span>");
            setTimeout(function () {
                $(form).find(".form-error").empty();
            }, 3000);
        },
    });
}

//FOR CkEditor data pass to server - added by sagar - START
function submitEditor(form_id) {
    var content = theEditor.getData();
    var form = $("#" + form_id);
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    formdata.append("editiorData", content);
    $.ajax({
        url: form.attr("action"),
        type: "post",
        dataType: "html",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formdata
            ? formdata
            : form.serialize() + "&editiorData=" + content,
        contentType: false,
        processData: false,
        success: function (data) {
            // console.log(data);

            var response = JSON.parse(data);
            if (response["success"] == 0) {
                $.activeitNoty({
                    type: "danger",
                    icon: "fa fa-minus",
                    message: response["message"],
                    container: "floating",
                    timer: 3000,
                });
            } else {
                $.activeitNoty({
                    type: "success",
                    icon: "fa fa-check",
                    message: response["message"],
                    container: "floating",
                    timer: 3000,
                });
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        },
    });
}
//FOR CkEditor data pass to server - added by sagar - END
$(document).on("click", "#addStock", function (event) {
    var trlen = $("#batchTbl tbody tr").length;
    if (trlen == 0) {
        var i = trlen;
    } else {
        var i =
            parseInt($("#batchTbl tbody tr:last-child").attr("id").substr(10)) +
            1;
    }
    $("#batchTbl").append(
        '<tr id="batchTblTr' +
            i +
            '">' +
            '<td><input class="form-control" id="batch_code' +
            i +
            '" name="batch_code[]"></td>' +
            '<td><input class="form-control" id="stock' +
            i +
            '" name="stock[]"></td>' +
            '<td><button type="button" class="btn btn-danger btn-sm" id="removeStock' +
            i +
            '" onclick="remove_batch_tbl_row(' +
            i +
            ')"><i class="fa fa-minus"></i></button></td>' +
            "</tr>"
    );
});
function remove_batch_tbl_row(i) {
    $("#batchTblTr" + i).remove();
}
//added by Arjun start
$(document).on("click", ".delete-data", function (event) {
    var ib = $(this).attr("data-id");
    var url = $(this).attr("data-url");
    var main_id = $(this).attr("id");
    bootbox.confirm({
        message: "Are you sure you want to delete ?",
        buttons: {
            confirm: {
                label: "Yes, I confirm",
                className: "btn-primary",
            },
            cancel: {
                label: "Cancel",
                className: "btn-danger",
            },
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    type: "get",
                    url: url,
                    data: {
                        ib: ib,
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (data) {
                        var response = JSON.parse(data);
                        if (response["success"] == 0) {
                            $.activeitNoty({
                                type: "danger",
                                icon: "fa fa-minus",
                                message: response["message"],
                                container: "floating",
                                timer: 3000,
                            });
                        } else {
                            $.activeitNoty({
                                type: "success",
                                icon: "fa fa-check",
                                message: response["message"],
                                container: "floating",
                                timer: 3000,
                            });
                            location.reload();
                        }
                    },
                });
            }
        },
    });
});
//added by Arjun end

/**
 * -- CKEditor Textarea box
 */
let theEditor;
function loadCKEditor(id) {
    $(".ck-editor").remove();
    ClassicEditor.create(document.querySelector("#" + id), {
        toolbar: [
            "heading",
            "|",
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
        ],
        heading: {
            options: [
                {
                    model: "paragraph",
                    title: "Paragraph",
                    class: "ck-heading_paragraph",
                },
                {
                    model: "heading1",
                    view: "h1",
                    title: "Heading 1",
                    class: "ck-heading_heading1",
                },
                {
                    model: "heading2",
                    view: "h2",
                    title: "Heading 2",
                    class: "ck-heading_heading2",
                },
                {
                    model: "heading3",
                    view: "h3",
                    title: "Heading 3",
                    class: "ck-heading_heading3",
                },
            ],
        },
    })
        .then((editor) => {
            theEditor = editor;
        })
        .catch((error) => {
            console.log(error);
        });
}

function getDataFromTheEditor() {
    return theEditor.getData();
}

//getProductDetails function with Ajax to get product details drop down of selected product in recommendation engine add|edit
function getProductDetails(product) {
    $.ajax({
        url: "getProductDetailsDropdown",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            product_id: product,
        },
        success: function (result) {
            response = JSON.parse(result);
            var category_id = response["data"]["category"]["id"];
            var category_name = response["data"]["category"]["category_name"];
            var product_form_id = response["data"]["product_form"]["id"];
            var product_form_name =
                response["data"]["product_form"]["product_form_name"];
            var packaging_treatment_id =
                response["data"]["packaging_treatment"]["id"];
            var packaging_treatment_name =
                response["data"]["packaging_treatment"][
                    "packaging_treatment_name"
                ];

            $("#product_category").html(
                '<option value="' +
                    category_id +
                    '"">' +
                    category_name +
                    "</option>"
            );
            $("#product_form").html(
                '<option value="' +
                    product_form_id +
                    '"">' +
                    product_form_name +
                    "</option>"
            );
            $("#packaging_treatment").html(
                '<option value="' +
                    packaging_treatment_id +
                    '"">' +
                    packaging_treatment_name +
                    "</option>"
            );
        },
    });
}

$(document).on("click", ".delimg", function (event) {
    var ib = $(this).attr("data-id");
    var url = $(this).attr("data-url");
    var main_id = $(this).attr("id");
    bootbox.confirm({
        message: "Are you sure you want to delete this image?",
        buttons: {
            confirm: {
                label: "Yes, I confirm",
                className: "btn-primary",
            },
            cancel: {
                label: "Cancel",
                className: "btn-danger",
            },
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        ib: ib,
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (data) {
                        var response = JSON.parse(data);
                        if (response["success"] == 0) {
                            $.activeitNoty({
                                type: "danger",
                                icon: "fa fa-minus",
                                message: response["message"],
                                container: "floating",
                                timer: 3000,
                            });
                        } else {
                            $.activeitNoty({
                                type: "success",
                                icon: "fa fa-check",
                                message: response["message"],
                                container: "floating",
                                timer: 3000,
                            });
                            $("#" + main_id)
                                .closest(".main-del-section")
                                .remove();
                        }
                    },
                });
            }
        },
    });
});

//Added By Swayama on 28-Jul-2022 Start

//Fetch attribute in products
var fetcAttr = function (sub_category_id, optionvalue) {
    console.log(optionvalue);
    var optionarr = optionvalue.split(",").map(Number);
    $("#attributes").empty();
    $.ajax({
        url: "fetchSubCategoryAttributes",
        type: "POST",
        data: {
            sub_category_id: sub_category_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // console.log(result);
            $.each(result.attributes_res, function (key, value) {
                if (value["is_multi"] === "1") {
                    $("#attributes").append(
                        '<div class="col-sm-6"><label>' +
                            value["display_name"] +
                            '<span style="color:#ff0000">*</span></label><select class="select2 required" id="options' +
                            key +
                            '" name="options[]" style="width: 100% !important;" multiple> <option value="">Select</option>'
                    );
                } else {
                    $("#attributes").append(
                        '<div class="col-sm-6"><label>' +
                            value["display_name"] +
                            '<span style="color:#ff0000">*</span></label><select class="select2 required" id="options' +
                            key +
                            '" name="options[]" style="width: 100% !important;"> <option value="">Select</option>'
                    );
                }

                $("#options" + key).select2();
                for (var i = 0; i < value["attribute_value"].length; i++) {
                    var condition = $.inArray(
                        value["attribute_value"][i]["id"],
                        optionarr
                    );
                    if (condition != -1) {
                        $("#options" + key).append(
                            '<option value="' +
                                value["attribute_value"][i]["id"] +
                                '" selected>' +
                                value["attribute_value"][i]["values"] +
                                "</option>"
                        );
                    } else {
                        $("#options" + key).append(
                            '<option value="' +
                                value["attribute_value"][i]["id"] +
                                '">' +
                                value["attribute_value"][i]["values"] +
                                "</option>"
                        );
                    }
                }
                $("#attributes").append("</select><br/><br/></div>");
            });
        },
    });
};
//fetch attributes in add product
$(document).on("change", "#product_sub_category", function () {
    var sub_category_id = $("#product_sub_category").val();
    fetcAttr(sub_category_id, "");
});

//mapping variations dependent dropdown
$(document).on("change", "#has_variations", function () {
    $("#map_variations").empty("");
    $.ajax({
        url: "fetchProduct",
        type: "GET",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            if ($("#has_variations").prop("checked") == true) {
                $("#map_variations").html(
                    '<option value="">Select Product</option>'
                );
                $.each(result.product, function (key, value) {
                    $("#map_variations").append(
                        '<option value="' +
                            value.id +
                            '">' +
                            jQuery.parseJSON(value.product_name).en +
                            "</option>"
                    );
                });
            } else {
                $("#map_variations").html(
                    '<option value="">Select Product</option>'
                );
            }
        },
    });
});

//sub_category dependent dropdown

$(document).on("change", "#product_category", function () {
    var idCategory = this.value;
    $("#product_sub_category").html("");
    $.ajax({
        url: "fetchSubCategory",
        type: "POST",
        data: {
            category_id: idCategory,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#product_sub_category").html(
                '<option value="">Select Sub-Category</option>'
            );
            $.each(result.sub_categories, function (key, value) {
                $("#product_sub_category").append(
                    '<option value="' +
                        value.id +
                        '">' +
                        value.sub_category_name +
                        "</option>"
                );
            });
        },
    });
});

//Added By Swayama on 28-Jul-2022 End

//-------------- Category Status Chart for sales starts --------------
var categoryStatusKeys;
var categoryStatusValues;
async function categoryStatusForSale(sales_id) {
    await $.ajax({
        url: "category_status_dashboard_chart",
        type: "POST",
        data: {
            sales_id: sales_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            console.log(result);
            categoryStatusKeys = Object.keys(result.category_status_count);
            categoryStatusValues = Object.values(
                result.category_status_count
            ).map(Number);
        },
    });

    // console.log(categoryStatusKeys);
    // console.log(categoryStatusValues);
    var themeColors = [
        "#975AAA",
        "#40C057",
        "#2F8BE6",
        "#F77E17",
        "#F55252",
        "#FFD68A",
        "#9C2C77",
        "#D4D925",
        "#1C6758",
        "#967E76",
        "#D36B00",
        "#CD104D",
        "#367E18",
        "#203239",
        "#D2D79F",
        "#B1B2FF",
        "#FFD1D1",
        "#874C62",
    ];

    var pieChartOptions = {
        chart: {
            type: "pie",
            height: 320,
        },
        colors: themeColors,
        labels: categoryStatusKeys,
        series: categoryStatusValues,
        legend: {
            itemMargin: {
                horizontal: 2,
            },
        },
        responsive: [
            {
                breakpoint: 576,
                options: {
                    chart: {
                        width: 300,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
    };
    var pieChart = new ApexCharts(
        document.querySelector("#category_status_chart"),
        pieChartOptions
    );
    pieChart.render();
}

//-------------- Engineer Status Chart for sales starts --------------
var engineerStatusKeys;
var engineerStatusValues;
async function engineerStatusForSale(sales_id) {
    await $.ajax({
        url: "engineer_status_dashboard_chart",
        type: "POST",
        data: {
            sales_id: sales_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            engineerStatusKeys = Object.keys(result.engineer_status_count);
            engineerStatusValues = Object.values(
                result.engineer_status_count
            ).map(Number);
        },
    });
    // console.log(engineerStatusKeys);
    // console.log(engineerStatusValues);

    var themeColors = [
        "#975AAA",
        "#40C057",
        "#2F8BE6",
        "#F77E17",
        "#F55252",
        "#FFD68A",
        "#9C2C77",
        "#D4D925",
        "#1C6758",
        "#967E76",
        "#D36B00",
        "#CD104D",
        "#367E18",
        "#203239",
        "#D2D79F",
        "#B1B2FF",
        "#FFD1D1",
        "#874C62",
    ];
    var pieChartOptions = {
        chart: {
            type: "pie",
            height: 320,
        },
        colors: themeColors,
        labels: engineerStatusKeys,
        series: engineerStatusValues,
        legend: {
            itemMargin: {
                horizontal: 2,
            },
        },
        responsive: [
            {
                breakpoint: 576,
                options: {
                    chart: {
                        width: 300,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
    };
    var pieChart = new ApexCharts(
        document.querySelector("#engineer_status_chart"),
        pieChartOptions
    );
    pieChart.render();
}

//Added By Maaz on 28-Jul-2022 End

//-------------- Category Status Chart for admin starts --------------
var adminCategoryStatusKeys;
var adminCategoryStatusValues;
async function categoryStatusForAdmin() {
    await $.ajax({
        url: "admin_category_status_dashboard_chart",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            // console.log(result);
            adminCategoryStatusKeys = Object.keys(
                result.admin_category_status_count
            );
            adminCategoryStatusValues = Object.values(
                result.admin_category_status_count
            ).map(Number);
        },
    });

    var themeColors = [
        "#975AAA",
        "#40C057",
        "#2F8BE6",
        "#F77E17",
        "#F55252",
        "#FFD68A",
        "#9C2C77",
        "#D4D925",
        "#1C6758",
        "#967E76",
        "#D36B00",
        "#CD104D",
        "#367E18",
        "#203239",
        "#D2D79F",
        "#B1B2FF",
        "#FFD1D1",
        "#874C62",
    ];

    var pieChartOptions = {
        chart: {
            type: "pie",
            height: 320,
        },
        colors: themeColors,
        labels: adminCategoryStatusKeys,
        series: adminCategoryStatusValues,
        legend: {
            itemMargin: {
                horizontal: 2,
            },
        },
        responsive: [
            {
                breakpoint: 576,
                options: {
                    chart: {
                        width: 300,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
    };
    var pieChart = new ApexCharts(
        document.querySelector("#category_status_chart"),
        pieChartOptions
    );
    pieChart.render();

    // console.log(adminCategoryStatusKeys);
    // console.log(adminCategoryStatusValues);
}

//-------------- Engineer Status Chart for Admin starts --------------
var adminEngineerStatusKeys;
var adminEngineerStatusValues;
async function engineerStatusForAdmin() {
    await $.ajax({
        url: "admin_engineer_status_dashboard_chart",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            adminEngineerStatusKeys = Object.keys(
                result.admin_engineer_status_count
            );
            adminEngineerStatusValues = Object.values(
                result.admin_engineer_status_count
            ).map(Number);
        },
    });
    // console.log(adminEngineerStatusKeys);
    // console.log(adminEngineerStatusValues);
    var themeColors = [
        "#975AAA",
        "#40C057",
        "#2F8BE6",
        "#F77E17",
        "#F55252",
        "#FFD68A",
        "#9C2C77",
        "#D4D925",
        "#1C6758",
        "#967E76",
        "#D36B00",
        "#CD104D",
        "#367E18",
        "#203239",
        "#D2D79F",
        "#B1B2FF",
        "#FFD1D1",
        "#874C62",
    ];
    var pieChartOptions = {
        chart: {
            type: "pie",
            height: 320,
        },
        colors: themeColors,
        labels: adminEngineerStatusKeys,
        series: adminEngineerStatusValues,
        legend: {
            itemMargin: {
                horizontal: 2,
            },
        },
        responsive: [
            {
                breakpoint: 576,
                options: {
                    chart: {
                        width: 300,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
    };
    var pieChart = new ApexCharts(
        document.querySelector("#engineer_status_chart"),
        pieChartOptions
    );
    pieChart.render();
}

//-------------- Typist Status Chart for Admin starts --------------
var adminTypistStatusKeys;
var adminTypistStatusValues;
async function typistStatusForAdmin() {
    await $.ajax({
        url: "admin_typist_status_dashboard_chart",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            adminTypistStatusKeys = Object.keys(
                result.admin_typist_status_count
            );
            adminTypistStatusValues = Object.values(
                result.admin_typist_status_count
            ).map(Number);
        },
    });
    // console.log(adminTypistStatusKeys);
    // console.log(adminTypistStatusValues);
    var themeColors = [
        "#975AAA",
        "#40C057",
        "#2F8BE6",
        "#F77E17",
        "#F55252",
        "#FFD68A",
        "#9C2C77",
        "#D4D925",
        "#1C6758",
        "#967E76",
        "#D36B00",
        "#CD104D",
        "#367E18",
        "#203239",
        "#D2D79F",
        "#B1B2FF",
        "#FFD1D1",
        "#874C62",
    ];
    var pieChartOptions = {
        chart: {
            type: "pie",
            height: 320,
        },
        colors: themeColors,
        labels: adminTypistStatusKeys,
        series: adminTypistStatusValues,
        legend: {
            itemMargin: {
                horizontal: 2,
            },
        },
        responsive: [
            {
                breakpoint: 576,
                options: {
                    chart: {
                        width: 300,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
    };
    var pieChart = new ApexCharts(
        document.querySelector("#typist_status_chart"),
        pieChartOptions
    );
    pieChart.render();
}

//-------------- Region Chart for Admin starts --------------
var adminRegionKeys;
var adminRegionValues;
async function regionForAdmin() {
    await $.ajax({
        url: "admin_region_dashboard_chart",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            adminRegionKeys = Object.keys(result.admin_region_count);
            adminRegionValues = Object.values(result.admin_region_count).map(
                Number
            );
        },
    });
    // console.log(adminRegionKeys);
    // console.log(adminRegionValues);
    var themeColors = [
        "#975AAA",
        "#40C057",
        "#2F8BE6",
        "#F77E17",
        "#F55252",
        "#FFD68A",
        "#9C2C77",
        "#D4D925",
        "#1C6758",
        "#967E76",
        "#D36B00",
        "#CD104D",
        "#367E18",
        "#203239",
        "#D2D79F",
        "#B1B2FF",
        "#FFD1D1",
        "#874C62",
    ];
    var pieChartOptions = {
        chart: {
            type: "pie",
            height: 320,
        },
        colors: themeColors,
        labels: adminRegionKeys,
        series: adminRegionValues,
        legend: {
            itemMargin: {
                horizontal: 2,
            },
        },
        responsive: [
            {
                breakpoint: 576,
                options: {
                    chart: {
                        width: 300,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
    };
    var pieChart = new ApexCharts(
        document.querySelector("#region_chart"),
        pieChartOptions
    );
    pieChart.render();
}

function formatDate(date) {
    var d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;

    return [year, month, day].join("-");
}

async function lineChartStudents() {
    var $primary = "#36a2eb";
    var $secondary = "#ff6384";
    var studentCount, monthData;

    await $.ajax({
        url: "admin_students_dashboard_chart", // Change to your route
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            monthData = result.map(a => a.month);
            studentCount = result.map(a => a.total);
        },
        failure: function () {
            console.log("Failed to fetch student chart data");
        },
    });

    var themeColors = [$primary, $secondary];
    var lineChartOptions = {
        chart: {
            height: 350,
            width: "98%",
            type: "area",
            zoom: {
                enabled: false,
            },
        },
        colors: themeColors,
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: "straight",
        },
        series: [
            {
                name: "Students Added",
                data: studentCount,
            },
        ],

        grid: {
            row: {
                colors: ["#f3f4f6", "transparent"], // Alternating row colors
                opacity: 0.5,
            },
        },
        xaxis: {
            categories: monthData,
        },
        yaxis: {
            tickAmount: 10,
        },
    };

    var lineChart = new ApexCharts(
        document.querySelector("#line-chart"),
        lineChartOptions
    );
    lineChart.render();
}

