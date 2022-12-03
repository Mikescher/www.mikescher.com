import std/strutils
import std/sequtils

proc run03_2(): string =
    const input = staticRead"../input/day03.txt"

    var res = 0

    let lines = splitLines(input).filter(proc(p: string): bool = p != "")

    for lineSet in lines.distribute(int(lines.len/3)):

        let line1 = lineSet[0]
        let line2 = lineSet[1]
        let line3 = lineSet[2]

        let badge = line1.toSeq().filter(proc(p: char): bool = line2.contains(p) and line3.contains(p))[0]

        let prio = if int(badge) >= int('a'): int(badge) - int('a') + 1 else: int(badge) - int('A') + 27

        # echo badge, " : ", prio

        res += prio

    return intToStr(res)


when not defined(js):
    echo run03_2()
else:
    proc js_run03_2(): cstring {.exportc.} =
        return cstring(run03_2())
