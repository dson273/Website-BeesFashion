// Chart instances
let revenueChart = null;
let profitChart = null;

// Helper function to truncate text
function truncateText(text, maxLength = 10) {
    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}

// Initialize charts
function initializeCharts(data) {
    const chartOptions = {
        responsive: true,
        scales: {
            y: {
                min: 0,
                beginAtZero: true,
                ticks: {
                    callback: function (value) {
                        return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                    }
                }
            },
            x: {
                ticks: {
                    callback: function(value) {
                        return truncateText(this.getLabelForValue(value));
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(context) {
                        // Show full name in tooltip
                        return context[0].label;
                    },
                    label: function (context) {
                        return new Intl.NumberFormat('vi-VN').format(context.raw) + ' đ';
                    }
                }
            }
        }
    };

    // Initialize Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: data.map(item => item.name),
            datasets: [{
                label: 'Doanh thu',
                data: data.map(item => item.total_revenue),
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: chartOptions
    });

    // Initialize Profit Chart
    const profitCtx = document.getElementById('profitChart').getContext('2d');
    profitChart = new Chart(profitCtx, {
        type: 'bar',
        data: {
            labels: data.map(item => item.name),
            datasets: [{
                label: 'Lợi nhuận',
                data: data.map(item => item.profit),
                backgroundColor: 'rgba(28, 200, 138, 0.5)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 1
            }]
        },
        options: chartOptions
    });
}

// Update charts with new data
function updateCharts(data) {
    if (revenueChart) {
        revenueChart.data.labels = data.map(item => item.name);
        revenueChart.data.datasets[0].data = data.map(item => item.total_revenue);
        revenueChart.update();
    }

    if (profitChart) {
        profitChart.data.labels = data.map(item => item.name);
        profitChart.data.datasets[0].data = data.map(item => item.profit);
        profitChart.update();
    }
}

// Update data table
function updateDataTable(data) {
    const tableBody = document.querySelector('#revenueTable tbody');
    if (!tableBody) return;

    let html = '';
    data.forEach((item, index) => {
        html += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.name}</td>
                <td>${new Intl.NumberFormat('vi-VN').format(item.total_orders)}</td>
                <td>${new Intl.NumberFormat('vi-VN').format(item.total_revenue)} đ</td>
                <td>${new Intl.NumberFormat('vi-VN').format(item.total_cost)} đ</td>
                <td>${new Intl.NumberFormat('vi-VN').format(item.profit)} đ</td>
            </tr>
        `;
    });

    // Calculate totals
    const totals = data.reduce((acc, item) => ({
        total_orders: acc.total_orders + item.total_orders,
        total_revenue: acc.total_revenue + item.total_revenue,
        total_cost: acc.total_cost + item.total_cost,
        profit: acc.profit + item.profit
    }), { total_orders: 0, total_revenue: 0, total_cost: 0, profit: 0 });

    html += `
        <tr class="table-info font-weight-bold">
            <td colspan="2">Tổng cộng</td>
            <td>${new Intl.NumberFormat('vi-VN').format(totals.total_orders)}</td>
            <td>${new Intl.NumberFormat('vi-VN').format(totals.total_revenue)} đ</td>
            <td>${new Intl.NumberFormat('vi-VN').format(totals.total_cost)} đ</td>
            <td>${new Intl.NumberFormat('vi-VN').format(totals.profit)} đ</td>
        </tr>
    `;

    tableBody.innerHTML = html;
}

// Handle period type change
function updatePeriodInput() {
    const periodType = document.getElementById('periodType');
    const periodInputContainer = document.getElementById('periodInputContainer');
    const currentDate = new Date();
    let html = '';

    switch (periodType.value) {
        case 'day':
            html = `
                <label class="form-label">Chọn ngày</label>
                <input type="date"
                       class="form-control"
                       name="date"
                       value="${currentDate.toISOString().split('T')[0]}"
                       max="${currentDate.toISOString().split('T')[0]}">`;
            break;

        case 'month':
            html = `
                <label class="form-label">Chọn tháng</label>
                <input type="month"
                       class="form-control"
                       name="date"
                       value="${currentDate.toISOString().slice(0, 7)}"
                       max="${currentDate.toISOString().slice(0, 7)}">`;
            break;

        case 'year':
            const currentYear = currentDate.getFullYear();
            const years = Array.from({ length: currentYear - 1999 }, (_, i) => currentYear - i);
            const yearOptions = years.map(year => `<option value="${year}">${year}</option>`).join('');

            html = `
                <label class="form-label">Chọn năm</label>
                <select class="form-control" name="date">
                    ${yearOptions}
                </select>`;
            break;
    }

    periodInputContainer.innerHTML = html;
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Initialize period input
    updatePeriodInput();

    // Initialize charts with initial data
    if (window.initialData) {
        initializeCharts(window.initialData);
        updateDataTable(window.initialData);
    }

    // Period type change handler
    const periodType = document.getElementById('periodType');
    periodType.addEventListener('change', updatePeriodInput);

    // Form submission handler
    const statisticsForm = document.getElementById('statisticsForm');
    statisticsForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const searchParams = new URLSearchParams(formData);

        fetch(`${window.location.pathname}?${searchParams.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                // Update charts and table with the response data
                updateCharts(data);
                updateDataTable(data);

                // Update URL without page reload
                window.history.pushState({}, '', `${window.location.pathname}?${searchParams.toString()}`);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại.');
            });
    });
});
