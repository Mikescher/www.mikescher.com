#!/usr/bin/env python3

import aoc
import math


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

x, y = spiralpos(intinput)

print(abs(x) + abs(y))
