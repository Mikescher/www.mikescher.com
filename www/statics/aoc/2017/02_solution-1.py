#!/usr/bin/env python3

import aoc


rawinput = aoc.read_input(2)

result = 0
for line in rawinput.splitlines():
    values = list(map(lambda d: int(d), line.split('\t')))
    result = result + (max(values) - min(values))

print(result)
