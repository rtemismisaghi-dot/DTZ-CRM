/*
 * DTZ Carpet Roll Calculation - exhaustive test harness
 *
 * Rules:
 * - Carpet roll width is always 3m.
 * - Roll lengths are integer values from 1m to 15m.
 * - Room dimensions may be decimal (0.1m grid in exhaustive mode).
 * - For widths 5.5..6, 8.5..9 and 11.5..12 we may treat the width as
 *   2, 3 and 4 strips of 3m respectively, then combine their lengths.
 * - When combined length is >15m, split it into the smallest possible
 *   number of integer roll lengths 1..15; for equal piece count, choose
 *   the lowest total roll length.  Example: 17 -> 9+8, not 15+2.
 *
 * NOTE: The 4x4 business rule is intentionally preserved as 3x6:
 * 3x4 + 3x1 + 3x1. This is the project's cutting heuristic, not a
 * geometric claim that a 4x1 physical piece can be cut from a 3m roll.
 */

function nearlyEqual(a, b, eps = 1e-9) {
    return Math.abs(a - b) <= eps;
}

function getStripCount(width) {
    if (width <= 3) return 1;
    if (width >= 5.5 && width <= 6) return 2;
    if (width >= 8.5 && width <= 9) return 3;
    if (width >= 11.5 && width <= 12) return 4;
    return Math.ceil(width / 3);
}

function getCombinedLength(width, length) {
    // Established project heuristic for widths between 3 and 5.5m.
    // 4x4 => 3x6 (3x4 + 3x1 + 3x1).
    if (width > 3 && width < 5.5) {
        return Math.ceil(length) + 2;
    }

    const strips = getStripCount(width);
    return Math.ceil(strips * length - 1e-9);
}

function splitRollLength(totalLength) {
    const target = Math.ceil(totalLength - 1e-9);

    if (target <= 0) {
        return [];
    }

    const pieceCount = Math.ceil(target / 15);
    const base = Math.floor(target / pieceCount);
    const extra = target % pieceCount;

    // Balanced split gives the minimum possible piece count and avoids
    // unnecessary tiny pieces. Example: 17 => 9+8.
    const pieces = [];

    for (let i = 0; i < pieceCount; i++) {
        pieces.push(base + (i < extra ? 1 : 0));
    }

    pieces.sort((a, b) => b - a);
    return pieces;
}

function calculateRollPlan(width, length) {
    if (!Number.isFinite(width) || !Number.isFinite(length) || width <= 0 || length <= 0) {
        throw new Error('Invalid room dimensions');
    }

    const strips = getStripCount(width);
    const combinedLength = getCombinedLength(width, length);
    const rollLengths = splitRollLength(combinedLength);

    const rollArea = rollLengths.reduce((sum, rollLength) => sum + (3 * rollLength), 0);
    const roomArea = width * length;
    const waste = rollArea - roomArea;

    return {
        width,
        length,
        strips,
        combinedLength,
        rollLengths,
        rollArea,
        roomArea,
        waste,
    };
}

function assert(condition, message) {
    if (!condition) {
        throw new Error(message);
    }
}

function runKnownCases() {
    const a = calculateRollPlan(4, 4);
    assert(a.rollLengths.length === 1 && a.rollLengths[0] === 6,
        `4x4 expected 3x6, got 3x${a.rollLengths.join('+3x')}`);

    const b = calculateRollPlan(5.87, 7);
    assert(b.combinedLength === 14,
        `5.87x7 expected combined length 14, got ${b.combinedLength}`);
    assert(b.rollLengths.length === 1 && b.rollLengths[0] === 14,
        `5.87x7 expected 3x14, got ${b.rollLengths.join('+3x')}`);

    const c = calculateRollPlan(5.9, 8.5);
    assert(c.combinedLength === 17,
        `5.9x8.5 expected combined length 17, got ${c.combinedLength}`);
    assert(c.rollLengths.length === 2 && c.rollLengths[0] === 9 && c.rollLengths[1] === 8,
        `5.9x8.5 expected 3x9 + 3x8, got ${c.rollLengths.join('+3x')}`);

    return true;
}

function runExhaustiveLoop(maxDimension = 500, step = 0.1) {
    let cases = 0;
    let failures = [];

    // Integer-scaled loop avoids floating point accumulation (e.g. 0.1+0.1...).
    const maxTick = Math.round(maxDimension / step);

    for (let widthTick = 1; widthTick <= maxTick; widthTick++) {
        const width = Number((widthTick * step).toFixed(10));

        for (let lengthTick = 1; lengthTick <= maxTick; lengthTick++) {
            const length = Number((lengthTick * step).toFixed(10));
            cases++;

            try {
                const plan = calculateRollPlan(width, length);

                assert(plan.rollLengths.length >= 1,
                    `no rolls for ${width}x${length}`);
                assert(plan.rollLengths.every(x => Number.isInteger(x) && x >= 1 && x <= 15),
                    `invalid roll length for ${width}x${length}`);
                assert(plan.rollArea + 1e-9 >= plan.roomArea,
                    `under-coverage for ${width}x${length}: ${plan.rollArea} < ${plan.roomArea}`);
                assert(plan.waste >= -1e-9,
                    `negative waste for ${width}x${length}`);

                // Explicit special-range checks.
                if (width >= 5.5 && width <= 6) {
                    assert(plan.strips === 2, `5.5..6 must use 2 strips: ${width}x${length}`);
                }
                if (width >= 8.5 && width <= 9) {
                    assert(plan.strips === 3, `8.5..9 must use 3 strips: ${width}x${length}`);
                }
                if (width >= 11.5 && width <= 12) {
                    assert(plan.strips === 4, `11.5..12 must use 4 strips: ${width}x${length}`);
                }
            } catch (error) {
                if (failures.length < 20) {
                    failures.push(error.message);
                }
            }
        }
    }

    return { cases, failures };
}

if (typeof module !== 'undefined') {
    module.exports = {
        calculateRollPlan,
        splitRollLength,
        runKnownCases,
        runExhaustiveLoop,
    };
}

// Run known cases when executed directly with Node.
if (typeof require !== 'undefined' && require.main === module) {
    runKnownCases();
    const result = runExhaustiveLoop(500, 0.1);
    console.log(`DTZ roll exhaustive test: ${result.cases.toLocaleString()} cases`);

    if (result.failures.length) {
        console.error('FAIL');
        result.failures.forEach(message => console.error(message));
        process.exit(1);
    }

    console.log('PASS');
}
