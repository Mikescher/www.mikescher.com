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


def calc_weight_rec(fdatamap, key):
    w = fdatamap[key][1]
    for child in fdatamap[key][2]:
        w += calc_weight_rec(fdatamap, child)
    return w


def is_balanced(fdatamap, key):
    if len(fdatamap[key][2]) == 0:
        return True
    subweights = list(map(lambda x: calc_weight_rec(fdatamap, x), fdatamap[key][2]))
    return len(set(subweights)) == 1


rawinput = aoc.read_input(7)

data = list(map(lambda x: parse_line(x), rawinput.splitlines()))
datamap = {x[0]: x for x in data}

rnodes = list(map(lambda x: x[0], data))

for datum in data:
    if is_balanced(datamap, datum[0]):
        continue
    weights = list(map(lambda x: calc_weight_rec(datamap, x), datum[2]))
    if len(set(weights)) != 1:
        for idx, w in enumerate(weights):
            if weights.count(w) != 1:
                continue
            if not is_balanced(datamap, datum[2][idx]):
                continue
            real_direct_subweight = datamap[datum[2][idx]][1]
            real_full_subweight = w
            wanted_full_subweight = weights[(idx+1) % len(weights)]
            wanted_direct_subweight = real_direct_subweight + (wanted_full_subweight - real_full_subweight)

            # print(datamap[datum[2][idx]])
            # print(real_full_subweight, real_direct_subweight, wanted_full_subweight, wanted_direct_subweight)
            # print(datum, weights)
            print(wanted_direct_subweight)
