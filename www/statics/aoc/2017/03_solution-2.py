#!/usr/bin/env python3

import aoc
import math
import itertools


# https://stackoverflow.com/questions/10094745
def spiralpos(n):
    k = math.ceil((math.sqrt(n) - 1) / 2)
    t = 2 * k + 1
    m = t ** 2

    t -= 1

    if n >= m - t:
        return k - (m - n), -k

    m -= t

    if n >= m - t:
        return -k, -k + (m - n)

    m -= t

    if n >= m - t:
        return -k + (m - n), k

    return k, k - (m - n - t)


rawinput = aoc.read_input(3)
intinput = int(rawinput)

dirs = [
    (-1, -1), (00, -1), (+1, -1),
    (-1, 00),           (+1, 00),
    (-1, +1), (00, +1), (+1, +1),
]

grid = dict()
grid[(0, 0)] = 1

for i in itertools.count(2):
    x, y = spiralpos(i)
    v = 0
    for dx, dy in dirs:
        if (x + dx, y + dy) in grid:
            v += grid[(x + dx, y + dy)]
    if v > intinput:
        print(v)
        exit()
    grid[(x, y)] = v
