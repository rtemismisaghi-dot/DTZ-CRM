function measuredPolygonArea(lines) {
    let x = 0;
    let y = 0;
    const points = [{ x, y }];

    for (const line of lines) {
        const dx = line.x2 - line.x1;
        const dy = line.y2 - line.y1;
        const pixelLength = Math.hypot(dx, dy);
        const meter = Number(line.meter);
        if (!Number.isFinite(meter) || meter <= 0 || pixelLength <= 0) return 0;
        x += (dx / pixelLength) * meter;
        y += (dy / pixelLength) * meter;
        points.push({ x, y });
    }

    points.pop();
    if (points.length < 3) return 0;

    let sum = 0;
    for (let i = 0; i < points.length; i++) {
        const a = points[i];
        const b = points[(i + 1) % points.length];
        sum += a.x * b.y - b.x * a.y;
    }
    return Math.abs(sum) / 2;
}

function assertNear(actual, expected, label) {
    if (Math.abs(actual - expected) > 1e-9) {
        throw new Error(`${label}: expected ${expected}, got ${actual}`);
    }
}

const square = [
    {x1:0,y1:0,x2:100,y2:0,meter:4},
    {x1:100,y1:0,x2:100,y2:100,meter:4},
    {x1:100,y1:100,x2:0,y2:100,meter:4},
    {x1:0,y1:100,x2:0,y2:0,meter:4}
];

const rectangle = [
    {x1:0,y1:0,x2:120,y2:0,meter:6},
    {x1:120,y1:0,x2:120,y2:60,meter:3},
    {x1:120,y1:60,x2:0,y2:60,meter:6},
    {x1:0,y1:60,x2:0,y2:0,meter:3}
];

// چهارضلعی نامنظم: نباید به مستطیل تبدیل شود حتی با اضلاع روبه‌روی برابر.
const irregularQuad = [
    {x1:0,y1:0,x2:120,y2:0,meter:6},
    {x1:120,y1:0,x2:100,y2:60,meter:Math.sqrt(10)},
    {x1:100,y1:60,x2:20,y2:60,meter:4},
    {x1:20,y1:60,x2:0,y2:0,meter:Math.sqrt(10)}
];

const pentagon = [
    {x1:0,y1:0,x2:100,y2:0,meter:4},
    {x1:100,y1:0,x2:160,y2:60,meter:Math.sqrt(8)},
    {x1:160,y1:60,x2:100,y2:120,meter:Math.sqrt(8)},
    {x1:100,y1:120,x2:0,y2:80,meter:Math.sqrt(4.16)},
    {x1:0,y1:80,x2:0,y2:0,meter:4}
];

assertNear(measuredPolygonArea(square), 16, 'square');
assertNear(measuredPolygonArea(rectangle), 18, 'rectangle');
assertNear(measuredPolygonArea(irregularQuad), 15, 'irregular quadrilateral');

const pentagonArea = measuredPolygonArea(pentagon);
if (!(pentagonArea > 0)) throw new Error('pentagon must have positive area');

const invalid = [...square.slice(0, 3), {...square[3], meter: 0}];
assertNear(measuredPolygonArea(invalid), 0, 'invalid zero-length measurement');

console.log('irregular polygon geometry regression tests passed');
