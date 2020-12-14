#!/usr/bin/env python3

import aoc

def twist(nums: list, nstart: int, nlen: int):
    sublist = list()
    for i in range(0, nlen):
        sublist.append(nums[(i+nstart) % len(nums)])
    for i in range(0, nlen):
        nums[(i+nstart) % len(nums)] = sublist[nlen-i-1]


rawinput = aoc.read_input(10)

inputlengths = list(map(lambda x: int(x), rawinput.split(',')))

numberslist = list(range(0, 256))

currpos = 0
skipsize = 0
for ilen in inputlengths:
    twist(numberslist, currpos, ilen)
    currpos = (currpos + ilen + skipsize) % len(numberslist)
    skipsize += 1

#print(numberslist)
print(numberslist[0] * numberslist[1])



