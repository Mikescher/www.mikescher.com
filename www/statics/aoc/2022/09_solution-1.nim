import std/strutils
import std/sequtils
import system

type Pos = object
    X: int
    Y: int

type Rope = object
    Head: Pos
    Tail: Pos

proc move_rope(input: Rope, vec: Pos): Rope =
    var rope = input
    rope.Head.X += vec.X
    rope.Head.Y += vec.Y

    let deltaX = rope.Head.X - rope.Tail.X
    let deltaY = rope.Head.Y - rope.Tail.Y

    if not (abs(deltaX) >= 2 or abs(deltaY) >= 2): return rope

    if deltaX > 0:
        rope.Tail.X += 1
    elif deltaX < 0:
        rope.Tail.X -= 1

    if deltaY > 0:
        rope.Tail.Y += 1
    elif deltaY < 0:
        rope.Tail.Y -= 1

    return rope

proc print_rope(r: Rope, width: int, height: int) =
    for y in -height .. height:
        for x in -width .. width:
            let ishead = (x == r.Head.X and y == r.Head.Y)
            let istail = (x == r.Tail.X and y == r.Tail.Y)
            let iszero = (x == 0        and y == 0       )
            if ishead and istail:
                io.stdout.write "@"
            elif ishead:
                io.stdout.write "H"
            elif istail:
                io.stdout.write "T"
            elif iszero:
                io.stdout.write "s"
            else:
                io.stdout.write "."
        io.stdout.write "\n"
    io.stdout.write "\n"

proc run09_1(): string =
    const input = staticRead"../input/day09.txt"

    let lines = splitLines(input).filter(proc(p: string): bool = p != "")

    var rope = Rope(Head: Pos(X: 0, Y: 0), Tail: Pos(X: 0, Y: 0))

    var tailposmap = @[rope.Tail]

    # print_rope(rope, 200, 200)

    for line in lines:
        let dir = case line.split(" ")[0][0]:
            of 'U': Pos(X: 00, Y: -1)
            of 'D': Pos(X: 00, Y: +1)
            of 'L': Pos(X: -1, Y: 00)
            of 'R': Pos(X: +1, Y: 00)
            else:   Pos(X: 00, Y: 00)

        let cnt = parseInt(line.split(" ")[1])

        for _ in 0 ..< cnt:
            # echo "== ", line, " ==", "    (dir: [", dir.X, "|", dir.Y, "] )"

            rope = move_rope(rope, dir)

            tailposmap.add(rope.Tail)

            # print_rope(rope, 100, 100)
            #echo "[", rope.Tail.X, ";", rope.Tail.Y, "] -> [", rope.Head.X, ";", rope.Head.Y, "]"

    # echo tailposmap.deduplicate()

    return tailposmap.deduplicate().len().intToStr()


when not defined(js):
    echo run09_1()
else:
    proc js_run09_1(): cstring {.exportc.} =
        return cstring(run09_1())
