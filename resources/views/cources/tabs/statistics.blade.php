
    <style>


        .container {
            max-width: 1200px;
            margin: 0 auto;
        }


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
          margin-bottom:10px;
            /* الإطار الأزرق */
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
        

        <div class="stats-row">
            <div class="stat-card">
                    <img src="/images/cources/num-views.svg">

                <div class="stat-info">
                    <div class="stat-title">عدد المشاهدات</div>
                    <div class="stat-value">200 مشاهدة</div>
                </div>
            </div>


            <div class="stat-card">
              
                    <img src="/images/cources/num-trianee.svg">
              
                <div class="stat-info">
                    <div class="stat-title">عدد المتدربين المسجلين</div>
                    <div class="stat-value">150 متدرب</div>
                </div>
            </div>


            <div class="stat-card">
        <img src="/images/cources/num-access-trianee.svg">
                <div class="stat-info">
                    <div class="stat-title">عدد المقبولين</div>
                    <div class="stat-value">100 متدرب</div>
                </div>
            </div>

            <div class="stat-card">
            
                    <img src="/images/cources/percentage-trainee.svg">

                <div class="stat-info">
                    <div class="stat-title">نسبة الحضور العامة</div>
                    <div class="stat-value">78%</div>
                </div>
            </div>
        </div>
            <div class="chart-title mt-5">عدد حضور كل جلسة</div>

        <div class="chart-container">
            <canvas id="attendanceChart"></canvas>
        </div>

    </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');

    const labels = [
        'الجلسة الأولى', 
        'الجلسة الثانية', 
        'الجلسة الثالثة', 
        'الجلسة الرابعة', 
        'الجلسة الخامسة',
        'الجلسة السادسة', 
        'الجلسة السابعة', 
        'الجلسة الثامنة'
    ];
    const dataValues = [55, 70, 95, 80, 30.22, 75, 85, 60];

    // ✅ بلوجين رسم الخطوط الأفقية المتقطعة يدويًا
  const dashedGridPlugin = {
    id: 'dashedGrid',
    beforeDraw(chart) {
        const { ctx, chartArea: {left, right}, scales: {y} } = chart;
        ctx.save();
        ctx.strokeStyle = 'rgba(0,0,0,0.3)';
        ctx.setLineDash([6, 6]); // ✅ جميع الخطوط متقطعة الآن بما فيها خط الصفر
        y.ticks.forEach((tick) => {
            const yPos = y.getPixelForValue(tick.value);
            ctx.beginPath();
            ctx.moveTo(left, yPos);
            ctx.lineTo(right, yPos);
            ctx.stroke();
        });
        ctx.restore();
    }
};
//لإخفاء الخط العمودي
const removeVerticalBorder = {
    id: 'removeVerticalBorder',
    beforeDraw(chart) {
        const { ctx, chartArea: { top, bottom, left, right }, scales: { y, x } } = chart;
        ctx.save();
        ctx.clearRect(left - 2, top, 2, bottom - top); // ✅ مسح أي خط عمودي يسار أو يمين
        ctx.clearRect(right, top, 2, bottom - top);    // ✅ مسح الخط العمودي الأيمن
        ctx.restore();
    }
};

//إضافة الظل الأزرق لللخط المرسوم
const blueShadowPlugin = {
    id: 'blueShadow',
    beforeDatasetsDraw(chart) {
        const { ctx } = chart;
        ctx.save();
        ctx.shadowColor = '#005FDC59'; // ✅ ظل أزرق شفاف
        ctx.shadowBlur = 14;           // ✅ يشبه blur(14px)
        ctx.shadowOffsetX = 0;
        ctx.shadowOffsetY = 0;
    },
    afterDatasetsDraw(chart) {
        const { ctx } = chart;
        ctx.restore(); // ✅ بعد رسم الخطوط نرجع الإعدادات كما كانت
    }
};



    // ✅ بلوجين البالون الخاص بالنقطة الخامسة
    const customLabel = {
        id: 'customLabel',
        afterDatasetsDraw(chart) {
            const {ctx, scales: {x, y}} = chart;
            const index = 4; // الجلسة الخامسة
            const value = dataValues[index];
            const xPos = x.getPixelForValue(index);
            const yPos = y.getPixelForValue(value);

            const titleText = 'الجلسة الخامسة';
            const valueText = value;

            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            // ✅ حجم البالون
            ctx.font = 'bold 14px Tahoma';
            const titleWidth = ctx.measureText(titleText).width;
            ctx.font = 'bold 18px Tahoma';
            const valueWidth = ctx.measureText(valueText).width;
            const boxWidth = Math.max(titleWidth, valueWidth) + 20;
            const boxHeight = 55;
            const boxX = xPos - boxWidth / 2;
            const boxY = yPos - 80;

            // ✅ رسم البالون بخلفية بيضاء وظل
            ctx.shadowColor = 'rgba(0,0,0,0.2)';
            ctx.shadowBlur = 6;
            ctx.shadowOffsetX = 2;
            ctx.shadowOffsetY = 2;
            ctx.fillStyle = '#fff';
            ctx.beginPath();
            ctx.roundRect(boxX, boxY, boxWidth, boxHeight, 6);
            ctx.fill();

            // ✅ نصوص البالون
            ctx.shadowColor = 'transparent';
            ctx.fillStyle = '#000';
            ctx.font = 'bold 14px Tahoma';
            ctx.fillText(titleText, xPos, boxY + 18);

            ctx.fillStyle = '#007bff';
            ctx.font = 'bold 18px Tahoma';
            ctx.fillText(valueText, xPos, boxY + 40);

            // ✅ السهم
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

    // ✅ إنشاء المخطط
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

                // ✅ تمييز النقطة الخامسة فقط
                pointRadius: function(ctx) {
                    return ctx.dataIndex === 4 ? 8 : 0;
                },
                pointBackgroundColor: function(ctx) {
                    return ctx.dataIndex === 4 ? '#007bff' : 'transparent';
                },
                pointBorderWidth: function(ctx) {
                    return ctx.dataIndex === 4 ? 3 : 0;
                },
                pointBorderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            },
scales: {
    x: {
    reverse: true,
    ticks: {
        color: '#333',
        autoSkip: true,
        maxTicksLimit: 6,
        padding: 40,
  //maxRotation: 45, // أقصى ميلان للنصوص
  //  minRotation: 30  // أقل ميلان
    },
    grid: {
        drawOnChartArea: false,
        drawTicks: true,
        color: 'transparent'
    },
    border: {
        display: false // ✅ يخفي الخط السفلي أيضًا
    }
}
,
y: {
    position: 'right',
    beginAtZero: true,
    max: 200,
    ticks: {
        stepSize: 50,
        color: '#333',
        padding: 20, // زيادة المسافة بين الأرقام وبداية الرسم
        // لو بدك تقدر تتحكم بظهور العلامات بشكل أدق مثلاً تقليل عددها
        // autoSkip: false,
        // maxTicksLimit: 5,
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
