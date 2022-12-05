import std/strutils
import std/sequtils
import std/algorithm

proc run05_1(): string =
    const input = staticRead"../input/day05.txt"

    let lines = splitLines(input).filter(proc(p: string): bool = p != "")

    let stackcount = lines.filter(proc(p:string): bool = p.startsWith(" 1 "))[0].toSeq().filter(proc(p: char): bool = p != ' ').len()

    #echo stackcount

    var stacks = newSeq[seq[char]](0)
    for sidx in 0..(stackcount-1):
        stacks.add(newSeq[char](0))

    var headerLen = 0

    for line in lines:
        if line.startsWith(" 1 "):
            break
        headerLen += 1
        for sidx in 0..(len(stacks)-1):
            let chr = line[1 + 4 * sidx]
            if chr != ' ':
                stacks[sidx].add(chr)

    for i in 0..(stackcount-1):
        stacks[i].reverse()

    #echo stacks

    for line in lines[headerLen+1..len(lines)-1]:
        let split = line.split(" ")

        let cnt = parseInt(split[1])
        let src = parseInt(split[3])-1
        let dst = parseInt(split[5])-1

        #echo "move", cnt, " : ", src, " -> ", dst

        for _ in 1..cnt:
            let chr = stacks[src][len(stacks[src]) - 1]
            stacks[src].delete(len(stacks[src]) - 1)
            stacks[dst].add(chr)


    #echo stacks

    let heads = stacks.map(proc(p:seq[char]): char = p[p.len()-1])

    #echo heads

    return cast[string](heads)


when not defined(js):
    echo run05_1()
else:
    proc js_run05_1(): cstring {.exportc.} =
        return cstring(run05_1())
