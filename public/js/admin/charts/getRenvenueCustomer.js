document.addEventListener('DOMContentLoaded', function() {
    // Formatters
    const formatters = {
        currency: (amount) => new Intl.NumberFormat('vi-VN').format(amount) + 'đ',
        number: (number) => new Intl.NumberFormat('vi-VN').format(number),
        date: (dateString) => new Date(dateString).toLocaleDateString('vi-VN')
    };

    // Variables
    let customerTiersChart = null;
    const timeTypeSelect = document.getElementById('timeTypeSelect');
    const revenueFilterForm = document.getElementById('revenueFilterForm');

    // UI handlers
    const handleTimeTypeChange = () => {
        const timeType = timeTypeSelect.value;
        document.getElementById('dailySelect').style.display = timeType === 'daily' ? 'block' : 'none';
        document.getElementById('monthlySelect').style.display = timeType === 'monthly' ? 'block' : 'none';
        document.getElementById('yearlySelect').style.display = timeType === 'yearly' ? 'block' : 'none';
    };

    // Table update functions
    const updateCustomerTable = (customers) => {
        const tbody = document.querySelector('#customersTable tbody');
        tbody.innerHTML = customers.map(customer => `
            <tr>
                <td>${customer.full_name}</td>
                <td>${customer.email}</td>
                <td><span class="${customer.tier.class}">${customer.tier.name}</span></td>
                <td>${formatters.number(customer.total_orders)}</td>
                <td>${formatters.currency(customer.total_spending)}</td>
                <td>${formatters.currency(customer.average_order_value)}</td>
                <td>${formatters.date(customer.first_order_date)}</td>
                <td>${formatters.date(customer.last_order_date)}</td>
            </tr>
        `).join('');
    };

    const updateSpendingTiersTable = (spendingTiers) => {
        const total = spendingTiers.total_customers;
        const tiers = spendingTiers.spending_tiers;
        const tbody = document.querySelector('#spendingTiersTable tbody');

        const calculatePercentage = (value) => {
            return total > 0 ? ((value / total) * 100).toFixed(1) : 0;
        };

        tbody.innerHTML = `
            <tr>
                <td>Khách hàng VIP (>10M)</td>
                <td>${formatters.number(tiers.high_value)}</td>
                <td>${calculatePercentage(tiers.high_value)}%</td>
            </tr>
            <tr>
                <td>Khách hàng thường (5M-10M)</td>
                <td>${formatters.number(tiers.medium_value)}</td>
                <td>${calculatePercentage(tiers.medium_value)}%</td>
            </tr>
            <tr>
                <td>Khách hàng mới (<5M)</td>
                <td>${formatters.number(tiers.low_value)}</td>
                <td>${calculatePercentage(tiers.low_value)}%</td>
            </tr>
        `;
    };

    const updateRevenueTable = (revenueStats) => {
        const tbody = document.querySelector('#revenueTable tbody');
        tbody.innerHTML = revenueStats.map(stat => `
            <tr>
                <td>${stat.period}</td>
                <td>${formatters.number(stat.total_customers)}</td>
                <td>${formatters.number(stat.total_orders)}</td>
                <td>${formatters.currency(stat.total_revenue)}</td>
                <td>${formatters.currency(stat.average_order_value)}</td>
                <td>${formatters.currency(stat.average_customer_spending)}</td>
            </tr>
        `).join('');
    };

    const updateCustomerTiersChart = (spendingTiers) => {
        const ctx = document.getElementById('customerTiersChart').getContext('2d');
        const tiers = spendingTiers.spending_tiers;

        if (customerTiersChart) {
            customerTiersChart.destroy();
        }

        customerTiersChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['VIP (>10M)', 'Thường xuyên (5M-10M)', 'Mới (<5M)'],
                datasets: [{
                    data: [tiers.high_value, tiers.medium_value, tiers.low_value],
                    backgroundColor: ['#dc3545', '#0d6efd', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    };

    // Data fetching
    const getFilterDate = (formData) => {
        const timeType = formData.get('time_type') || 'monthly';
        let date;

        switch (timeType) {
            case 'daily':
                date = formData.get('daily_date');
                break;
            case 'monthly':
                date = formData.get('monthly_date');
                break;
            case 'yearly':
                date = formData.get('yearly_date');
                break;
            default:
                date = new Date().toISOString().split('T')[0];
        }

        return { timeType, date };
    };

    const fetchData = async () => {
        const formData = new FormData(revenueFilterForm);
        const { timeType, date } = getFilterDate(formData);

        try {
            const response = await fetch(`/admin/statistics/revenueCustomer?time_type=${timeType}&${timeType}_date=${date}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data) {
                updateCustomerTable(data.customerDetails);
                updateSpendingTiersTable(data.spendingTiers);
                updateRevenueTable(data.revenueStats);
                updateCustomerTiersChart(data.spendingTiers);
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            alert('Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại sau.');
        }
    };

    // Event listeners
    timeTypeSelect.addEventListener('change', handleTimeTypeChange);
    revenueFilterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchData();
        console.log();
    });

    // Initialize
    handleTimeTypeChange();
    fetchData();
});
