<div class="container">
    {{-- صف الإحصائيات --}}
    <div class="stats-row d-flex flex-wrap gap-3">
        <div class="stat-card">
            <img src="/images/cources/num-views.svg">
            <div class="stat-info">
                <div class="stat-title">عدد المشاهدات</div>
                <div class="stat-value">{{ $OrgProgramDetail->trainingProgram->views }} مشاهدة</div>
            </div>
        </div>
        <div class="stat-card">
            <img src="/images/cources/num-trianee.svg">
            <div class="stat-info">
                <div class="stat-title">عدد المتدربين المسجلين</div>
                <div class="stat-value">{{ count($participants) }} متدرب</div>
            </div>
        </div>
        <div class="stat-card">
            <img src="/images/cources/num-access-trianee.svg">
            <div class="stat-info">
                <div class="stat-title">عدد المقبولين</div>
                <div class="stat-value">{{ count($trainees) }} متدرب</div>
            </div>
        </div>
        <div class="stat-card">
            <img src="/images/cources/percentage-trainee.svg">
            <div class="stat-info">
                <div class="stat-title">نسبة الحضور العامة</div>
                <div class="stat-value">{{ $overallAttendancePercentage }}%</div>
            </div>
        </div>
    </div>

    @if(count($OrgProgramDetail->trainingSchedules) > 0 && count($sessionAttendanceCounts) > 0 && array_sum($sessionAttendanceCounts) > 0)
        {{-- العنوان --}}
        <div class="chart-title mt-5">عدد حضور كل جلسة</div>
        {{-- الرسم البياني --}}
        <div class="chart-container" style="height: 400px;">
            <canvas id="attendanceChart"></canvas>
        </div>
    @endif
</div>

@if(count($OrgProgramDetail->trainingSchedules) > 0 && count($sessionAttendanceCounts) > 0 && array_sum($sessionAttendanceCounts) > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const labels = @json(array_keys($sessionAttendanceCounts));
        const dataValues = @json(array_values($sessionAttendanceCounts));
        const maxDataValue = Math.max(...dataValues);
        const yAxisMax = Math.ceil(maxDataValue * 1.2);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'عدد الحضور',
                    data: dataValues,
                    borderColor: '#005FDC',
                    backgroundColor: 'transparent',
                    borderWidth: 3,
                    tension: 0.4,
                    pointRadius: (ctx) => ctx.dataIndex === dataValues.indexOf(Math.max(...dataValues)) ? 8 : 0,
                    pointBackgroundColor: (ctx) => ctx.dataIndex === dataValues.indexOf(Math.max(...dataValues)) ? '#007bff' : 'transparent',
                    pointBorderWidth: (ctx) => ctx.dataIndex === dataValues.indexOf(Math.max(...dataValues)) ? 3 : 0,
                    pointBorderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 40,
                        right: 40,
                        left: 40,
                        bottom: 60
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                scales: {
                    x: {
                        reverse: true,
                        ticks: {
                            color: '#333',
                            autoSkip: true,
                            maxTicksLimit: 6,
                            maxRotation: 45,
                            minRotation: 45,
                            padding: 10,
                        },
                        grid: {
                            drawOnChartArea: false,
                            drawTicks: true,
                            color: 'transparent'
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        position: 'right',
                        beginAtZero: true,
                        max: yAxisMax,
                        ticks: {
                            stepSize: undefined,
                            autoSkip: true,
                            maxTicksLimit: 10,
                            callback: function(value) {
                                return Number.isInteger(value) ? value : '';
                            },
                            color: '#333',
                            padding: 20
                        },
                        grid: {
                            drawTicks: true,
                            drawBorder: false,
                            color: 'transparent'
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endif