var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
    $('#start_date').val(start.format('DD-MM-YYYY')).change();
    $('#end_date').val(end.format('DD-MM-YYYY')).change();
    $('#reportrange').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
}

function cb1(start, end) {
    $('#start_date1').val(start.format('DD/MM/YYYY H:mm')).change();
    $('#end_date1').val(end.format('DD/MM/YYYY H:mm')).change();
    $('#reportrange1').val(start.format('DD/MM/YYYY H:mm') + ' - ' + end.format('DD/MM/YYYY H:mm'));
}


$('#demo').daterangepicker({
    "singleDatePicker": true,
    "timePicker": true,
    "timePicker24Hour": true,
    locale: {
        format: "DD/MM/YYYY H:mm",
    }
}, function(start, end, label) {
    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});

$('#reportrange').daterangepicker({
    startDate: start,
    endDate: end,
    // timePicker: true,
    // timePicker24Hour: true,
    // timePickerIncrement: 30,
    locale: {
        format: "DD/MM/YYYY",
        separator: " - ",
        applyLabel: "Đồng ý",
        cancelLabel: "Hủy",
        fromLabel: "Từ",
        toLabel: "Tới",
        customRangeLabel: "Tùy chỉnh",
        weekLabel: "Tuần",
        daysOfWeek: [
            "CN",
            "T2",
            "T3",
            "T4",
            "T5",
            "T6",
            "T7"
        ],
        monthNames: [
            "Tháng 1",
            "Tháng 2",
            "Tháng 3",
            "Tháng 4",
            "Tháng 5",
            "Tháng 6",
            "Tháng 7",
            "Tháng 8",
            "Tháng 9",
            "Tháng 10",
            "Tháng 11",
            "Tháng 12"
        ],
        "firstDay": 1
    },
    ranges: {
        'Hôm nay': [moment(), moment()],
        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Tuần này': [moment().startOf('week'), moment().endOf('week')],
        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

$('#reportrange1').daterangepicker({
    startDate: start,
    endDate: end,
    locale: {
        format: "DD/MM/YYYY H:mm",
        separator: " - ",
        applyLabel: "Đồng ý",
        cancelLabel: "Hủy",
        fromLabel: "Từ",
        toLabel: "Tới",
        customRangeLabel: "Tùy chỉnh",
        weekLabel: "Tuần",
        daysOfWeek: [
            "CN",
            "T2",
            "T3",
            "T4",
            "T5",
            "T6",
            "T7",
        ],
        monthNames: [
            "Tháng 1",
            "Tháng 2",
            "Tháng 3",
            "Tháng 4",
            "Tháng 5",
            "Tháng 6",
            "Tháng 7",
            "Tháng 8",
            "Tháng 9",
            "Tháng 10",
            "Tháng 11",
            "Tháng 12"
        ],
        "firstDay": 1
    },
    ranges: {
        'Hôm nay': [moment().set({hour:0,minute:0}), moment()],
        'Hôm qua': [moment().subtract(1, 'days').set({hour:0,minute:0}), moment().subtract(1, 'days')],
        'Tuần này': [moment().startOf('week'), moment().endOf('week')],
        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb1);

cb(start, end);
cb1(start, end);
