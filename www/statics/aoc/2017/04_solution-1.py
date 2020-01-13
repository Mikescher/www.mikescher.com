#!/usr/bin/env python3

import aoc


rawinput = aoc.read_input(4)

rcount = 0
for line in rawinput.splitlines():
    if len(set(line.split(' '))) == len(line.split(' ')):
        rcount += 1
print(rcount)

