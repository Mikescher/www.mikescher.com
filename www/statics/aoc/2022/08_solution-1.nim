import std/strutils
import std/sequtils

proc grid_hidden(grid: seq[seq[int]], cx: int, cy: int, width: int, height: int): bool =
    let cv = grid[cy][cx]

    if cx == 0 or cy == 0 or cx == width-1 or cy == height-1:
        return false

    if not (cx+1 ..< width).toSeq().any(proc(x:int):bool = grid[cy][x] >= cv):
        return false

    if not (0 ..< cx).toSeq().any(proc(x:int):bool = grid[cy][x] >= cv):
        return false

    if not (cy+1 ..< height).toSeq().any(proc(y:int):bool = grid[y][cx] >= cv):
        return false

    if not (0 ..< cy).toSeq().any(proc(y:int):bool = grid[y][cx] >= cv):
        return false

    return true


proc run08_1(): string =
    const input = staticRead"../input/day08.txt"

    let grid = splitLines(input)
                .filterIt(it != "")
                .mapIt(it.toSeq().map(proc(p:char):int = parseInt(p.repeat(1))))

    # echo grid

    let width = grid[0].len()
    let height = grid.len()

    # echo width, "x", height

    var visible = 0

    for y in 0 ..< height:
        for x in 0 ..< width:
            let hidden = grid_hidden(grid, x, y, width, height)
            #if hidden:
            #    io.stdout.write "#"
            #else:
            #    io.stdout.write "."
            if not hidden: visible += 1
        #io.stdout.write "\n"


    return intToStr(visible)


when not defined(js):
    echo run08_1()
else:
    proc js_run08_1(): cstring {.exportc.} =
        return cstring(run08_1())
