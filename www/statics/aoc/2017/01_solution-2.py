#!/usr/bin/env python3

import aoc


rawinput = aoc.read_input(1)

inlen = len(rawinput)
digitsum = 0
for idx in range(0, inlen):
    if rawinput[idx] == rawinput[(idx + inlen//2) % inlen]:
        digitsum = digitsum + int(rawinput[idx])

print(digitsum)
