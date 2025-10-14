// Dashboard Chart Configuration and Management
// Real-time analytics dashboard for CI4 Admin

// Chart instances
let monthlyProductsChart;
let categoryDistributionChart;
let priceRangeChart;

// Color schemes
const chartColors = {
    primary: '#4e73df',
    success: '#1cc88a',
    info: '#36b9cc',
    warning: '#f6c23e',
    danger: '#e74a3b',
    secondary: '#858796',
    light: '#f8f9fc',
    dark: '#5a5c69'
};

// Chart color palettes
const colorPalettes = {
    blue: ['#4e73df', '#224abe', '#3f6ad8', '#6c8cd5', '#85a5d6'],
    mixed: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#fd7e14', '#6f42c1'],
    green: ['#1cc88a', '#17a673', '#13855c', '#0f6848', '#0b4b35'],
    gradient: ['#4e73df', '#5a7de8', '#6687f1', '#7291fa', '#7e9bff']
};

// Initialize all charts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the dashboard page by looking for dashboard-specific elements
    const isDashboardPage = document.querySelector('#monthlyProductsChart') || 
                           document.querySelector('#categoryDistributionChart') || 
                           document.querySelector('.dashboard-content');
    
    if (!isDashboardPage) {
        console.log('Not on dashboard page, skipping chart initialization');
        return;
    }
    
    console.log('DOM loaded, checking dependencies...');
    console.log('Chart.js available:', typeof Chart !== 'undefined');
    if (typeof Chart !== 'undefined') {
        console.log('Chart.js version:', Chart.version || 'Unknown');
    }
    console.log('Dashboard data available:', !!window.dashboardData);
    console.log('Dashboard data:', window.dashboardData);
    
    if (typeof Chart !== 'undefined') {
        if (window.dashboardData) {
            console.log('Initializing charts immediately...');
            initializeCharts();
        } else {
            console.log('Dashboard data not ready, waiting...');
            // Wait for dashboard data to be available
            const checkData = setInterval(() => {
                if (window.dashboardData) {
                    console.log('Dashboard data now available, initializing charts...');
                    clearInterval(checkData);
                    initializeCharts();
                }
            }, 100);
            
            // Timeout after 5 seconds
            setTimeout(() => {
                clearInterval(checkData);
                if (!window.dashboardData) {
                    console.log('Dashboard data not available after timeout - this is normal for non-dashboard pages');
                }
            }, 5000);
        }
    } else {
        console.error('Chart.js not loaded');
    }
});

// Backup initialization on window load
window.addEventListener('load', function() {
    // Check if we're on the dashboard page
    const isDashboardPage = document.querySelector('#monthlyProductsChart') || 
                           document.querySelector('#categoryDistributionChart') || 
                           document.querySelector('.dashboard-content');
    
    if (!isDashboardPage) {
        return;
    }
    
    console.log('Window loaded, checking if charts need initialization...');
    if (typeof Chart !== 'undefined' && window.dashboardData && !monthlyProductsChart) {
        console.log('Initializing charts on window load...');
        initializeCharts();
    }
});

// Main chart initialization function
function initializeCharts() {
    console.log('Starting chart initialization...');
    console.log('Available data:', window.dashboardData);
    
    try {
        initMonthlyProductsChart();
        initCategoryDistributionChart();
        if (window.dashboardData.productsByPrice && window.dashboardData.productsByPrice.length > 0) {
            initPriceRangeChart();
        }
        
        console.log('Charts initialized successfully');
        
        // Initialize auto-refresh
        setInterval(refreshDashboardData, 300000); // Refresh every 5 minutes
    } catch (error) {
        console.error('Error initializing charts:', error);
    }
}

// Monthly Products Line Chart
function initMonthlyProductsChart() {
    console.log('Initializing monthly products chart...');
    const ctx = document.getElementById('monthlyProductsChart');
    if (!ctx) {
        console.error('Monthly products chart canvas not found');
        return;
    }

    const monthlyData = window.dashboardData.monthlyProductsData || [];
    console.log('Monthly products data:', monthlyData);
    
    const labels = monthlyData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    });
    const data = monthlyData.map(item => parseInt(item.count) || 0);
    
    console.log('Chart labels:', labels);
    console.log('Chart data:', data);

    monthlyProductsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Products Added',
                data: data,
                borderColor: chartColors.primary,
                backgroundColor: chartColors.primary + '20',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: chartColors.primary,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#333',
                    borderColor: chartColors.primary,
                    borderWidth: 1,
                    callbacks: {
                        title: function(context) {
                            return 'Month: ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Products Added: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#666'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(234, 236, 244, 1)',
                        zeroLineColor: 'rgba(234, 236, 244, 1)',
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    },
                    ticks: {
                        color: '#666',
                        precision: 0
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
    
    console.log('Monthly products chart created successfully');
}

// Category Distribution Pie Chart
function initCategoryDistributionChart() {
    const ctx = document.getElementById('categoryDistributionChart');
    if (!ctx) return;

    const categoryData = window.dashboardData.categoryDistribution || [];
    const labels = categoryData.map(item => item.name);
    const data = categoryData.map(item => parseInt(item.product_count));
    const colors = colorPalettes.mixed.slice(0, categoryData.length);

    categoryDistributionChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // We'll create a custom legend
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#333',
                    borderColor: '#ddd',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} products (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });

    // Create custom legend
    updateCategoryLegend(categoryData, colors);
}

// Price Range Bar Chart
function initPriceRangeChart() {
    const ctx = document.getElementById('priceRangeChart');
    if (!ctx) return;

    const priceData = window.dashboardData.productsByPrice || [];
    const labels = priceData.map(item => item.price_range);
    const data = priceData.map(item => parseInt(item.count));

    priceRangeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of Products',
                data: data,
                backgroundColor: colorPalettes.gradient,
                borderColor: chartColors.primary,
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#333',
                    borderColor: chartColors.primary,
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

// Update category legend
function updateCategoryLegend(categoryData, colors) {
    const legendContainer = document.getElementById('categoryLegend');
    if (!legendContainer) return;

    let legendHtml = '';
    categoryData.forEach((category, index) => {
        const color = colors[index];
        legendHtml += `
            <span class="mr-2 mb-1 d-inline-block">
                <i class="fas fa-circle" style="color: ${color}"></i> ${category.name}
            </span>
        `;
    });

    legendContainer.innerHTML = legendHtml;
}

// Refresh dashboard data via AJAX
function refreshDashboardData() {
    console.log('Refreshing dashboard data...');
    
    // Show loading state
    showLoadingState();
    
    fetch(window.location.origin + '/dashboard/apiData')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Received data:', data);
            window.dashboardData = data;
            updateAllCharts();
            updateStatsCards();
            hideLoadingState();
            showRefreshNotification();
        })
        .catch(error => {
            console.error('Error refreshing dashboard data:', error);
            hideLoadingState();
            showErrorNotification('Failed to refresh dashboard data: ' + error.message);
        });
}

// Update all charts with new data
function updateAllCharts() {
    console.log('Updating all charts...');
    
    if (monthlyProductsChart) {
        updateMonthlyProductsChart();
    }
    if (categoryDistributionChart) {
        updateCategoryDistributionChart();
    }
    if (priceRangeChart && window.dashboardData.productsByPrice && window.dashboardData.productsByPrice.length > 0) {
        updatePriceRangeChart();
    } else if (window.dashboardData.productsByPrice && window.dashboardData.productsByPrice.length > 0 && !priceRangeChart) {
        // Initialize price range chart if it doesn't exist but we have data
        initPriceRangeChart();
    }
    
    console.log('Charts updated successfully');
}

// Update monthly products chart
function updateMonthlyProductsChart() {
    try {
        console.log('Updating monthly products chart...');
        const monthlyData = window.dashboardData.monthlyProductsData || [];
        console.log('Monthly data:', monthlyData);
        
        const labels = monthlyData.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
        });
        const data = monthlyData.map(item => parseInt(item.count) || 0);

        monthlyProductsChart.data.labels = labels;
        monthlyProductsChart.data.datasets[0].data = data;
        monthlyProductsChart.update('active');
        console.log('Monthly products chart updated');
    } catch (error) {
        console.error('Error updating monthly products chart:', error);
    }
}

// Update category distribution chart
function updateCategoryDistributionChart() {
    try {
        console.log('Updating category distribution chart...');
        const categoryData = window.dashboardData.categoryDistribution || [];
        console.log('Category data:', categoryData);
        
        const labels = categoryData.map(item => item.name);
        const data = categoryData.map(item => parseInt(item.product_count) || 0);
        const colors = colorPalettes.mixed.slice(0, categoryData.length);

        // Update chart data properly
        categoryDistributionChart.data.labels = labels;
        categoryDistributionChart.data.datasets[0].data = data;
        categoryDistributionChart.data.datasets[0].backgroundColor = colors;
        
        // Reset hover colors to let Chart.js handle them automatically
        delete categoryDistributionChart.data.datasets[0].hoverBackgroundColor;
        delete categoryDistributionChart.data.datasets[0].hoverBorderColor;
        
        categoryDistributionChart.update();

        // Update legend
        updateCategoryLegend(categoryData, colors);
        console.log('Category distribution chart updated');
    } catch (error) {
        console.error('Error updating category distribution chart:', error);
    }
}

// Update price range chart
function updatePriceRangeChart() {
    try {
        console.log('Updating price range chart...');
        const priceData = window.dashboardData.productsByPrice || [];
        console.log('Price data:', priceData);
        
        const labels = priceData.map(item => item.price_range);
        const data = priceData.map(item => parseInt(item.count) || 0);

        priceRangeChart.data.labels = labels;
        priceRangeChart.data.datasets[0].data = data;
        priceRangeChart.update('active');
        console.log('Price range chart updated');
    } catch (error) {
        console.error('Error updating price range chart:', error);
    }
}

// Update stats cards
function updateStatsCards() {
    console.log('Updating stats cards...');
    
    // Update the stat cards with new data
    const data = window.dashboardData;
    
    try {
        // Find and update stat cards by their content patterns
        const statCards = document.querySelectorAll('.card .h5.font-weight-bold.text-gray-800');
        
        statCards.forEach(card => {
            const parentCard = card.closest('.card');
            const titleElement = parentCard.querySelector('.text-xs.font-weight-bold');
            
            if (titleElement) {
                const title = titleElement.textContent.trim().toLowerCase();
                
                if (title.includes('total products')) {
                    card.textContent = formatNumber(data.totalProducts);
                } else if (title.includes('categories')) {
                    card.textContent = formatNumber(data.totalCategories);
                } else if (title.includes('blog posts')) {
                    card.textContent = formatNumber(data.totalBlogPosts);
                } else if (title.includes('unread messages')) {
                    card.textContent = formatNumber(data.unreadMessages);
                } else if (title.includes('total users')) {
                    card.textContent = formatNumber(data.totalUsers);
                } else if (title.includes('total pages')) {
                    card.textContent = formatNumber(data.totalPages);
                } else if (title.includes('new products (30d)')) {
                    card.textContent = formatNumber(data.recentActivity.products_30d);
                } else if (title.includes('new pages (30d)')) {
                    card.textContent = formatNumber(data.recentActivity.pages_30d);
                }
            }
        });
        
        // Update progress bars
        updateProgressBars(data);
        
        console.log('Stats cards updated successfully');
    } catch (error) {
        console.error('Error updating stats cards:', error);
    }
}

// Helper function to format numbers
function formatNumber(num) {
    return new Intl.NumberFormat().format(num || 0);
}

// Helper function to find element by text content
function findElementByText(selector, text) {
    const elements = document.querySelectorAll(selector);
    for (let element of elements) {
        if (element.textContent.includes(text)) {
            return element;
        }
    }
    return null;
}

// Update progress bars
function updateProgressBars(data) {
    try {
        console.log('Updating progress bars...');
        
        // Update blog posts progress bar in the stats cards
        const blogProgressBar = document.querySelector('.progress-bar.bg-info');
        if (blogProgressBar && data.totalBlogPosts > 0) {
            const blogProgress = Math.min((data.recentActivity.posts_30d / Math.max(data.totalBlogPosts, 1)) * 100, 100);
            blogProgressBar.style.width = blogProgress + '%';
            blogProgressBar.setAttribute('aria-valuenow', blogProgress);
            console.log('Updated blog progress bar:', blogProgress + '%');
        }
        
        // Update content progress bars in the progress section
        updateContentProgressBars(data);
        
        console.log('Progress bars update completed');
    } catch (error) {
        console.error('Error updating progress bars:', error);
    }
}

// Update content management progress bars
function updateContentProgressBars(data) {
    console.log('Updating content progress bars with data:', data);
    
    // Find the content management progress card
    const contentHeader = findElementByText('.card-header h6', 'Content Management Progress');
    if (contentHeader) {
        const progressCard = contentHeader.closest('.card').querySelector('.card-body');
        updateProgressBarsInCard(progressCard, data);
    } else {
        console.log('Content Management Progress header not found, trying alternative method...');
        // Alternative way to find the content management card
        const progressCards = document.querySelectorAll('.card-body');
        let found = false;
        progressCards.forEach(cardBody => {
            const text = cardBody.textContent;
            if (!found && (text.includes('Product Catalog') && text.includes('Blog Content') && text.includes('Static Pages'))) {
                console.log('Found content management card via alternative method');
                updateProgressBarsInCard(cardBody, data);
                found = true;
            }
        });
        
        if (!found) {
            console.warn('Could not find Content Management Progress card');
        }
    }
}

// Helper function to update progress bars in a specific card
function updateProgressBarsInCard(cardBody, data) {
    const progressSections = cardBody.querySelectorAll('h4.small.font-weight-bold');
    
    progressSections.forEach(section => {
        const text = section.textContent.toLowerCase();
        const progressBar = section.nextElementSibling?.querySelector('.progress-bar');
        const percentSpan = section.querySelector('span.float-right');
        
        if (!progressBar) return;
        
        let progress = 0;
        let currentCount = 0;
        let targetCount = 0;
        let newClass = '';
        
        if (text.includes('product catalog')) {
            targetCount = 100;
            currentCount = data.totalProducts;
            progress = Math.min((currentCount / targetCount) * 100, 100);
            newClass = progress < 50 ? 'bg-danger' : (progress < 80 ? 'bg-warning' : 'bg-success');
        } else if (text.includes('blog content')) {
            targetCount = 50;
            currentCount = data.totalBlogPosts;
            progress = Math.min((currentCount / targetCount) * 100, 100);
            newClass = progress < 50 ? 'bg-danger' : (progress < 80 ? 'bg-warning' : 'bg-success');
        } else if (text.includes('static pages')) {
            targetCount = 25;
            currentCount = data.totalPages;
            progress = Math.min((currentCount / targetCount) * 100, 100);
            newClass = progress < 50 ? 'bg-danger' : (progress < 80 ? 'bg-warning' : 'bg-success');
        } else if (text.includes('product categories')) {
            targetCount = 20;
            currentCount = data.totalCategories;
            progress = Math.min((currentCount / targetCount) * 100, 100);
            newClass = progress >= 100 ? 'bg-success' : (progress < 50 ? 'bg-info' : 'bg-primary');
        } else if (text.includes('recent activity')) {
            // Handle the multi-part recent activity bar
            updateRecentActivityBar(section, data);
            return;
        }
        
        // Update progress bar
        progressBar.className = `progress-bar ${newClass}`;
        progressBar.style.width = progress + '%';
        progressBar.setAttribute('aria-valuenow', progress);
        
        // Update the span text
        if (percentSpan) {
            if (progress >= 100 && text.includes('categories')) {
                percentSpan.textContent = 'Complete!';
            } else {
                percentSpan.textContent = `${progress.toFixed(1)}% (${currentCount}/${targetCount})`;
            }
        }
        
        console.log(`Updated ${text}: ${currentCount}/${targetCount} = ${progress.toFixed(1)}%`);
    });
}

// Update the recent activity progress bar with multiple segments
function updateRecentActivityBar(section, data) {
    const progressContainer = section.nextElementSibling?.querySelector('.progress');
    const spanElement = section.querySelector('span.float-right');
    
    if (!progressContainer) return;
    
    const recentTotal = data.recentActivity.products_30d + data.recentActivity.posts_30d + data.recentActivity.pages_30d;
    
    // Update the span text
    if (spanElement) {
        spanElement.textContent = `${recentTotal} items`;
    }
    
    if (recentTotal === 0) {
        progressContainer.innerHTML = '<div class="progress-bar bg-secondary" style="width: 100%" title="No recent activity"></div>';
        return;
    }
    
    // Calculate percentages
    const productPortion = (data.recentActivity.products_30d / recentTotal) * 100;
    const postPortion = (data.recentActivity.posts_30d / recentTotal) * 100;
    const pagePortion = (data.recentActivity.pages_30d / recentTotal) * 100;
    
    // Build the progress bar HTML
    let progressHtml = '';
    if (data.recentActivity.products_30d > 0) {
        progressHtml += `<div class="progress-bar bg-success" style="width: ${productPortion}%" title="Products: ${data.recentActivity.products_30d}"></div>`;
    }
    if (data.recentActivity.posts_30d > 0) {
        progressHtml += `<div class="progress-bar bg-info" style="width: ${postPortion}%" title="Posts: ${data.recentActivity.posts_30d}"></div>`;
    }
    if (data.recentActivity.pages_30d > 0) {
        progressHtml += `<div class="progress-bar bg-warning" style="width: ${pagePortion}%" title="Pages: ${data.recentActivity.pages_30d}"></div>`;
    }
    
    progressContainer.innerHTML = progressHtml;
    
    console.log('Updated recent activity bar:', {
        total: recentTotal,
        products: data.recentActivity.products_30d,
        posts: data.recentActivity.posts_30d,
        pages: data.recentActivity.pages_30d
    });
}

// Show refresh notification
function showRefreshNotification() {
    // Create a temporary notification
    const notification = document.createElement('div');
    notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 200px;';
    notification.innerHTML = `
        <i class="fas fa-sync-alt"></i> Dashboard updated
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 3000);
}

// Utility functions for dashboard interactions
function refreshChart() {
    refreshDashboardData();
}

function toggleChartType() {
    if (monthlyProductsChart) {
        const currentType = monthlyProductsChart.config.type;
        const newType = currentType === 'line' ? 'bar' : 'line';
        
        monthlyProductsChart.destroy();
        
        // Reinitialize with new type
        setTimeout(() => {
            const ctx = document.getElementById('monthlyProductsChart');
            const monthlyData = window.dashboardData.monthlyProductsData || [];
            const labels = monthlyData.map(item => {
                const date = new Date(item.month + '-01');
                return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            });
            const data = monthlyData.map(item => parseInt(item.count) || 0);

            monthlyProductsChart = new Chart(ctx, {
                type: newType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Products Added',
                        data: data,
                        borderColor: chartColors.primary,
                        backgroundColor: newType === 'line' ? chartColors.primary + '20' : chartColors.primary,
                        borderWidth: newType === 'line' ? 3 : 1,
                        fill: newType === 'line'
                    }]
                },
                options: monthlyProductsChart.options || {}
            });
        }, 100);
    }
}

function exportChart() {
    if (monthlyProductsChart) {
        const link = document.createElement('a');
        link.download = 'monthly-products-chart.png';
        link.href = monthlyProductsChart.toBase64Image();
        link.click();
    }
}

function refreshDashboard() {
    refreshDashboardData();
}

function showAllCategories() {
    // This would expand the category chart to show all categories
    console.log('Show all categories');
}

function showTopCategories() {
    // This would filter to show only top 5 categories
    console.log('Show top categories only');
}

// Loading state functions
function showLoadingState() {
    const containers = document.querySelectorAll('.chart-area, .chart-pie');
    containers.forEach(container => {
        container.classList.add('refreshing');
    });
}

function hideLoadingState() {
    const containers = document.querySelectorAll('.chart-area, .chart-pie');
    containers.forEach(container => {
        container.classList.remove('refreshing');
    });
}

// Error notification function
function showErrorNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'alert alert-danger alert-dismissible fade show position-fixed';
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
    notification.innerHTML = `
        <i class="fas fa-exclamation-triangle"></i> ${message}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

// Export for global access
window.dashboardCharts = {
    refresh: refreshDashboardData,
    toggleType: toggleChartType,
    export: exportChart
};