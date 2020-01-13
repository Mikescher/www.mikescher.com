#!/usr/bin/env python3

import aoc


rawinput = aoc.read_input(2)

result = 0
for line in rawinput.splitlines():
    values = list(map(lambda d: int(d), line.split('\t')))
    for v1 in values:
        for v2 in values:
            if v1 == v2:
                continue
            if v1 % v2 == 0:
                result = result + v1//v2

print(result)
