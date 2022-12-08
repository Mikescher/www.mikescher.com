import std/strutils
import std/sequtils

proc direction_score(grid: seq[seq[int]], icx: int, icy: int, width: int, height: int, dx: int, dy: int): int =
    let v = grid[icy][icx]
    var cx = icx
    var cy = icy
    var c = 0
    while true:
        cx += dx
        cy += dy
        if cx < 0 or cy < 0 or cx >= width or cy >= height:
            return c
        c += 1
        if grid[cy][cx] >= v:
            return c

proc scenic_score(grid: seq[seq[int]], cx: int, cy: int, width: int, height: int): int =
    let x_pos = direction_score(grid, cx, cy, width, height, +1, 00)
    let x_neg = direction_score(grid, cx, cy, width, height, -1, 00)
    let y_pos = direction_score(grid, cx, cy, width, height, 00, +1)
    let y_neg = direction_score(grid, cx, cy, width, height, 00, -1)

    return x_pos * x_neg * y_pos * y_neg



proc run08_2(): string =
    const input = staticRead"../input/day08.txt"

    let grid = splitLines(input)
                .filterIt(it != "")
                .mapIt(it.toSeq().map(proc(p:char):int = parseInt(p.repeat(1))))

    # echo grid

    let width = grid[0].len()
    let height = grid.len()

    # echo width, "x", height

    var max_score = 0

    for y in 0 ..< height:
        for x in 0 ..< width:
            let ss = scenic_score(grid, x, y, width, height)
            # echo "[", x, ",", y, "]: ", ss
            if ss > max_score: max_score = ss


    return intToStr(max_score)


when not defined(js):
    echo run08_2()
else:
    proc js_run08_2(): cstring {.exportc.} =
        return cstring(run08_2())
