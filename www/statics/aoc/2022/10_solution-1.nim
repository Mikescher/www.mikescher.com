import std/strutils
import std/sequtils


type Command = object
    cmd: string
    param: int


proc run10_1(): string =
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

    var sigsum = 0

    var regX = 1

    for i in 0 ..< len(prog):

        let before = regX

        let cycle = i+1

        if (cycle+20) mod 40 == 0:
            sigsum += (i+1) * regX

        if prog[i].cmd == "noop":
            discard
        elif prog[i].cmd == "addx":
            regX += prog[i].param
        else:
            quit "UNKNOWN OP"

        #echo "[", (i+1), "]: ", before, " -> ", regX, "   (", prog[i].cmd, " ", prog[i].param, ")"

    return intToStr(sigsum)


when not defined(js):
    echo run10_1()
else:
    proc js_run10_1(): cstring {.exportc.} =
        return cstring(run10_1())
