import std/strutils
import std/algorithm

proc run01_2(): string =
    const input = staticRead"../input/day01.txt"

    var elves = newSeq[int]()

    var counter = 0

    for line in splitLines(input):
        if line == "":
            elves.add(counter)
            counter = 0
        else:
            counter += parseInt(line)

    elves.sort(system.cmp, Descending)

    return intToStr(elves[0]+elves[1]+elves[2])

when not defined(js):
    echo run01_2()
else:
    proc js_run01_2(): cstring {.exportc.} =
        return cstring(run01_2())
