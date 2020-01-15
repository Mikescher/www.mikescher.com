#!/usr/bin/env python3

import aoc


def parse_line(line: str):
    childs = list()
    if ' -> ' in line:
        split1 = line.split(' -> ')
        childs = list(map(lambda x: x.strip(), split1[1].strip().split(',')))
        line = split1[0]

    line = line.strip()
    line = line.replace('(', '').replace(')', '')
    split2 = line.split(' ')
    name = split2[0].strip()
    weight = int(split2[1].strip())
    return name, weight, childs


rawinput = aoc.read_input(7)

data = list(map(lambda x: parse_line(x), rawinput.splitlines()))

rnodes = list(map(lambda x: x[0], data))

for datum in data:
    for xnode in datum[2]:
        rnodes.remove(xnode)

assert len(rnodes) == 1
print(rnodes[0])



