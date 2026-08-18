<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DTZ Tablet - Space</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="{{ asset('tablet/css/dtz-tablet.css') }}" rel="stylesheet">
</head>
<body>
<div class="tablet-container"><div class="page-card">
<div class="dtz-header text-center py-3">
<img src="{{ asset('images/logo.png') }}" style="height:60px" alt="DTZ">
<h4 class="fw-bold mt-3">رسم فضای جدید</h4>
</div>

<div class="dtz-card mt-3">
<h5 class="fw-bold mb-3">اطلاعات موکت</h5>
<div class="mb-3"><label class="dtz-label">مدل موکت</label><input type="text" class="form-control" value="{{ $carpetModel->model_name ?? '' }}" readonly></div>
<div><label class="dtz-label">کد موکت</label><input type="text" class="form-control" value="{{ $carpetCode->code ?? '' }}" readonly></div>
</div>

<div class="dtz-card"><label class="dtz-label">نام فضا</label><input id="spaceNameText" class="form-control" value="{{ $space ?? '' }}" readonly></div>

<div class="dtz-card mt-3">
<h5 class="fw-bold">ابعاد فضا</h5>
<div class="row g-3 mt-2">
<div class="col-6"><label>طول (متر)</label><input type="number" step="0.1" id="length" class="form-control"></div>
<div class="col-6"><label>عرض (متر)</label><input type="number" step="0.1" id="width" class="form-control"></div>
</div>
<div class="alert alert-info mt-3">متراژ: <strong><span id="area">0</span></strong> متر مربع</div>
</div>

<div class="dtz-card mt-3">
<h5 class="fw-bold">پیشنهاد طاقه</h5>
<div class="alert alert-warning">سیستم: <span id="suggestRoll">-</span></div>
<div class="alert alert-info">برش: <span id="cutInfo">-</span></div>
<div id="rollContainer"></div>
<button type="button" class="btn btn-outline-primary w-100 mt-3" id="addRollBtn">+ افزودن طاقه</button>
<div class="alert alert-success mt-3">پوشش طاقه: <span id="rollArea">0</span> متر مربع</div>
</div>

<div class="dtz-card mt-4">
<h5 class="fw-bold">رسم پلان</h5>
<canvas id="planCanvas" style="width:100%;height:450px;border:2px solid #ddd;border-radius:20px;touch-action:none;"></canvas>
<button type="button" class="btn btn-success w-100 mt-3" id="finishIrregularBtn" style="display:none">✅ اتمام رسم فضا</button>
<button type="button" class="btn btn-danger w-100 mt-3" id="clearBtn">🗑 پاک کردن نقشه</button>
<input type="file" id="planImageInput" accept="image/*" capture="environment" hidden>
<button type="button" class="btn btn-primary w-100 mt-3" id="uploadPlanBtn">📷 آپلود تصویر نقشه مشتری</button>
</div>

<form method="POST" action="{{ route('tablet.space.store') }}">
@csrf
<input type="hidden" name="name" id="hiddenName">
<input type="hidden" name="carpet_model_id" value="{{ $model ?? '' }}">
<input type="hidden" name="carpet_code_id" value="{{ $code ?? '' }}">
<input type="hidden" name="drawing" id="hiddenDrawing">
<input type="hidden" name="roll" id="hiddenRoll">
<input type="hidden" name="roll_count" id="hiddenRollCount">
<input type="hidden" name="area" id="hiddenArea">
<button type="submit" class="dtz-btn w-100 mt-4" id="saveBtn">ذخیره فضا</button>
</form>
</div></div>

<script>
(() => {
'use strict';
const canvas = document.getElementById('planCanvas');
const ctx = canvas.getContext('2d');
const finishBtn = document.getElementById('finishIrregularBtn');
let lines = [], drawing = false, startPoint = null;
let shapeConfirmed = false, irregularMode = false, polygonClosed = false, planImage = null;
const dpr = () => window.devicePixelRatio || 1;

function resizeCanvas(){
    const box = canvas.getBoundingClientRect();
    canvas.width = Math.max(1, Math.round(box.width * dpr()));
    canvas.height = Math.max(1, Math.round(box.height * dpr()));
    ctx.setTransform(dpr(),0,0,dpr(),0,0);
    redrawCanvas();
}
function pointFromEvent(e){
    const r = canvas.getBoundingClientRect();
    return {x:e.clientX-r.left,y:e.clientY-r.top};
}
function distance(a,b){return Math.hypot(a.x-b.x,a.y-b.y);}
function firstPoint(){return lines.length ? {x:lines[0].x1,y:lines[0].y1} : null;}
function lastPoint(){
    if(!lines.length) return null;
    const l=lines[lines.length-1]; return {x:l.x2,y:l.y2};
}
function redrawCanvas(){
    const w=canvas.getBoundingClientRect().width, h=canvas.getBoundingClientRect().height;
    ctx.clearRect(0,0,w,h);
    if(planImage) ctx.drawImage(planImage,0,0,w,h);
    ctx.lineWidth=4; ctx.lineCap='round'; ctx.strokeStyle='black';
    lines.forEach(l=>{
        ctx.beginPath(); ctx.moveTo(l.x1,l.y1); ctx.lineTo(l.x2,l.y2); ctx.stroke();
        if(l.meter){
            ctx.font='bold 18px Arial'; ctx.fillStyle='red'; ctx.textAlign='center'; ctx.textBaseline='middle';
            ctx.fillText(l.meter+' متر',(l.x1+l.x2)/2,(l.y1+l.y2)/2-12);
        }
    });
}
function askMeter(label){
    const raw=prompt(label || 'متراژ این خط را وارد کنید (متر):');
    if(raw===null) return null;
    const n=Number.parseFloat(raw);
    return Number.isFinite(n)&&n>0?n:null;
}
function setArea(value){
    const area=Number.isFinite(value)&&value>0?value:0;
    document.getElementById('area').textContent=area.toFixed(2);
    document.getElementById('hiddenArea').value=area.toFixed(2);
    if(area>0) suggestRollSize(area);
}
function polygonAreaFromMeasuredSides(){
    if(!polygonClosed || lines.length<3) return 0;
    let x=0,y=0; const pts=[{x,y}];
    for(const l of lines){
        const px=l.x2-l.x1, py=l.y2-l.y1;
        const len=Math.hypot(px,py);
        const meter=Number(l.meter);
        if(len<=0 || !Number.isFinite(meter) || meter<=0) return 0;
        x += (px/len)*meter; y += (py/len)*meter;
        pts.push({x,y});
    }
    let sum=0;
    for(let i=0;i<pts.length-1;i++) sum += pts[i].x*pts[i+1].y-pts[i+1].x*pts[i].y;
    return Math.abs(sum)/2;
}
function calculateIrregularArea(){
    // مهم: هیچ‌وقت چهارضلعی را از روی برابر بودن اضلاع مستطیل فرض نمی‌کنیم.
    // تمام چهارضلعی‌ها و چندضلعی‌های نامنظم با هندسه واقعی خودشان محاسبه می‌شوند.
    const area=polygonAreaFromMeasuredSides();
    if(area>0){
        setArea(area);
        document.getElementById('suggestRoll').textContent='مساحت '+area.toFixed(2)+' متر مربع';
    }
    return area;
}
function createRectangleFromTwoLines(){
    if(lines.length<2) return;
    const a=lines[0], b=lines[1];
    if(!a.meter || !b.meter) return;
    const A={x:a.x1,y:a.y1}, B={x:a.x2,y:a.y2};
    const P={x:b.x1,y:b.y1}, Q={x:b.x2,y:b.y2};
    const candidates=[[A,Q,P],[A,P,Q],[B,Q,P],[B,P,Q]];
    let best=candidates[0], bestD=Infinity;
    for(const c of candidates){const d=distance(c[0],c[1]);if(d<bestD){bestD=d;best=c;}}
    const connected=best[0], far=best[1];
    const ux=(B.x-A.x), uy=(B.y-A.y), base=Math.hypot(ux,uy);
    if(base<=0) return;
    const nx=-uy/base, ny=ux/base;
    const sx=far.x-connected.x, sy=far.y-connected.y;
    const side=sx*nx+sy*ny;
    const px=(side<0?-nx:nx)*b.meter, py=(side<0?-ny:ny)*b.meter;
    const A2={x:A.x+px,y:A.y+py}, B2={x:B.x+px,y:B.y+py};
    const C=connected===A?A2:B2, D=connected===A?B2:A2;
    lines=[
      {x1:A.x,y1:A.y,x2:B.x,y2:B.y,meter:a.meter},
      {x1:connected.x,y1:connected.y,x2:C.x,y2:C.y,meter:b.meter},
      {x1:C===B2?B2.x:D.x,y1:C===B2?B2.y:D.y,x2:C===B2?D.x:C.x,y2:C===B2?D.y:C.y,meter:a.meter},
      {x1:D.x,y1:D.y,x2:A.x,y2:A.y,meter:b.meter}
    ];
    document.getElementById('length').value=a.meter;
    document.getElementById('width').value=b.meter;
    setArea(a.meter*b.meter);
    document.getElementById('suggestRoll').textContent='3×'+a.meter+' / 3×'+b.meter;
    document.getElementById('cutInfo').textContent='مربع/مستطیل';
    redrawCanvas();
}
function enterIrregularMode(){
    irregularMode=true; polygonClosed=false; shapeConfirmed=false;
    finishBtn.style.display='block';
    document.getElementById('suggestRoll').textContent='فضای نامنظم';
    document.getElementById('cutInfo').textContent='ضلع بعدی را رسم کنید';
}
function closeIrregularPolygon(){
    if(!irregularMode || lines.length<3) return false;
    const fp=firstPoint(), lp=lastPoint();
    if(!fp||!lp) return false;
    if(distance(lp,fp)>1){
        const closing={x1:lp.x,y1:lp.y,x2:fp.x,y2:fp.y,meter:null};
        lines.push(closing); redrawCanvas();
        const meter=askMeter('متراژ ضلع پایانی را وارد کنید (متر):');
        if(meter===null){lines.pop();redrawCanvas();return false;}
        closing.meter=meter;
    }
    polygonClosed=true; irregularMode=false; finishBtn.style.display='none';
    const area=calculateIrregularArea();
    if(area<=0){polygonClosed=false;irregularMode=true;finishBtn.style.display='block';return false;}
    document.getElementById('cutInfo').textContent='پلان بسته و متراژ محاسبه شد';
    return true;
}

canvas.addEventListener('pointerdown',e=>{
    if(polygonClosed || shapeConfirmed) return;
    e.preventDefault(); canvas.setPointerCapture(e.pointerId);
    startPoint=(irregularMode && lines.length>=2)?lastPoint():pointFromEvent(e);
    drawing=true;
});
canvas.addEventListener('pointermove',e=>{
    if(!drawing) return;
    const p=pointFromEvent(e); redrawCanvas();
    ctx.beginPath();ctx.moveTo(startPoint.x,startPoint.y);ctx.lineTo(p.x,p.y);ctx.strokeStyle='black';ctx.lineWidth=4;ctx.stroke();
});
canvas.addEventListener('pointerup',e=>{
    if(!drawing) return; drawing=false;
    let end=pointFromEvent(e);
    if(distance(startPoint,end)<10){redrawCanvas();return;}
    let closing=false;
    if(irregularMode && lines.length>=3 && distance(end,firstPoint())<=25){end=firstPoint();closing=true;}
    const line={x1:startPoint.x,y1:startPoint.y,x2:end.x,y2:end.y,meter:null};
    lines.push(line); redrawCanvas();
    const meter=askMeter('متراژ این خط را وارد کنید (متر):');
    if(meter===null){lines.pop();redrawCanvas();return;}
    line.meter=meter; redrawCanvas();
    if(closing){
        polygonClosed=true; irregularMode=false; finishBtn.style.display='none';
        const area=calculateIrregularArea();
        if(area>0){document.getElementById('cutInfo').textContent='پلان نامنظم بسته شد';}
        return;
    }
    if(lines.length===2 && !shapeConfirmed && !irregularMode){
        const rectangle=confirm('آیا این فضا مربع یا مستطیل است؟');
        if(rectangle){shapeConfirmed=true;createRectangleFromTwoLines();}
        else enterIrregularMode();
    } else if(irregularMode){
        document.getElementById('cutInfo').textContent='ضلع بعدی را رسم کنید یا اتمام رسم را بزنید';
    }
});
finishBtn.addEventListener('click',()=>{
    if(!irregularMode){return;}
    if(lines.length<3){alert('برای فضای نامنظم حداقل ۳ ضلع رسم کنید.');return;}
    closeIrregularPolygon();
});

function rollRows(){return [...document.querySelectorAll('#rollContainer .roll-row')];}
function showRollResult(rolls,text){
    document.getElementById('suggestRoll').textContent=rolls.map(r=>'3×'+r.length+' تعداد '+r.count).join(' + ');
    document.getElementById('cutInfo').textContent=text; setSuggestedRolls(rolls);
}
function suggestRollSize(area){
    if(!area||area<=0)return;
    let best=null;
    for(let count=1;count<=10;count++){
        for(let a=1;a<=15;a++){
            if(count===1){const cover=3*a;if(cover>=area&&(!best||cover-area<best.waste))best={rolls:[{length:a,count:1}],waste:cover-area};continue;}
            const base=Math.ceil(a); const cover=3*base*count;
            if(cover>=area&&(!best||cover-area<best.waste))best={rolls:[{length:base,count:count}],waste:cover-area};
        }
        if(best&&best.rolls[0].count===count) break;
    }
    if(best)showRollResult(best.rolls,'پیشنهاد بر اساس کمترین پوشش اضافه');
}
function setSuggestedRolls(rolls){
    const box=document.getElementById('rollContainer');box.innerHTML='';
    rolls.forEach(r=>addRollRow(r.length,r.count));updateRollArea();
}
function addRollRow(length=1,count=1){
    const row=document.createElement('div');row.className='row g-3 mt-2 roll-row';
    row.innerHTML='<div class="col-8"><select class="form-select roll-select">'+Array.from({length:15},(_,i)=>'<option value="'+(i+1)+'" '+((i+1)==length?'selected':'')+'>3×'+(i+1)+'</option>').join('')+'</select></div><div class="col-4"><input type="number" class="form-control roll-count" value="'+count+'" min="1"></div>';
    document.getElementById('rollContainer').appendChild(row);updateRollArea();
}
function updateRollArea(){let total=0;rollRows().forEach(r=>total+=(3*Number(r.querySelector('.roll-select').value))*Number(r.querySelector('.roll-count').value||0));document.getElementById('rollArea').textContent=total.toFixed(2);}
document.getElementById('addRollBtn').addEventListener('click',()=>addRollRow());
document.getElementById('rollContainer').addEventListener('input',updateRollArea);

document.getElementById('length').addEventListener('input',()=>{const l=Number(document.getElementById('length').value),w=Number(document.getElementById('width').value);if(l>0&&w>0)setArea(l*w);});
document.getElementById('width').addEventListener('input',()=>{const l=Number(document.getElementById('length').value),w=Number(document.getElementById('width').value);if(l>0&&w>0)setArea(l*w);});

document.getElementById('clearBtn').addEventListener('click',()=>{
    lines=[];drawing=false;startPoint=null;shapeConfirmed=false;irregularMode=false;polygonClosed=false;planImage=null;finishBtn.style.display='none';
    document.getElementById('length').value='';document.getElementById('width').value='';setArea(0);document.getElementById('suggestRoll').textContent='-';document.getElementById('cutInfo').textContent='-';document.getElementById('rollContainer').innerHTML='';document.getElementById('rollArea').textContent='0';document.getElementById('hiddenDrawing').value='';document.getElementById('planImageInput').value='';redrawCanvas();
});

document.getElementById('uploadPlanBtn').addEventListener('click',()=>document.getElementById('planImageInput').click());
document.getElementById('planImageInput').addEventListener('change',e=>{
    const file=e.target.files[0];if(!file)return;
    const reader=new FileReader();reader.onload=ev=>{const img=new Image();img.onload=()=>{planImage=img;redrawCanvas();};img.src=ev.target.result;};reader.readAsDataURL(file);
    const fd=new FormData();fd.append('plan_image',file);fd.append('_token',document.querySelector('meta[name="csrf-token"]').content);
    document.getElementById('suggestRoll').textContent='در حال تحلیل تصویر...';
    fetch("{{ route('tablet.space.analyze-image') }}",{method:'POST',body:fd,headers:{Accept:'application/json'}}).then(r=>r.json()).then(result=>{
        if(!result.success){document.getElementById('suggestRoll').textContent='تحلیل انجام نشد';document.getElementById('cutInfo').textContent=result.message||'خطا';return;}
        const a=result.analysis||{};
        if(a.length!==null&&a.length!==undefined)document.getElementById('length').value=a.length;
        if(a.width!==null&&a.width!==undefined)document.getElementById('width').value=a.width;
        const l=Number(a.length),w=Number(a.width);if(l>0&&w>0)setArea(l*w);
        document.getElementById('suggestRoll').textContent='پلان شناسایی شد';document.getElementById('cutInfo').textContent='اطلاعات تصویر دریافت شد';
    }).catch(()=>{document.getElementById('suggestRoll').textContent='خطا در تحلیل';document.getElementById('cutInfo').textContent='ارتباط با سرور برقرار نشد';});
});

document.querySelector('form').addEventListener('submit',()=>{
    document.getElementById('hiddenName').value=document.getElementById('spaceNameText').value;
    document.getElementById('hiddenArea').value=document.getElementById('area').textContent;
    document.getElementById('hiddenDrawing').value=canvas.toDataURL('image/png');
    const rolls=rollRows().map(r=>({size:'3x'+r.querySelector('.roll-select').value,length:r.querySelector('.roll-select').value,count:r.querySelector('.roll-count').value}));
    document.getElementById('hiddenRoll').value=JSON.stringify(rolls);document.getElementById('hiddenRollCount').value=rolls.length;
});
resizeCanvas();window.addEventListener('resize',resizeCanvas);
window.DTZPolygonDebug={polygonAreaFromMeasuredSides,calculateIrregularArea,getLines:()=>lines};
})();
</script>
</body>
</html>
