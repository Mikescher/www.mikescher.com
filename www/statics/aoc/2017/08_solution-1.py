#!/usr/bin/env python3

import aoc
import re


def parse_line(line: str):
    p = re.compile('(?P<r1>[a-z]+) (?P<op>inc|dec) (?P<param>-?[0-9]+) if (?P<r2>[a-z]+) (?P<cmp>[!=<>]+) (?P<arg>-?[0-9]+)')
    m = p.match(line)

    if m is None: raise "No match"

    return m.group('r1'), m.group('op'), int(m.group('param')), m.group('r2'), m.group('cmp'), int(m.group('arg'))


def evaluate_cmp(mem: dict, reg: str, op: str, arg: str):
    if not reg in mem:
        mem[reg] = 0
    if op == "==":
        return (mem[reg] == arg)
    if op == "!=":
        return (mem[reg] != arg)
    if op == "<":
        return (mem[reg] < arg)
    if op == ">":
        return (mem[reg] > arg)
    if op == "<=":
        return (mem[reg] <= arg)
    if op == ">=":
        return (mem[reg] >= arg)
    raise "invalid op: " + op


def exec_cmd(mem: dict, reg: str, op: str, arg: str):
    if not reg in mem:
        mem[reg] = 0
    if op == "inc":
        mem[reg] = mem[reg] + arg
    elif op == "dec":
        mem[reg] = mem[reg] - arg
    else:
        raise "invalid op: " + op



rawinput = aoc.read_input(8)

data = list(map(lambda x: parse_line(x), rawinput.splitlines()))

registers = dict()

for line in data:
    if evaluate_cmp(registers, line[3], line[4], line[5]):
        exec_cmd(registers, line[0], line[1], line[2])


max = None

for v in registers.values():
    if max is None or v > max:
        max = v

print(max)



