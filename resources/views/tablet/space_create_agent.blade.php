@include('tablet.space_create')

<script>
// DTZ Agent override: build a true rectangle from the first two measured sides.
// The drawn direction is used only to choose the side of the first edge;
// the entered meter values control the final geometry.
function createRectangleFromTwoLines(){

    if(lines.length < 2){
        return;
    }

    const line1 = lines[0];
    const line2 = lines[1];

    if(!line1.meter || !line2.meter || line1.meter <= 0 || line2.meter <= 0){
        return;
    }

    const A = { x: line1.x1, y: line1.y1 };
    const B = { x: line1.x2, y: line1.y2 };
    const P = { x: line2.x1, y: line2.y1 };
    const Q = { x: line2.x2, y: line2.y2 };

    const candidates = [
        { connected: A, far: Q, distance: distance(A, P) },
        { connected: A, far: P, distance: distance(A, Q) },
        { connected: B, far: Q, distance: distance(B, P) },
        { connected: B, far: P, distance: distance(B, Q) }
    ];

    candidates.sort((a, b) => a.distance - b.distance);

    const connectedPoint = candidates[0].connected;
    const farPoint = candidates[0].far;

    const dx = B.x - A.x;
    const dy = B.y - A.y;
    const firstPixelLength = Math.hypot(dx, dy);

    if(firstPixelLength <= 0){
        return;
    }

    const ux = dx / firstPixelLength;
    const uy = dy / firstPixelLength;

    // Always make the second pair of sides exactly perpendicular to side one.
    let perpX = -uy;
    let perpY = ux;

    const sideX = farPoint.x - connectedPoint.x;
    const sideY = farPoint.y - connectedPoint.y;

    if((sideX * perpX + sideY * perpY) < 0){
        perpX *= -1;
        perpY *= -1;
    }

    // Scale the visual width from the real entered dimensions.
    // This prevents the hand-drawn pixel length from changing the real shape.
    const widthPixels =
        firstPixelLength * (line2.meter / line1.meter);

    const offsetX = perpX * widthPixels;
    const offsetY = perpY * widthPixels;

    let C, D;

    if(connectedPoint === A){
        D = {
            x: A.x + offsetX,
            y: A.y + offsetY
        };

        C = {
            x: B.x + offsetX,
            y: B.y + offsetY
        };
    }else{
        C = {
            x: B.x + offsetX,
            y: B.y + offsetY
        };

        D = {
            x: A.x + offsetX,
            y: A.y + offsetY
        };
    }

    // Keep the four edges in one continuous order.
    if(connectedPoint === A){
        lines = [
            { x1:A.x, y1:A.y, x2:B.x, y2:B.y, meter:line1.meter },
            { x1:B.x, y1:B.y, x2:C.x, y2:C.y, meter:line2.meter },
            { x1:C.x, y1:C.y, x2:D.x, y2:D.y, meter:line1.meter },
            { x1:D.x, y1:D.y, x2:A.x, y2:A.y, meter:line2.meter }
        ];
    }else{
        lines = [
            { x1:A.x, y1:A.y, x2:B.x, y2:B.y, meter:line1.meter },
            { x1:B.x, y1:B.y, x2:C.x, y2:C.y, meter:line2.meter },
            { x1:C.x, y1:C.y, x2:D.x, y2:D.y, meter:line1.meter },
            { x1:D.x, y1:D.y, x2:A.x, y2:A.y, meter:line2.meter }
        ];
    }

    redrawCanvas();

    const lengthInput = document.getElementById('length');
    const widthInput = document.getElementById('width');

    if(lengthInput){
        lengthInput.value = line1.meter;
    }

    if(widthInput){
        widthInput.value = line2.meter;
    }

    if(typeof calculateArea === 'function'){
        calculateArea();
    }
}
</script>
