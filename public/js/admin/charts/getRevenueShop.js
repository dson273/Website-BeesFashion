// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,  // Dùng dấu chấm phân cách
        dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);  // Dùng dấu chấm phân cách hàng nghìn
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec) + 'đ';  // Thêm "đ" vào cuối chuỗi
}


function createChart(labels, data) {
    // Làm tròn tất cả các giá trị trong data để tránh sai lệch
    data = data.map(value => Math.round(value));

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Doanh thu",
                backgroundColor: "#4e73df",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "#4e73df",
                data: data,
                maxBarThickness: 25,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    type: 'category',
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    },
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 20000000,
                        maxTicksLimit: 10,
                        padding: 10,
                        callback: function (value) {
                            return number_format(Math.round(value), 0, ',', '.')
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + number_format(Math.round(tooltipItem.yLabel), 0, ',', '.')
                    }
                }
            }
        }
    });
}

// Hàm lấy dữ liệu từ API
function fetchChartData(timeFrame) {
    fetch(`/admin/statistics/revenue?time_frame=${timeFrame}`)
        .then(response => response.json())
        .then(data => {
            createChart(data.labels, data.revenue);
        })
        .catch(error => console.error('Lỗi:', error));
}

// Hàm áp dụng lọc tùy chỉnh
function applyCustomFilter() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    if (!startDate || !endDate) {
        alert('Vui lòng chọn ngày bắt đầu và ngày kết thúc');
        return;
    }
    if (startDate > endDate) {
        alert('Vui lòng chọn ngày bắt đầu không được lớn hơn ngày kết thúc');
        return;
    }
    fetch(`/admin/statistics/revenue?time_frame=custom&start_date=${startDate}&end_date=${endDate}`)
        .then(response => response.json())
        .then(data => {
            createChart(data.labels, data.revenue);
        })
        .catch(error => console.error('Lỗi:', error));
}

// Tải biểu đồ mặc định (tháng này) khi trang load
document.addEventListener('DOMContentLoaded', () => {
    fetchChartData('this_month');
});
