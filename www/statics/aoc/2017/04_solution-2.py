#!/usr/bin/env python3

import aoc


rawinput = aoc.read_input(4)

rcount = 0
for line in rawinput.splitlines():
    words = list(map(lambda x: "".join(sorted(list(x))), line.split(' ')))
    if len(set(words)) == len(words):
        rcount += 1
print(rcount)

