$(document).ready(function () {
  switch (page) {
    case "banner":
      bannerTable(page);
      break;
    case "customer":
      customerTable(page);
      break;
    case "delivery-boy":
      deliveryBoyTable(page);
      break;
    case "booking-slot-single":
      singleBookingSlotTable(page);
      break;
    case "FAQ":
      faqTable(page);
      break;
    case "helpAndSupport":
      helpAndSupportTable(page);
      break;
    case "coupon":
      couponTable(page);
      break;
    case "addon":
      addonTable(page);
      break;
    case "review":
      reviewTable(page);
      break;
    case "order":
      orderTable(page);
      break;
    case "transaction":
      transactionTable(page);
      break;
    default:
      console.log("Define page name if the page has table.");
      break;
  }
});
const bannerTable = (page) => {
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "banner/ajax-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "screenName" },
      { data: "type" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [5] }],
  });
};
const customerTable = (page) => {
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "customer/ajax-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "firstName" },
      { data: "lastName" },
      { data: "phone" },
      { data: "gender" },
      { data: "dob" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [6, 8] }],
  });
};
const deliveryBoyTable = (page) => {
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "delivery-boy/ajax-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "firstName" },
      { data: "lastName" },
      { data: "phone" },
      { data: "gender" },
      { data: "dob" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [6, 8] }],
  });
};
const singleBookingSlotTable = (page) => {
  $("#datatable-ajax-" + page).DataTable().destroy();
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "booking-slot/ajax-single-booking-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "customerName" },
      { data: "pickUpDate" },
      { data: "pickUpTime" },
      { data: "deliveryDate" },
      { data: "deliveryTime" },
      { data: "deliveryBoy" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [1, 6, 7, 9] }],
    order: [[8, "desc"]],
  });
};
const faqTable = (page) => {
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "FAQ/ajax-data-table",
      type: "post",
      data: function (data) {
        data._csrf = _token;
      },
    },
    columns: [
      { data: "_id" },
      { data: "type" },
      { data: "question" },
      { data: "answer" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [4,6] }],
  });
};
const helpAndSupportTable = (page) => {
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "help-and-support/ajax-data-table",
      type: "post",
      data: function (data) {
        data._csrf = _token;
      },
    },
    columns: [
      { data: "_id" },
      { data: "type" },
      { data: "question" },
      { data: "answer" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [4, 6] }],
  });
};
const couponTable = (page) => {
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "coupon/ajax-data-table",
      type: "post",
      data: function (data) {
        data._csrf = _token;
      },
    },
    columns: [
      { data: "_id" },
      { data: "couponCode" },
      { data: "discount" },
      { data: "type" },
      { data: "shortDescription" },
      { data: "usePerUser" },
      { data: "startDate" },
      { data: "endDate" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [5] }],
  });
};
const addonTable = (page) => {
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "addon/ajax-data-table",
      type: "post",
      data: function (data) {
        data._csrf = _token;
      },
    },
    columns: [
      { data: "_id" },
      { data: "name" },
      { data: "price" },
      { data: "quantity" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [5] }],
  });
};
const reviewTable = (page) => {
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "review/ajax-data-table",
      type: "post",
      data: function (data) {
        data._csrf = _token;
      },
    },
    columns: [
      { data: "_id" },
      { data: "deliveryBoy" },
      { data: "comment" },
      { data: "star" },
      // { data: "status" },
      { data: "isApproved" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [5] }],
  });
};

const recurringDailyBookingSlotTable = (page) => {
  $("#datatable-ajax-" + page).DataTable().destroy();
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "booking-slot/ajax-recurring-daily-booking-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "customerName" },
      { data: "pickUpDate" },
      { data: "pickUpTime" },
      { data: "deliveryDate" },
      { data: "deliveryTime" },
      { data: "deliveryBoy" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [1, 6, 7, 9] }],
    order: [[8, "desc"]],
  });
};
const recurringOnceInAWeekBookingSlotTable = (page) => {
  $("#datatable-ajax-" + page)
    .DataTable()
    .destroy();
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url:
        baseUrl +
        "booking-slot/ajax-recurring-once-in-a-week-booking-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "customerName" },
      { data: "pickUpDayName" },
      { data: "pickUpTime" },
      { data: "deliveryDayName" },
      { data: "deliveryTime" },
      { data: "deliveryBoy" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [1, 6, 7, 9] }],
    order: [[8, "desc"]],
  });
};
const recurringTwiceInAWeekBookingSlotTable = (page) => {
  $("#datatable-ajax-" + page)
    .DataTable()
    .destroy();
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "booking-slot/ajax-recurring-twice-in-a-week-booking-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "customerName" },
      { data: "pickUpDayNameOne" },
      { data: "pickUpTimeOne" },
      { data: "deliveryDayNameOne" },
      { data: "deliveryTimeOne" },
      { data: "pickUpDayNameTwo" },
      { data: "pickUpTimeTwo" },
      { data: "deliveryDayNameTwo" },
      { data: "deliveryTimeTwo" },
      { data: "deliveryBoy" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [1, 6, 7, 9] }],
    order: [[12, "desc"]],
  });
};
const bulkBookingSlotTable = (page) => {
  $("#datatable-ajax-" + page).DataTable().destroy();
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "booking-slot/ajax-bulk-booking-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "customerName" },
      { data: "pickUpDate" },
      { data: "pickUpTime" },
      { data: "deliveryDate" },
      { data: "deliveryTime" },
      { data: "deliveryBoy" },
      { data: "status" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [1, 6, 7, 9] }],
    order: [[8, "desc"]],
  });
};
const orderTable = (page) => {
  $("#datatable-ajax-" + page)
    .DataTable()
    .destroy();
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "order/ajax-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "altId" },
      { data: "customerName" },
      { data: "deliveryBoy" },
      { data: "slotBookingId" },
      { data: "amount" },
      { data: "discount" },
      { data: "tax" },
      { data: "paidAmount" },
      { data: "paymentStatus" },
      { data: "currentStatus" },
      { data: "createdAt" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [1, 2, 3,4, 12] }],
    order: [[11, "desc"]],
  });
};
const transactionTable = (page) => {
  $("#datatable-ajax-" + page)
    .DataTable()
    .destroy();
  var table = $("#datatable-ajax-" + page).DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: false,
    ajax: {
      url: baseUrl + "transaction/ajax-data-table",
      type: "post",
      data: function (data) {
        //   if ($("#client_id").val() != "") {
        //     clientId = $("#client_id").val();
        //   }
        // if($('#searchName').val()!=""){
        //    searchName = $('#searchName').val();
        // }
        // if($('#searchFormDate').val()!=""){
        //    searchFormDate = $('#searchFormDate').val();
        // }
        // if($('#searchToDate').val()!=""){
        //    searchToDate = $('#searchToDate').val();
        // }
        data._csrf = _token;
        // data.searchName      = searchName,
        // data.searchFormDate  = searchFormDate,
        // data.searchToDate = searchToDate
      },
    },
    columns: [
      { data: "_id" },
      { data: "customerName" },
      { data: "paymentId" },
      { data: "razorpayOrderId" },
      { data: "type" },
      { data: "paidAmount" },
      { data: "paidVia" },
      { data: "paymentStatus" },
      { data: "remark" },
      { data: "paymentDate" },
      { data: "action" },
    ],
    columnDefs: [{ orderable: false, targets: [1, 2, 3, 4, 10] }],
    order: [[9, "desc"]],
  });
};