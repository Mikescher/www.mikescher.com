#!/usr/bin/env python3

import aoc


rawinput = aoc.read_input(6)

mem = list(map(lambda x: int(x), rawinput.split('\t')))

visited = set()

while True:
    key = ";".join(map(lambda x: str(x), mem))
    # print(mem)
    if key in visited:
        print(len(visited))
        exit(0)
    visited.add(key)

    idx = mem.index(max(mem))
    val = mem[idx]
    mem[idx] = 0
    for i in range(val):
        mem[(idx+i+1) % len(mem)] += 1
