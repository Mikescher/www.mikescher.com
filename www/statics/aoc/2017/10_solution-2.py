#!/usr/bin/env python3

import aoc

def twist(nums: list, nstart: int, nlen: int):
    sublist = list()
    for i in range(0, nlen):
        sublist.append(nums[(i+nstart) % len(nums)])
    for i in range(0, nlen):
        nums[(i+nstart) % len(nums)] = sublist[nlen-i-1]


rawinput = aoc.read_input(10).strip()

inputlengths = list(map(lambda x: ord(x), rawinput))
inputlengths.append(17)
inputlengths.append(31)
inputlengths.append(73)
inputlengths.append(47)
inputlengths.append(23)

numberslist = list(range(0, 256))

currpos = 0
skipsize = 0
for iround in range(0,64):
    for ilen in inputlengths:
        twist(numberslist, currpos, ilen)
        currpos = (currpos + ilen + skipsize) % len(numberslist)
        skipsize += 1

densehash = list()

for i1 in range(0, 16):
    xor = 0
    for i2 in range(0, 16):
        xor = xor ^ numberslist[i1*16 + i2]
    densehash.append(xor)

hex = "".join(map(lambda n: "%0.2x" % n, densehash))

print(hex)



