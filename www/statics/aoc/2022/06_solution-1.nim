import std/strutils
import std/sequtils

proc run06_1(): string =
    const input = staticRead"../input/day06.txt"

    let chars = input.toSeq()

    let idarr = (0 .. len(chars) - 4 - 1)
                .toSeq()
                .filter(proc(it: int):bool = chars[it .. it+3].deduplicate().len() == 4 )

    #echo ""
    #echo idarr
    #echo ""

    return intToStr(idarr[0] + 4)


when not defined(js):
    echo run06_1()
else:
    proc js_run06_1(): cstring {.exportc.} =
        return cstring(run06_1())
