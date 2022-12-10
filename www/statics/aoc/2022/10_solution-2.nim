import std/strutils
import std/sequtils


type Command = object
    cmd: string
    param: int


proc run10_2(): string =
    const input = staticRead"../input/day10.txt"

    let lines = splitLines(input).filter(proc(p: string): bool = p != "")

    var prog: seq[Command] = @[]

    for line in lines:
        let cmd = line.split(" ")[0]
        if cmd == "addx":
            prog.add(Command(cmd: "noop", param: 0))
            prog.add(Command(cmd: "addx", param: parseInt(line.split(" ")[1])))
        elif cmd == "noop":
            prog.add(Command(cmd: "noop", param: 0))
        else:
            quit "UNKNOWN OP"

    #for p in prog: echo p

    var output = ""

    var regX = 1

    for i in 0 ..< len(prog):

        let before = regX

        let hpos = i mod 40

        let spos = regX

        let lit = abs(spos - hpos) <= 1

        if prog[i].cmd == "noop":
            discard
        elif prog[i].cmd == "addx":
            regX += prog[i].param
        else:
            quit "UNKNOWN OP"

        if lit:
            output &= "#"
        else:
            output &= " "

        #echo "[", (i+1), "]: ", before, " -> ", regX, "   (", prog[i].cmd, " ", prog[i].param, ")"

    return (0 ..< 6).mapIt(output.substr(it * 40, it*40 + 39)).join("\n")

when not defined(js):
    echo run10_2()
else:
    proc js_run10_2(): cstring {.exportc.} =
        return cstring(run10_2())
