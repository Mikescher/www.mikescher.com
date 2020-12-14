#!/usr/bin/env python3

import aoc
import re

class Group:
    
    def __init__(self):
        self.groups = []
        self.garbages = []
    
    def fullscore(self, depth):
        fs = depth
        for grp in self.groups:
            fs += grp.fullscore(depth+1)
        return fs


def read_group(data: str):

    assert data[0] == '{'

    pos = 1

    result = Group()

    while True:
        if data[pos] == '}':
            return result, pos+1
        elif data[pos] == '<':
            grb, npos = read_garbage(data[pos:])
            result.garbages.append(grb)
            pos += npos
            if data[pos] == ',':
                pos += 1
        elif data[pos] == '{':
            grp, npos = read_group(data[pos:])
            result.groups.append(grp)
            pos += npos
            if data[pos] == ',':
                pos += 1
        else:
            assert False


def read_garbage(data: str):
    assert data[0] == '<'
    pos = 1

    escaped = False
    while True:
        if escaped:
            escaped = False
        elif data[pos] == '>':
            return data[1:pos-1], pos+1
        elif data[pos] == '!': 
            escaped = True
        pos+=1


rawinput = aoc.read_input(9)

data, _ = read_group(rawinput)

print(data.fullscore(1))



