@include('tablet.space_create')

<script>
// DTZ Agent override: rectangle geometry is rebuilt from the two measured sides.
// The hand-drawn second line is used only to determine which side of the first
// line the rectangle should occupy. Its pixel length/angle never becomes the
// real dimension.
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

    // Find which endpoint of the second stroke is connected to the first
    // stroke. Once that endpoint is selected, the other endpoint is always
    // the far endpoint; this prevents a wrong pairing that can place the new
    // side on top of the previous side.
    const endpointCandidates = [
        { point: A, other: P, distance: distance(A, P) },
        { point: A, other: Q, distance: distance(A, Q) },
        { point: B, other: P, distance: distance(B, P) },
        { point: B, other: Q, distance: distance(B, Q) }
    ];

    endpointCandidates.sort((a, b) => a.distance - b.distance);

    const connectedPoint = endpointCandidates[0].point;

    const dx = B.x - A.x;
    const dy = B.y - A.y;
    const firstPixelLength = Math.hypot(dx, dy);

    if(firstPixelLength <= 0){
        return;
    }

    // Exact perpendicular to the first side.
    let perpX = -dy / firstPixelLength;
    let perpY =  dx / firstPixelLength;

    // Use the midpoint of the drawn second line only to choose the side.
    // This is stable even if the user draws the second line almost on top of
    // the first line or with an arbitrary angle.
    const midpointX = (P.x + Q.x) / 2;
    const midpointY = (P.y + Q.y) / 2;

    const sideX = midpointX - connectedPoint.x;
    const sideY = midpointY - connectedPoint.y;

    if((sideX * perpX + sideY * perpY) < 0){
        perpX *= -1;
        perpY *= -1;
    }

    // Real entered dimensions control the final rectangle. The drawn pixel
    // length of line2 is deliberately ignored.
    const widthPixels =
        firstPixelLength * (line2.meter / line1.meter);

    const offsetX = perpX * widthPixels;
    const offsetY = perpY * widthPixels;

    const C = {
        x: B.x + offsetX,
        y: B.y + offsetY
    };

    const D = {
        x: A.x + offsetX,
        y: A.y + offsetY
    };

    // Always replace the two temporary strokes with one clean closed path.
    // A -> B -> C -> D -> A guarantees that opposite sides are exactly
    // parallel/equal and prevents a generated edge from landing on an old
    // edge.
    lines = [
        {
            x1: A.x,
            y1: A.y,
            x2: B.x,
            y2: B.y,
            meter: line1.meter
        },
        {
            x1: B.x,
            y1: B.y,
            x2: C.x,
            y2: C.y,
            meter: line2.meter
        },
        {
            x1: C.x,
            y1: C.y,
            x2: D.x,
            y2: D.y,
            meter: line1.meter
        },
        {
            x1: D.x,
            y1: D.y,
            x2: A.x,
            y2: A.y,
            meter: line2.meter
        }
    ];

    // Clear the temporary drawing and render only the final rectangle.
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
