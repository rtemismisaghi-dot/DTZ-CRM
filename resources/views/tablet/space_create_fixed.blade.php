@include('tablet.space_create')

<script>
(function () {
    const fixedCanvas = document.getElementById('planCanvas');
    if (!fixedCanvas) return;

    let fixedDrawing = false;
    let fixedStart = null;

    function pointFromEvent(e) {
        const r = fixedCanvas.getBoundingClientRect();
        return { x: e.clientX - r.left, y: e.clientY - r.top };
    }

    function drawFixedPreview(a, b) {
        if (typeof redrawCanvas === 'function') redrawCanvas();
        const c = fixedCanvas.getContext('2d');
        c.beginPath();
        c.moveTo(a.x, a.y);
        c.lineTo(b.x, b.y);
        c.strokeStyle = 'black';
        c.lineWidth = 4;
        c.lineCap = 'round';
        c.stroke();
    }

    function redrawFixed() {
        if (typeof redrawCanvas === 'function') redrawCanvas();
    }

    function resetFixedState() {
        lines.length = 0;
        if (typeof dimensions !== 'undefined') dimensions.length = 0;
        shapeConfirmed = false;
        irregularMode = false;
        polygonClosed = false;
        fixedDrawing = false;
        fixedStart = null;
        document.getElementById('finishIrregularBtn').style.display = 'none';
        document.getElementById('suggestRoll').innerText = '-';
        document.getElementById('cutInfo').innerText = '-';
        document.getElementById('area').innerText = '0';
        document.getElementById('rollArea').innerText = '0';
        redrawFixed();
    }

    function askMeter() {
        const raw = prompt('متراژ این خط را وارد کنید (متر):');
        if (raw === null) return null;
        const value = parseFloat(String(raw).replace(',', '.'));
        return Number.isFinite(value) && value > 0 ? value : null;
    }

    function makeRectangle(first, second) {
        const ax = first.x1, ay = first.y1;
        const bx = first.x2, by = first.y2;
        const dx = bx - ax, dy = by - ay;
        const pixelLen = Math.hypot(dx, dy);
        if (pixelLen < 1) return false;

        const ux = dx / pixelLen;
        const uy = dy / pixelLen;
        let vx = -uy;
        let vy = ux;

        const mx = (second.x1 + second.x2) / 2;
        const my = (second.y1 + second.y2) / 2;
        const side = ((mx - ax) * vx + (my - ay) * vy) >= 0 ? 1 : -1;
        vx *= side;
        vy *= side;

        const widthPx = Math.max(30, Math.hypot(second.x2 - second.x1, second.y2 - second.y1));
        const bx2 = bx + vx * widthPx;
        const by2 = by + vy * widthPx;
        const ax2 = ax + vx * widthPx;
        const ay2 = ay + vy * widthPx;

        lines.length = 0;
        lines.push(
            { x1: ax,  y1: ay,  x2: bx,  y2: by,  meter: first.meter },
            { x1: bx,  y1: by,  x2: bx2, y2: by2, meter: second.meter },
            { x1: bx2, y1: by2, x2: ax2, y2: ay2, meter: first.meter },
            { x1: ax2, y1: ay2, x2: ax,  y2: ay,  meter: second.meter }
        );

        shapeConfirmed = true;
        irregularMode = false;
        polygonClosed = true;
        document.getElementById('finishIrregularBtn').style.display = 'none';

        const lengthInput = document.getElementById('length');
        const widthInput = document.getElementById('width');
        if (lengthInput) lengthInput.value = first.meter;
        if (widthInput) widthInput.value = second.meter;

        if (typeof calculateArea === 'function') calculateArea();
        if (typeof suggestRollSize === 'function') suggestRollSize();

        document.getElementById('cutInfo').innerText =
            `مستطیل واقعی: ${first.meter} × ${second.meter} متر`;
        document.getElementById('suggestRoll').innerText =
            `${first.meter} × ${second.meter} متر`;
        redrawFixed();
        return true;
    }

    fixedCanvas.addEventListener('pointerdown', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        fixedCanvas.setPointerCapture(e.pointerId);
        fixedStart = pointFromEvent(e);
        fixedDrawing = true;
    }, true);

    fixedCanvas.addEventListener('pointermove', function (e) {
        if (!fixedDrawing) return;
        e.preventDefault();
        e.stopImmediatePropagation();
        drawFixedPreview(fixedStart, pointFromEvent(e));
    }, true);

    fixedCanvas.addEventListener('pointerup', function (e) {
        if (!fixedDrawing) return;
        e.preventDefault();
        e.stopImmediatePropagation();
        fixedDrawing = false;

        const end = pointFromEvent(e);
        if (Math.hypot(end.x - fixedStart.x, end.y - fixedStart.y) < 10) {
            redrawFixed();
            return;
        }

        const meter = askMeter();
        if (meter === null) {
            redrawFixed();
            return;
        }

        const line = { x1: fixedStart.x, y1: fixedStart.y, x2: end.x, y2: end.y, meter };
        lines.push(line);
        redrawFixed();

        if (lines.length === 1) {
            document.getElementById('cutInfo').innerText = 'ضلع اول ثبت شد؛ ضلع دوم را رسم کنید';
            document.getElementById('suggestRoll').innerText = `${meter} متر`;
            return;
        }

        if (lines.length === 2 && !shapeConfirmed && !irregularMode) {
            const answer = confirm('آیا این فضا مربع یا مستطیل است؟');
            if (answer) {
                makeRectangle(lines[0], lines[1]);
            } else {
                irregularMode = true;
                document.getElementById('suggestRoll').innerText = 'فضای نامنظم';
                document.getElementById('cutInfo').innerText = 'ضلع بعدی را رسم کنید';
                document.getElementById('finishIrregularBtn').style.display = 'block';
            }
        }
    }, true);

    fixedCanvas.addEventListener('pointercancel', function (e) {
        fixedDrawing = false;
        e.stopImmediatePropagation();
    }, true);

    document.getElementById('clearBtn')?.addEventListener('click', function (e) {
        e.stopImmediatePropagation();
        resetFixedState();
    }, true);

    document.getElementById('finishIrregularBtn')?.addEventListener('click', function (e) {
        if (!irregularMode || lines.length < 3) return;
        e.stopImmediatePropagation();
        const first = lines[0];
        const last = lines[lines.length - 1];
        if (Math.hypot(last.x2 - first.x1, last.y2 - first.y1) > 1) {
            lines.push({ x1: last.x2, y1: last.y2, x2: first.x1, y2: first.y1, meter: askMeter() });
        }
        polygonClosed = true;
        irregularMode = false;
        if (typeof calculateIrregularArea === 'function') calculateIrregularArea();
        document.getElementById('finishIrregularBtn').style.display = 'none';
        document.getElementById('cutInfo').innerText = 'پلان نامنظم بسته شد';
        redrawFixed();
    }, true);
})();
</script>
