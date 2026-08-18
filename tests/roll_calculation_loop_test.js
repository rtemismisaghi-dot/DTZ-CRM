/* DTZ roll calculation exhaustive test: 3m fixed width, lengths 1..15. */
function getStripCount(width) {
    if (width <= 3) return 1;
    if (width >= 5.5 && width <= 6) return 2;
    if (width >= 8.5 && width <= 9) return 3;
    if (width >= 11.5 && width <= 12) return 4;
    return Math.ceil(width / 3);
}

function getCombinedLength(width, length) {
    // For 3 < width < 5.5, convert the required room area into an
    // equivalent 3m-roll length. This preserves 4x4 => 3x6.
    if (width > 3 && width < 5.5) {
        return Math.ceil((width * length) / 3 - 1e-9);
    }

    // Near 6/9/12m widths, combine the 3m-strip lengths first.
    return Math.ceil(getStripCount(width) * length - 1e-9);
}

function splitRollLength(totalLength) {
    const target = Math.ceil(totalLength - 1e-9);
    if (target <= 0) return [];

    // Minimum possible number of pieces, then balanced lengths.
    // 17 => 9+8, never 15+2.
    const count = Math.ceil(target / 15);
    const base = Math.floor(target / count);
    const extra = target % count;
    const parts = [];

    for (let i = 0; i < count; i++) {
        parts.push(base + (i < extra ? 1 : 0));
    }

    return parts.sort((a, b) => b - a);
}

function calculateRollPlan(width, length) {
    if (!Number.isFinite(width) || !Number.isFinite(length) || width <= 0 || length <= 0) {
        throw new Error('Invalid dimensions');
    }

    const strips = getStripCount(width);
    const combinedLength = getCombinedLength(width, length);
    const rollLengths = splitRollLength(combinedLength);
    const rollArea = rollLengths.reduce((sum, x) => sum + 3 * x, 0);
    const roomArea = width * length;

    return {
        width,
        length,
        strips,
        combinedLength,
        rollLengths,
        rollArea,
        roomArea,
        waste: rollArea - roomArea,
    };
}

function assert(condition, message) {
    if (!condition) throw new Error(message);
}

function runKnownCases() {
    const a = calculateRollPlan(4, 4);
    assert(a.rollLengths.join(',') === '6', `4x4 expected 3x6, got ${a.rollLengths}`);

    const b = calculateRollPlan(5.87, 7);
    assert(b.combinedLength === 14, `5.87x7 expected 14, got ${b.combinedLength}`);
    assert(b.rollLengths.join(',') === '14', `5.87x7 expected 3x14, got ${b.rollLengths}`);

    const c = calculateRollPlan(5.9, 8.5);
    assert(c.combinedLength === 17, `5.9x8.5 expected 17, got ${c.combinedLength}`);
    assert(c.rollLengths.join(',') === '9,8', `5.9x8.5 expected 3x9 + 3x8, got ${c.rollLengths}`);
}

function runExhaustiveLoop(maxDimension = 500, step = 0.1) {
    let cases = 0;
    const failures = [];
    const maxTick = Math.round(maxDimension / step);

    for (let wTick = 1; wTick <= maxTick; wTick++) {
        const width = Number((wTick * step).toFixed(10));

        for (let lTick = 1; lTick <= maxTick; lTick++) {
            const length = Number((lTick * step).toFixed(10));
            cases++;

            try {
                const plan = calculateRollPlan(width, length);
                assert(plan.rollLengths.length > 0, `no roll: ${width}x${length}`);
                assert(plan.rollLengths.every(x => Number.isInteger(x) && x >= 1 && x <= 15),
                    `bad roll length: ${width}x${length}`);
                assert(plan.rollArea + 1e-9 >= plan.roomArea,
                    `under coverage: ${width}x${length}`);
                assert(plan.waste >= -1e-9, `negative waste: ${width}x${length}`);
            } catch (e) {
                if (failures.length < 20) failures.push(e.message);
            }
        }
    }

    return { cases, failures };
}

if (typeof module !== 'undefined') {
    module.exports = { calculateRollPlan, splitRollLength, runKnownCases, runExhaustiveLoop };
}

if (typeof require !== 'undefined' && require.main === module) {
    runKnownCases();
    const result = runExhaustiveLoop(500, 0.1);
    console.log(`DTZ exhaustive roll test: ${result.cases.toLocaleString()} cases`);
    if (result.failures.length) {
        console.error('FAIL');
        result.failures.forEach(x => console.error(x));
        process.exit(1);
    }
    console.log('PASS');
}
