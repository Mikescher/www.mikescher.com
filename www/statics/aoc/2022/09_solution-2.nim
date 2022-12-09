import std/strutils
import std/sequtils
import system

type Pos = object
    X: int
    Y: int

type Rope = object
    Knots: array[10, Pos]

proc move_rope(input: Rope, vec: Pos): Rope =
    var rope = input

    rope.Knots[0].X += vec.X
    rope.Knots[0].Y += vec.Y

    for i in 0 ..< 9:

        let deltaX = rope.Knots[i].X - rope.Knots[i+1].X
        let deltaY = rope.Knots[i].Y - rope.Knots[i+1].Y

        if not (abs(deltaX) >= 2 or abs(deltaY) >= 2): return rope

        if deltaX > 0:
            rope.Knots[i+1].X += 1
        elif deltaX < 0:
            rope.Knots[i+1].X -= 1

        if deltaY > 0:
            rope.Knots[i+1].Y += 1
        elif deltaY < 0:
            rope.Knots[i+1].Y -= 1

    return rope

proc run09_2(): string =
    const input = staticRead"../input/day09.txt"

    let lines = splitLines(input).filter(proc(p: string): bool = p != "")

    let Z = Pos(X: 0, Y: 0)

    var rope = Rope(Knots: [Z, Z, Z, Z, Z, Z, Z, Z, Z, Z])

    var tailposmap = @[rope.Knots[9]]

    for line in lines:
        let dir = case line.split(" ")[0][0]:
            of 'U': Pos(X: 00, Y: -1)
            of 'D': Pos(X: 00, Y: +1)
            of 'L': Pos(X: -1, Y: 00)
            of 'R': Pos(X: +1, Y: 00)
            else:   Pos(X: 00, Y: 00)

        let cnt = parseInt(line.split(" ")[1])

        for _ in 0 ..< cnt:
            rope = move_rope(rope, dir)

            tailposmap.add(rope.Knots[9])

    return tailposmap.deduplicate().len().intToStr()

when not defined(js):
    echo run09_2()
else:
    proc js_run09_2(): cstring {.exportc.} =
        return cstring(run09_2())
