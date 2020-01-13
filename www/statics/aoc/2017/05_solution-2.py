#!/usr/bin/env python3

import aoc
import itertools


rawinput = aoc.read_input(5)

instructions = list(map(lambda x: int(x), rawinput.splitlines()))

ilen = len(instructions)
pos = 0

for i in itertools.count(1):
    v = instructions[pos]
    instructions[pos] += -1 if v >= 3 else 1
    pos += v
    if pos < 0 or pos >= ilen:
        print(i)
        exit()
