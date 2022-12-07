import std/strutils
import std/sequtils
import std/algorithm
import std/re

type
  DirEntry = ref object
    parent: DirEntry
    name: string
    dirs: seq[DirEntry]
    files: seq[FileEntry]
  FileEntry = ref object
    name: string
    size: int


proc mkcd(a: DirEntry, name: string): DirEntry =
  for i in 0.. (a.dirs.len() - 1):
    if a.dirs[i].name == name:
        return a.dirs[i]
  a.dirs.add(DirEntry(parent: a, name: name, dirs: @[], files: @[]))
  return a.dirs[len(a.dirs)-1]

proc recursive_size(a: DirEntry): int =
    var sz = 0
    for d in a.dirs:
        sz += d.recursive_size()
    for f in a.files:
        sz += f.size
    return sz

proc sum_size_sub(a: DirEntry, max: int): int =
    let sz = a.recursive_size()
    var res = 0
    if sz < max:
        res += sz
    for d in a.dirs:
        res += d.sum_size_sub(max)
    return res

proc print(a: DirEntry, indent: int) =
    echo ' '.repeat(indent*2), a.name, " (sz = ", a.recursive_size(), " )"
    echo ' '.repeat(indent*2), "{"
    for f in a.files:
        echo ' '.repeat(indent*2+2), "[F] ", f.name, " (sz = ", f.size, " )"
    for d in a.dirs:
        d.print(indent+1)
    echo ' '.repeat(indent*2), "}"

proc collect_dirs(a: DirEntry, coll: var seq[DirEntry]) =
    coll.add(a)
    for d in a.dirs:
        coll.add(d)
        d.collect_dirs(coll)


proc run07_2(): string =
    const input = staticRead"../input/day07.txt"

    let lines = splitLines(input).filter(proc(p: string): bool = p != "")

    var root = DirEntry(parent: nil, name: "/", dirs: @[], files: @[])

    var curr = root

    for line in lines:
        if line == "$ cd ..":
            curr = curr.parent
        elif line.startsWith("$ cd "):
            curr = curr.mkcd(line.substr(5))
        elif line == "$ ls":
            continue
        elif line.startsWith("dir "):
            discard curr.mkcd(line.substr(4))
        elif line.match(re"^[0-9].*"):
            let split = line.split(" ")
            curr.files.add(FileEntry(name: split[1], size: parseInt(split[0])))
        else:
            echo "UNKNOWN LINE: " & line


    # echo root.recursive_size()

    # root.print(0)

    var dirs: seq[DirEntry] = @[]
    root.collect_dirs(dirs)

    proc scmp(a, b: DirEntry): int =
        if a.recursive_size() < b.recursive_size(): -1
        else: 1

    dirs.sort(scmp)

    let min_size = -(70000000 - 30000000 - root.recursive_size())

    # echo min_size

    for d in dirs:
        if d.recursive_size() > min_size:
            return intToStr(d.recursive_size())

    return "ERR"


when not defined(js):
    echo run07_2()
else:
    proc js_run07_2(): cstring {.exportc.} =
        return cstring(run07_2())
