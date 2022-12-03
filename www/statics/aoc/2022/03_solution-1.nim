import std/strutils
import std/sequtils

proc run03_1(): string =
    const input = staticRead"../input/day03.txt"

    var res = 0

    for line in splitLines(input):
        if line == "":
            continue

        let comp1 = line.substr(0, int(line.len/2))
        let comp2 = line.substr(int(line.len/2))

        let dup = comp1.toSeq().filter(proc(p: char): bool =  comp2.contains(p))[0]
        let prio = if int(dup) >= int('a'): int(dup) - int('a') + 1 else: int(dup) - int('A') + 27

        #echo dup, " : ", prio

        res += prio

    return intToStr(res)


when not defined(js):
    echo run03_1()
else:
    proc js_run03_1(): cstring {.exportc.} =
        return cstring(run03_1())
