#!/usr/bin/env python3

import aoc


rawinput = aoc.read_input(1)

rawinput = rawinput + rawinput[0]

digitsum = 0
for idx in range(1, len(rawinput)):
    if rawinput[idx-1] == rawinput[idx]:
        digitsum = digitsum + int(rawinput[idx])

print(digitsum)
