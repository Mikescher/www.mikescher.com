import std/strutils
import std/sequtils

proc run06_2(): string =
    const input = staticRead"../input/day06.txt"

    let chars = input.toSeq()

    let idarr = (0 .. len(chars) - 14 - 1)
                .toSeq()
                .filter(proc(it: int):bool = chars[it .. it+ 3].deduplicate().len() ==  4 )
                .filter(proc(it: int):bool = chars[it .. it+13].deduplicate().len() == 14 )

    #echo ""
    #echo idarr
    #echo ""

    return intToStr(idarr[0] + 14)

when not defined(js):
    echo run06_2()
else:
    proc js_run06_2(): cstring {.exportc.} =
        return cstring(run06_2())
