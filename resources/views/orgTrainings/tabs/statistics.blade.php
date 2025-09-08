<style>
    .stats-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
        margin-top: 30px;
    }
    .stat-card {
        flex: 1;
        flex-direction: row-reverse;
        min-width: 200px;
        background: white;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #D9D9D9;
        display: flex;
        align-items: center;
    }
    .stat-info {
        flex: 1;
    }
    .stat-title {
        font-size: 12px;
        color: #A0AEC0;
        margin-bottom: 5px;
        font-weight: bold
    }
    .stat-value {
        font-size: 20px;
        font-weight: bold;
        color: #2D3748;
    }
    .chart-container {
        background: white;
        margin-bottom: 10px;
        border-radius: 10px;
        padding: 20px;
        max-width: 100%;
        height: 420px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .chart-title {
        font-size: 20px;
        text-align: right;
        font-weight: 600;
        color: #203370;
        margin-bottom: 15px;
    }
    #attendanceChart {
        width: 100%;
        min-height: 400px;
    }
    @media (max-width: 768px) {
        .stat-card {
            min-width: 100%;
        }
        .stat-value {
            font-size: 20px;
        }
    }
</style>
<div class="container">
    {{-- صف الإحصائيات --}}
    <div class="stats-row d-flex flex-wrap gap-3">
        <div class="stat-card">
            <img src="/images/cources/num-views.svg">
            <div class="stat-info">
                <div class="stat-title">عدد المشاهدات</div>
                <div class="stat-value">{{ $OrgProgram->views }} مشاهدة</div>
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
  @if(count($OrgProgram->details) > 0 && count($sessionAttendanceCounts) > 0 && array_sum($sessionAttendanceCounts) > 0)
  
    {{-- العنوان --}}
    <div class="chart-title mt-5">عدد الحضور في كل تدريب</div>
    {{-- الرسم البياني --}}
    <div class="chart-container" style="height: 400px;">
        <canvas id="attendanceChart"></canvas>
    </div>
        @endif
</div>

{{-- تمهيد بيانات الرسم --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // الحصول على بيانات التدريبات وإنشاء مصفوفة العناوين
    const programLabels = @json($OrgProgram->details->pluck('program_title'));

      const programAttendanceCounts = '';
</script>

<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const labels = programLabels;
    const dataValues = programAttendanceCounts;
    const maxDataValue = Math.max(...dataValues);
    const yAxisMax = Math.ceil(maxDataValue * 1.2);
    
    // دالة لرسم نص متعدد الأسطر
    function drawMultilineText(ctx, text, x, y, lineHeight, maxWidth) {
        const words = text.split(' ');
        let line = '';
        let lines = [];
        words.forEach(word => {
            const testLine = line + word + ' ';
            const metrics = ctx.measureText(testLine);
            if (metrics.width > maxWidth && line !== '') {
                lines.push(line);
                line = word + ' ';
            } else {
                line = testLine;
            }
        });
        lines.push(line);
        lines.forEach((lineText, index) => {
            ctx.fillText(lineText.trim(), x, y + (index * lineHeight));
        });
        return lines.length;
    }
    
    // بلوجين لرسم الخطوط الأفقية المتقطعة
    const dashedGridPlugin = {
        id: 'dashedGrid',
        beforeDraw(chart) {
            const {
                ctx,
                chartArea: {
                    left,
                    right
                },
                scales: {
                    y
                }
            } = chart;
            ctx.save();
            ctx.strokeStyle = 'rgba(0,0,0,0.3)';
            ctx.setLineDash([6, 6]);
            y.ticks.forEach(tick => {
                const yPos = y.getPixelForValue(tick.value);
                ctx.beginPath();
                ctx.moveTo(left, yPos);
                ctx.lineTo(right, yPos);
                ctx.stroke();
            });
            ctx.restore();
        }
    };
    
    // بلوجين لإزالة الخطوط العمودية الجانبية
    const removeVerticalBorder = {
        id: 'removeVerticalBorder',
        beforeDraw(chart) {
            const {
                ctx,
                chartArea: {
                    top,
                    bottom,
                    left,
                    right
                }
            } = chart;
            ctx.save();
            ctx.clearRect(left - 2, top, 2, bottom - top);
            ctx.clearRect(right, top, 2, bottom - top);
            ctx.restore();
        }
    };
    
    // بلوجين لإضافة ظل أزرق على الخط الرئيسي
    const blueShadowPlugin = {
        id: 'blueShadow',
        beforeDatasetsDraw(chart) {
            const {
                ctx
            } = chart;
            ctx.save();
            ctx.shadowColor = '#005FDC59';
            ctx.shadowBlur = 14;
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;
        },
        afterDatasetsDraw(chart) {
            const {
                ctx
            } = chart;
            ctx.restore();
        }
    };
    
    // بلوجين للبالون المخصص مع دعم النص متعدد الأسطر
    const customLabel = {
        id: 'customLabel',
        afterDatasetsDraw(chart) {
            const {
                ctx,
                scales: {
                    x,
                    y
                }
            } = chart;
            const maxVal = Math.max(...dataValues);
            const index = dataValues.indexOf(maxVal);
            if (index < 0 || index >= dataValues.length) return;
            const value = dataValues[index];
            const xPos = x.getPixelForValue(index);
            const yPos = y.getPixelForValue(value);
            const titleText = labels[index];
            const valueText = value.toString();
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = 'bold 14px Tahoma';
            const maxWidth = 150; // أقصى عرض للنص داخل البالون
            
            // قياس عناوين متعددة الأسطر
            const titleLines = titleText ? titleText.split(' ') : [''];
            // نحسب عدد الأسطر فعلياً باستخدام الدالة للرسم لاحقاً
            ctx.font = 'bold 14px Tahoma';
            let titleLineCount = 1;
            {
                // فقط لحساب عدد الأسطر من دون الرسم
                const words = titleText.split(' ');
                let line = '';
                let linesCount = 0;
                words.forEach(word => {
                    const testLine = line + word + ' ';
                    if (ctx.measureText(testLine).width > maxWidth && line !== '') {
                        linesCount++;
                        line = word + ' ';
                    } else {
                        line = testLine;
                    }
                });
                linesCount++; // للسطرة الأخيرة
                titleLineCount = linesCount;
            }
            
            ctx.font = 'bold 18px Tahoma';
            const valueWidth = ctx.measureText(valueText).width;
            const boxWidth = Math.max(maxWidth, valueWidth) + 20;
            // ارتفاع الصندوق = عدد أسطر العنوان * ارتفاع السطر + ارتفاع قيمة الرقم + padding
            const lineHeight = 18;
            const boxHeight = (titleLineCount * lineHeight) + 30 + 20; // 30 px للقيمة + 20 padding
            const boxX = xPos - boxWidth / 2;
            const boxY = yPos - boxHeight - 20;
            
            // صندوق البالون مع ظل
            ctx.shadowColor = 'rgba(0,0,0,0.2)';
            ctx.shadowBlur = 6;
            ctx.shadowOffsetX = 2;
            ctx.shadowOffsetY = 2;
            ctx.fillStyle = '#fff';
            ctx.beginPath();
            ctx.roundRect(boxX, boxY, boxWidth, boxHeight, 6);
            ctx.fill();
            
            // نص العنوان (متعدد الأسطر)
            ctx.shadowColor = 'transparent';
            ctx.fillStyle = '#000';
            ctx.font = 'bold 14px Tahoma';
            drawMultilineText(ctx, titleText, xPos, boxY + 14, lineHeight, maxWidth);
            
            // قيمة الرقم
            ctx.fillStyle = '#007bff';
            ctx.font = 'bold 18px Tahoma';
            ctx.fillText(valueText, xPos, boxY + (titleLineCount * lineHeight) + 20);
            
            // السهم (المثلث) تحت الصندوق
            ctx.shadowColor = 'rgba(0,0,0,0.2)';
            ctx.shadowBlur = 4;
            ctx.shadowOffsetX = 1;
            ctx.shadowOffsetY = 1;
            ctx.beginPath();
            ctx.moveTo(xPos - 7, boxY + boxHeight);
            ctx.lineTo(xPos + 7, boxY + boxHeight);
            ctx.lineTo(xPos, boxY + boxHeight + 8);
            ctx.closePath();
            ctx.fillStyle = '#fff';
            ctx.fill();
            ctx.restore();
        }
    };
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'عدد الحضور',
                data: dataValues,
                backgroundColor: '#005FDC',
                borderColor: '#005FDC',
                borderWidth: 1,
                borderRadius: 5,
                barThickness: 40
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
                    reverse: false,
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
        },
        plugins: [dashedGridPlugin, customLabel, removeVerticalBorder, blueShadowPlugin]
    });
</script>